<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\View;
use App\Helpers\Validator;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\GameRepository;
use App\Repositories\PackageRepository;
use App\Repositories\ReportRepository;

/**
 * AdminController
 * Quản trị hệ thống: users, orders, packages
 */
class AdminController
{
    private UserRepository $userRepo;
    private OrderRepository $orderRepo;
    private GameRepository $gameRepo;
    private PackageRepository $packageRepo;
    private ReportRepository $reportRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->orderRepo = new OrderRepository();
        $this->gameRepo = new GameRepository();
        $this->packageRepo = new PackageRepository();
        $this->reportRepo = new ReportRepository();
    }

    /**
     * Dashboard Admin - Tổng quan hệ thống
     */
    public function dashboard(): void
    {
        $stats = [
            'total_users' => $this->userRepo->count(),
            'total_orders' => $this->orderRepo->count(),
            'total_games' => $this->gameRepo->count(),
            'total_packages' => $this->packageRepo->count(),
            'total_revenue' => $this->orderRepo->totalRevenue(),
        ];

        $recentOrders = $this->orderRepo->getAll(10);

        View::render('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ], 'admin');
    }

    /**
     * Quản lý Users
     * [SECURITY FIX GTU-060726-02] Thêm validation $search trước khi truyền xuống repository
     */
    public function users(): void
    {
        // [SECURITY FIX GTU-060726-02] Validate input search
        // - Trim whitespace
        // - Giới hạn độ dài tối đa 100 ký tự
        // - Loại bỏ HTML tags (defense-in-depth)
        $search = trim($_GET['search'] ?? '');
        $search = strip_tags($search);
        if (mb_strlen($search) > 100) {
            $search = mb_substr($search, 0, 100);
        }

        if ($search !== '') {
            $users = $this->userRepo->search($search);
        } else {
            $users = $this->userRepo->getAll();
        }

        View::render('admin/users', [
            'title'  => 'Quản lý người dùng',
            'users'  => $users,
            'search' => $search,
        ], 'admin');
    }

    /**
     * Chi tiết User
     */
    public function userDetail(string $id): void
    {
        $user = $this->userRepo->findById((int)$id);

        if (!$user) {
            Session::flash('error', 'Không tìm thấy người dùng.');
            header('Location: /admin/users');
            exit;
        }

        $orders = $this->orderRepo->getByUserId((int)$id);

        View::render('admin/user-detail', [
            'title' => 'Chi tiết: ' . $user['username'],
            'user' => $user,
            'orders' => $orders,
        ], 'admin');
    }

    /**
     * Quản lý Orders
     */
    public function orders(): void
    {
        $orders = $this->orderRepo->getAll();

        View::render('admin/orders', [
            'title' => 'Quản lý giao dịch',
            'orders' => $orders,
        ], 'admin');
    }

    /**
     * Quản lý Packages
     */
    public function packages(): void
    {
        $packages = $this->packageRepo->getAll();
        $games = $this->gameRepo->getAll();

        View::render('admin/packages', [
            'title' => 'Quản lý gói nạp',
            'packages' => $packages,
            'games' => $games,
        ], 'admin');
    }

    /**
     * Tạo gói nạp mới
     */
    public function createPackage(): void
    {
        if (!Session::verifyCsrfToken($_POST['_csrf_token'] ?? '')) {
            Session::flash('error', 'Phiên làm việc không hợp lệ.');
            header('Location: /admin/packages');
            exit;
        }

        $validator = new Validator($_POST);
        $validator->required('game_id', 'Game')
                  ->required('name', 'Tên gói')
                  ->required('diamonds', 'Số lượng')
                  ->numeric('diamonds', 'Số lượng')
                  ->required('price', 'Giá')
                  ->numeric('price', 'Giá');

        if ($validator->fails()) {
            Session::flash('error', $validator->getFirstError());
            header('Location: /admin/packages');
            exit;
        }

        $this->packageRepo->create([
            'game_id' => (int)$_POST['game_id'],
            'name' => trim($_POST['name']),
            'diamonds' => (int)$_POST['diamonds'],
            'price' => (float)$_POST['price'],
            'description' => trim($_POST['description'] ?? ''),
        ]);

        Session::flash('success', 'Tạo gói nạp thành công!');
        header('Location: /admin/packages');
        exit;
    }

    /**
     * Danh sách tất cả báo cáo từ user
     */
    public function reports(): void
    {
        $reports = $this->reportRepo->getAll();

        View::render('admin/reports', [
            'title'   => 'Quản lý Báo cáo',
            'reports' => $reports,
        ], 'admin');
    }

    /**
     * Chi tiết một báo cáo
     * LƯU Ý: Nội dung được truyền thẳng vào View KHÔNG qua escape
     * => Admin sẽ bị Stored XSS khi mở trang này
     */
    public function reportDetail(string $id): void
    {
        $report = $this->reportRepo->findById((int)$id);

        if (!$report) {
            Session::flash('error', 'Không tìm thấy báo cáo.');
            header('Location: /admin/reports');
            exit;
        }

        View::render('admin/report-detail', [
            'title'  => 'Chi tiết Báo cáo #' . $report['id'],
            'report' => $report,
        ], 'admin');
    }
}
