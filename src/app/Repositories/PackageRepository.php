<?php

namespace App\Repositories;

/**
 * PackageRepository
 * Truy vấn dữ liệu bảng game_packages
 */
class PackageRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    /**
     * Lấy gói nạp theo game ID
     */
    public function getByGameId(int $gameId): array
    {
        $stmt = $this->db->prepare(
            "SELECT gp.*, g.name as game_name 
             FROM game_packages gp 
             JOIN games g ON gp.game_id = g.id 
             WHERE gp.game_id = :game_id AND gp.status = 'active' 
             ORDER BY gp.price ASC"
        );
        $stmt->execute(['game_id' => $gameId]);
        return $stmt->fetchAll();
    }

    /**
     * Tìm gói nạp theo ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT gp.*, g.name as game_name, g.slug as game_slug, g.image_url as game_image
             FROM game_packages gp 
             JOIN games g ON gp.game_id = g.id 
             WHERE gp.id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Lấy tất cả gói nạp (admin)
     */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT gp.*, g.name as game_name 
             FROM game_packages gp 
             JOIN games g ON gp.game_id = g.id 
             ORDER BY g.name ASC, gp.price ASC"
        );
        return $stmt->fetchAll();
    }

    /**
     * Tạo gói nạp mới
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO game_packages (game_id, name, diamonds, price, description) 
             VALUES (:game_id, :name, :diamonds, :price, :description)"
        );
        $stmt->execute([
            'game_id' => $data['game_id'],
            'name' => $data['name'],
            'diamonds' => $data['diamonds'],
            'price' => $data['price'],
            'description' => $data['description'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Cập nhật gói nạp
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE game_packages 
             SET name = :name, diamonds = :diamonds, price = :price, 
                 description = :description, status = :status, updated_at = NOW()
             WHERE id = :id"
        );
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'diamonds' => $data['diamonds'],
            'price' => $data['price'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
    }

    /**
     * Đếm tổng số packages
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM game_packages");
        return (int)$stmt->fetchColumn();
    }
}
