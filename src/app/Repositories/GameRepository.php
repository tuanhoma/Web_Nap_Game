<?php

namespace App\Repositories;

/**
 * GameRepository
 * Truy vấn dữ liệu bảng games
 */
class GameRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    /**
     * Lấy tất cả game active
     */
    public function getActiveGames(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM games WHERE status = 'active' ORDER BY name ASC"
        );
        return $stmt->fetchAll();
    }

    /**
     * Lấy tất cả games (admin)
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM games ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    /**
     * Tìm game theo ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm game theo slug
     */
    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Đếm tổng số games
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM games");
        return (int)$stmt->fetchColumn();
    }
}
