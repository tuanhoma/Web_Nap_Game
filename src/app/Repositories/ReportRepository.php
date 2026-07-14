<?php

namespace App\Repositories;

/**
 * ReportRepository
 * Truy vấn dữ liệu bảng reports
 */
class ReportRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Database::getConnection();
    }

    /**
     * Tạo báo cáo mới
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO reports (user_id, title, content) 
             VALUES (:user_id, :title, :content)"
        );
        $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Lấy tất cả báo cáo (admin)
     */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT r.*, u.username, u.full_name 
             FROM reports r 
             JOIN users u ON r.user_id = u.id 
             ORDER BY r.created_at DESC"
        );
        return $stmt->fetchAll();
    }

    /**
     * Tìm báo cáo theo ID (admin)
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT r.*, u.username, u.full_name 
             FROM reports r 
             JOIN users u ON r.user_id = u.id 
             WHERE r.id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
