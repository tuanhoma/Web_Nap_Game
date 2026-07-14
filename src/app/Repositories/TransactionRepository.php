<?php

namespace App\Repositories;

/**
 * TransactionRepository
 * Truy vấn dữ liệu bảng transactions
 */
class TransactionRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    /**
     * Tạo transaction mới
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO transactions (user_id, order_id, type, amount, description) 
             VALUES (:user_id, :order_id, :type, :amount, :description)"
        );
        $stmt->execute([
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id'] ?? null,
            'type' => $data['type'] ?? 'topup',
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Lấy transactions của user
     */
    public function getByUserId(int $userId, int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM transactions 
             WHERE user_id = :user_id 
             ORDER BY created_at DESC 
             LIMIT :limit"
        );
        $stmt->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Lấy tất cả transactions (admin)
     */
    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT t.*, u.username 
             FROM transactions t
             JOIN users u ON t.user_id = u.id
             ORDER BY t.created_at DESC 
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
