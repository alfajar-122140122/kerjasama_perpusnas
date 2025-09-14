<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->has('user_id')) {
            // If this is an AJAX request, return JSON response
            if ($request->hasHeader('X-Requested-With') && $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return service('response')
                    ->setStatusCode(401)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Unauthorized. Please login first.',
                        'redirect' => '/auth/login'
                    ]);
            }
            
            // For regular requests, redirect to login
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user has admin role
        if (session()->get('role') !== 'admin') {
            // If this is an AJAX request, return JSON response
            if ($request->hasHeader('X-Requested-With') && $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return service('response')
                    ->setStatusCode(403)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Access denied. Admin privileges required.',
                        'redirect' => '/auth/login'
                    ]);
            }
            
            // For regular requests, redirect to login
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // Update last activity
        session()->set('last_activity', time());
        
        return null;
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
        // Nothing to do here
        return null;
    }
}
