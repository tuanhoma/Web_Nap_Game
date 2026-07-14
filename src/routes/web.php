<?php

/**
 * Web Routes
 * Định nghĩa tất cả routes của ứng dụng
 */

use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

// ============ Public Routes ============

// Trang chủ
$router->get('', \App\Controllers\HomeController::class, 'index');

// Auth
$router->get('login', \App\Controllers\AuthController::class, 'showLogin');
$router->post('login', \App\Controllers\AuthController::class, 'login');
$router->get('register', \App\Controllers\AuthController::class, 'showRegister');
$router->post('register', \App\Controllers\AuthController::class, 'register');
$router->get('logout', \App\Controllers\AuthController::class, 'logout');

// ============ User Routes (Yêu cầu đăng nhập) ============

// Dashboard
$router->get('dashboard', \App\Controllers\DashboardController::class, 'index', [AuthMiddleware::class]);
$router->post('dashboard/report', \App\Controllers\DashboardController::class, 'submitReport', [AuthMiddleware::class]);

// Top-up
$router->get('topup', \App\Controllers\TopupController::class, 'showGames', [AuthMiddleware::class]);
$router->get('topup/{gameId}', \App\Controllers\TopupController::class, 'showPackages', [AuthMiddleware::class]);
$router->post('topup/confirm', \App\Controllers\TopupController::class, 'confirm', [AuthMiddleware::class]);
$router->get('topup/confirm', \App\Controllers\TopupController::class, 'confirm', [AuthMiddleware::class]);

// Payment
$router->post('payment/create', \App\Controllers\PaymentController::class, 'create', [AuthMiddleware::class]);
$router->get('payment/callback', \App\Controllers\PaymentController::class, 'callback');
$router->post('payment/ipn', \App\Controllers\PaymentController::class, 'ipn');

// ============ Admin Routes (Yêu cầu quyền admin) ============

$router->get('admin', \App\Controllers\AdminController::class, 'dashboard', [AdminMiddleware::class]);
$router->get('admin/users', \App\Controllers\AdminController::class, 'users', [AdminMiddleware::class]);
$router->get('admin/users/{id}', \App\Controllers\AdminController::class, 'userDetail', [AdminMiddleware::class]);
$router->get('admin/orders', \App\Controllers\AdminController::class, 'orders', [AdminMiddleware::class]);
$router->get('admin/packages', \App\Controllers\AdminController::class, 'packages', [AdminMiddleware::class]);
$router->post('admin/packages/create', \App\Controllers\AdminController::class, 'createPackage', [AdminMiddleware::class]);
$router->get('admin/reports', \App\Controllers\AdminController::class, 'reports', [AdminMiddleware::class]);
$router->get('admin/reports/{id}', \App\Controllers\AdminController::class, 'reportDetail', [AdminMiddleware::class]);

