<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\View;
use App\Helpers\Validator;
use App\Services\AuthService;

/**
 * AuthController
 * Xử lý đăng ký, đăng nhập, đăng xuất
 */
class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin(): void
    {
        if (Session::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        View::render('auth/login', ['title' => 'Đăng nhập']);
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(): void
    {
        // Verify CSRF
        if (!Session::verifyCsrfToken($_POST['_csrf_token'] ?? '')) {
            Session::flash('error', 'Phiên làm việc không hợp lệ. Vui lòng thử lại.');
            header('Location: /login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate
        $validator = new Validator($_POST);
        $validator->required('username', 'Tên đăng nhập')
                  ->required('password', 'Mật khẩu');

        if ($validator->fails()) {
            Session::flash('error', $validator->getFirstError());
            header('Location: /login');
            exit;
        }

        // Đăng nhập
        $result = $this->authService->login($username, $password);

        if (!$result['success']) {
            Session::flash('error', $result['message']);
            header('Location: /login');
            exit;
        }

        // Lưu session
        Session::setUser($result['user']);
        Session::flash('success', 'Đăng nhập thành công! Chào mừng ' . $result['user']['full_name']);

        // Redirect theo role
        if ($result['user']['role'] === 'admin') {
            header('Location: /admin');
        } else {
            header('Location: /dashboard');
        }
        exit;
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegister(): void
    {
        if (Session::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        View::render('auth/register', ['title' => 'Đăng ký tài khoản']);
    }

    /**
     * Xử lý đăng ký
     */
    public function register(): void
    {
        // Verify CSRF
        if (!Session::verifyCsrfToken($_POST['_csrf_token'] ?? '')) {
            Session::flash('error', 'Phiên làm việc không hợp lệ. Vui lòng thử lại.');
            header('Location: /register');
            exit;
        }

        // Validate input
        $validator = new Validator($_POST);
        $validator->required('username', 'Tên đăng nhập')
                  ->alphaNumeric('username', 'Tên đăng nhập')
                  ->minLength('username', 3, 'Tên đăng nhập')
                  ->maxLength('username', 50, 'Tên đăng nhập')
                  ->required('email', 'Email')
                  ->email('email', 'Email')
                  ->required('full_name', 'Họ và tên')
                  ->required('password', 'Mật khẩu')
                  ->minLength('password', 6, 'Mật khẩu')
                  ->matches('password_confirm', 'password', 'Xác nhận mật khẩu');

        if ($validator->fails()) {
            Session::flash('error', $validator->getFirstError());
            header('Location: /register');
            exit;
        }

        // Đăng ký
        $result = $this->authService->register([
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'full_name' => trim($_POST['full_name']),
            'password' => $_POST['password'],
        ]);

        if (!$result['success']) {
            Session::flash('error', $result['message']);
            header('Location: /register');
            exit;
        }

        Session::flash('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        header('Location: /login');
        exit;
    }

    /**
     * Đăng xuất
     */
    public function logout(): void
    {
        Session::destroy();
        session_start();
        Session::flash('success', 'Đã đăng xuất thành công.');
        header('Location: /login');
        exit;
    }
}
