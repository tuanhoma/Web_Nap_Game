<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;

/**
 * OrderService
 * Xử lý logic tạo và quản lý đơn hàng
 */
class OrderService
{
    private OrderRepository $orderRepo;
    private TransactionRepository $transRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepository();
        $this->transRepo = new TransactionRepository();
        $this->userRepo = new UserRepository();
    }

    /**
     * Tạo đơn hàng mới
     * @return int Order ID
     */
    public function createOrder(int $userId, int $packageId, float $amount): int
    {
        // Tạo mã đơn hàng duy nhất cho MoMo
        $orderIdMomo = 'GT' . time() . rand(1000, 9999);
        $requestId = 'REQ' . time() . rand(1000, 9999);

        return $this->orderRepo->create([
            'user_id' => $userId,
            'package_id' => $packageId,
            'amount' => $amount,
            'order_id_momo' => $orderIdMomo,
            'request_id' => $requestId,
            'status' => 'pending',
        ]);
    }

    /**
     * Xử lý thanh toán thành công
     * Cập nhật order status, tạo transaction, cộng balance
     */
    public function handlePaymentSuccess(string $momoOrderId, int $resultCode, string $message): bool
    {
        $order = $this->orderRepo->findByMomoOrderId($momoOrderId);

        if (!$order || $order['status'] !== 'pending') {
            return false;
        }

        // Cập nhật trạng thái order
        $this->orderRepo->updateStatus($order['id'], 'success', $resultCode, $message);

        // Tạo transaction record
        $this->transRepo->create([
            'user_id' => $order['user_id'],
            'order_id' => $order['id'],
            'type' => 'topup',
            'amount' => $order['amount'],
            'description' => "Nạp thành công: {$order['package_name']} - {$order['game_name']}",
        ]);

        // Cộng số dư cho user
        $this->userRepo->updateBalance($order['user_id'], $order['amount']);

        return true;
    }

    /**
     * Xử lý thanh toán thất bại
     */
    public function handlePaymentFailed(string $momoOrderId, int $resultCode, string $message): bool
    {
        $order = $this->orderRepo->findByMomoOrderId($momoOrderId);

        if (!$order || $order['status'] !== 'pending') {
            return false;
        }

        $this->orderRepo->updateStatus($order['id'], 'failed', $resultCode, $message);
        return true;
    }

    /**
     * Lấy đơn hàng theo ID
     */
    public function getOrderById(int $id): ?array
    {
        return $this->orderRepo->findById($id);
    }

    /**
     * Lấy đơn hàng theo MoMo order ID
     */
    public function getOrderByMomoId(string $momoOrderId): ?array
    {
        return $this->orderRepo->findByMomoOrderId($momoOrderId);
    }

    /**
     * Lấy đơn hàng của user
     */
    public function getUserOrders(int $userId): array
    {
        return $this->orderRepo->getByUserId($userId);
    }

    /**
     * Cập nhật payment URL cho order
     */
    public function updatePaymentUrl(int $orderId, string $url): bool
    {
        return $this->orderRepo->updatePaymentUrl($orderId, $url);
    }
}
