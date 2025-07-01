<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\RedirectResponse. If it does,
     * script execution will end and that Response will
     * be sent back to the client, allowing the filter
     * to "short circuit" the normal process flow.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            // Log percobaan akses tanpa login
            log_message('warning', 'Percobaan akses halaman admin tanpa login dari IP: ' . $request->getIPAddress());
            
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman admin.');
        }

        // Cek timeout session (30 menit)
        $loginTime = session()->get('login_time');
        if ($loginTime && (time() - $loginTime) > 1800) { // 30 menit = 1800 detik
            session()->destroy();
            log_message('info', 'Session timeout untuk user: ' . session()->get('username'));
            return redirect()->to('/auth/login')->with('error', 'Session telah habis. Silakan login kembali.');
        }

        // Update login time untuk extend session
        session()->set('login_time', time());

        // Jika ada parameter untuk cek role admin
        if ($arguments && in_array('admin', $arguments)) {
            if (session()->get('hak_akses') !== 'admin') {
                return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki hak akses admin.');
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Log aktivitas user untuk audit trail
        if (session()->get('isLoggedIn')) {
            $logData = [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'url' => (string) $request->getUri(),
                'method' => $request->getMethod(),
                'ip_address' => $request->getIPAddress(),
                'user_agent' => $request->getServer('HTTP_USER_AGENT'),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            // Bisa disimpan ke database atau log file
            log_message('info', 'User Activity: ' . json_encode($logData));
        }
    }
}
