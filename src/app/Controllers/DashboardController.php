<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\View;
use App\Services\AuthService;
use App\Repositories\OrderRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\ReportRepository;

/**
 * DashboardController
 * Trang dashboard cho user
 */
class DashboardController
{
    private AuthService $authService;
    private OrderRepository $orderRepo;
    private TransactionRepository $transRepo;
    private ReportRepository $reportRepo;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->orderRepo = new OrderRepository();
        $this->transRepo = new TransactionRepository();
        $this->reportRepo = new ReportRepository();
    }

    /**
     * Trang Dashboard
     */
    public function index(): void
    {
        $user = $this->authService->getCurrentUser();
        $orders = $this->orderRepo->getByUserId($user['id']);
        $transactions = $this->transRepo->getByUserId($user['id']);

        View::render('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $user,
            'orders' => $orders,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Gửi báo cáo từ user
     * [SECURITY FIX GTU-190626-01] Đã thêm Input Validation + Sanitization
     * - Giới hạn độ dài input
     * - Loại bỏ HTML tags nguy hiểm bằng strip_tags() trước khi lưu DB
     * - Output Encoding ở view (View::e) là lớp bảo vệ chính
     */
    public function submitReport(): void
    {
        $user = $this->authService->getCurrentUser();

        // [SECURITY FIX GTU-190626-01] Lấy dữ liệu và trim
        $title   = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        // Validate: không được rỗng
        if (empty($title) || empty($content)) {
            Session::flash('error', 'Vui lòng nhập đầy đủ tiêu đề và nội dung báo cáo.');
            header('Location: /dashboard');
            exit;
        }

        // [SECURITY FIX GTU-190626-01] Validate độ dài tối đa
        if (mb_strlen($title) > 200) {
            Session::flash('error', 'Tiêu đề không được vượt quá 200 ký tự.');
            header('Location: /dashboard');
            exit;
        }

        if (mb_strlen($content) > 5000) {
            Session::flash('error', 'Nội dung không được vượt quá 5000 ký tự.');
            header('Location: /dashboard');
            exit;
        }

        // [SECURITY FIX GTU-190626-01] Input Sanitization — loại bỏ tất cả HTML tags
        // Defense-in-depth: Output encoding ở view (View::e) vẫn là lớp bảo vệ chính
        $title   = strip_tags($title);
        $content = strip_tags($content);

        // Lưu vào DB với dữ liệu đã được làm sạch
        $this->reportRepo->create([
            'user_id' => $user['id'],
            'title'   => $title,
            'content' => $content,
        ]);

        Session::flash('success', 'Báo cáo của bạn đã được gửi thành công!');
        header('Location: /dashboard');
        exit;
    }
}
