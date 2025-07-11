<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class LastActiveFilter implements FilterInterface
{
    /**
     * Update user's last_active timestamp if they're logged in
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if ($session->has('user_id')) {
            $userId = $session->get('user_id');
            
            // Update last_active timestamp
            $userModel = new UserModel();
            $userModel->update($userId, [
                'last_active' => date('Y-m-d H:i:s')
            ]);
        }
        
        return $request;
    }

    /**
     * No action needed after the controller
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
