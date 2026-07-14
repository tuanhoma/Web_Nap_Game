<?php

namespace App\Repositories;

/**
 * UserRepository
 * Truy vấn dữ liệu bảng users
 */
class UserRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    /**
     * Tìm user theo ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm user theo username
     */
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tạo user mới
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password_hash, full_name, role, balance) 
             VALUES (:username, :email, :password_hash, :full_name, :role, :balance)"
        );
        $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'full_name' => $data['full_name'],
            'role' => $data['role'] ?? 'user',
            'balance' => $data['balance'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Cập nhật số dư user
     */
    public function updateBalance(int $userId, float $amount): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET balance = balance + :amount, updated_at = NOW() WHERE id = :id"
        );
        return $stmt->execute(['amount' => $amount, 'id' => $userId]);
    }

    /**
     * Lấy tất cả users (admin)
     */
    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT id, username, email, full_name, role, balance, created_at, updated_at 
             FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Tìm kiếm users theo username, email hoặc full_name
     * [SECURITY FIX GTU-060726-02] Dùng Prepared Statement thay vì ghép chuỗi
     * - TRƯỚC (lỗi): WHERE username='$query'  => SQL Injection
     * - SAU  (fix) : WHERE ... LIKE :q         => Parameterized Query
     */
    public function search(string $query, int $limit = 50, int $offset = 0): array
    {
        // [SECURITY FIX GTU-060726-02] Prepared Statement — tham số được bind riêng,
        // không bao giờ ghép vào chuỗi SQL => loại bỏ hoàn toàn SQL Injection
        $stmt = $this->db->prepare(
            "SELECT id, username, email, full_name, role, balance, created_at, updated_at
             FROM users
             WHERE username  LIKE :q
                OR email     LIKE :q
                OR full_name LIKE :q
             ORDER BY created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $likeQuery = '%' . $query . '%';
        $stmt->bindValue('q',      $likeQuery,  \PDO::PARAM_STR);
        $stmt->bindValue('limit',  $limit,      \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset,     \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Đếm tổng số users
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Cập nhật thông tin user
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        foreach (['full_name', 'email', 'role', 'balance'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[$field] = $data[$field];
            }
        }

        if (empty($fields)) return false;

        $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
