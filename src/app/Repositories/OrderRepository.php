<?php

namespace App\Repositories;

/**
 * OrderRepository
 * Truy vấn dữ liệu bảng orders
 */
class OrderRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    /**
     * Tạo đơn hàng mới
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO orders (user_id, package_id, amount, order_id_momo, request_id, status, payment_url) 
             VALUES (:user_id, :package_id, :amount, :order_id_momo, :request_id, :status, :payment_url)"
        );
        $stmt->execute([
            'user_id' => $data['user_id'],
            'package_id' => $data['package_id'],
            'amount' => $data['amount'],
            'order_id_momo' => $data['order_id_momo'] ?? null,
            'request_id' => $data['request_id'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'payment_url' => $data['payment_url'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Tìm order theo ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, u.username, gp.name as package_name, g.name as game_name
             FROM orders o
             JOIN users u ON o.user_id = u.id
             JOIN game_packages gp ON o.package_id = gp.id
             JOIN games g ON gp.game_id = g.id
             WHERE o.id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm order theo MoMo order ID
     */
    public function findByMomoOrderId(string $orderId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, u.username, gp.name as package_name, g.name as game_name
             FROM orders o
             JOIN users u ON o.user_id = u.id
             JOIN game_packages gp ON o.package_id = gp.id
             JOIN games g ON gp.game_id = g.id
             WHERE o.order_id_momo = :order_id LIMIT 1"
        );
        $stmt->execute(['order_id' => $orderId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Cập nhật trạng thái order
     */
    public function updateStatus(int $id, string $status, ?int $resultCode = null, ?string $message = null): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE orders SET status = :status, result_code = :result_code, 
             message = :message, updated_at = NOW() WHERE id = :id"
        );
        return $stmt->execute([
            'id' => $id,
            'status' => $status,
            'result_code' => $resultCode,
            'message' => $message,
        ]);
    }

    /**
     * Cập nhật payment URL
     */
    public function updatePaymentUrl(int $id, string $paymentUrl): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE orders SET payment_url = :payment_url, updated_at = NOW() WHERE id = :id"
        );
        return $stmt->execute(['id' => $id, 'payment_url' => $paymentUrl]);
    }

    /**
     * Lấy đơn hàng của user
     */
    public function getByUserId(int $userId, int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, gp.name as package_name, g.name as game_name
             FROM orders o
             JOIN game_packages gp ON o.package_id = gp.id
             JOIN games g ON gp.game_id = g.id
             WHERE o.user_id = :user_id
             ORDER BY o.created_at DESC
             LIMIT :limit"
        );
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Lấy tất cả đơn hàng (admin)
     */
    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, u.username, gp.name as package_name, g.name as game_name
             FROM orders o
             JOIN users u ON o.user_id = u.id
             JOIN game_packages gp ON o.package_id = gp.id
             JOIN games g ON gp.game_id = g.id
             ORDER BY o.created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Đếm tổng số orders
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM orders");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Tổng doanh thu (orders thành công)
     */
    public function totalRevenue(): float
    {
        $stmt = $this->db->query("SELECT COALESCE(SUM(amount), 0) FROM orders WHERE status = 'success'");
        return (float)$stmt->fetchColumn();
    }
}
