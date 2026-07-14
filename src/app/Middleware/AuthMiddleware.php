<?php

namespace App\Middleware;

use App\Helpers\Session;

/**
 * AuthMiddleware
 * Kiểm tra user đã đăng nhập chưa
 */
class AuthMiddleware
{
    public function handle(): bool
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục.');
            header('Location: /login');
            exit;
        }
        return true;
    }
}
