<?php

namespace App\Middleware;

use App\Helpers\Session;

/**
 * AdminMiddleware
 * Kiểm tra user có quyền admin không
 */
class AdminMiddleware
{
    public function handle(): bool
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục.');
            header('Location: /login');
            exit;
        }

        if (!Session::isAdmin()) {
            Session::flash('error', 'Bạn không có quyền truy cập trang này.');
            header('Location: /dashboard');
            exit;
        }

        return true;
    }
}
