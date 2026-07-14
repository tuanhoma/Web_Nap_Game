<?php
/**
 * Database Configuration
 * Kết nối PDO Singleton tới MySQL
 */

class Database
{
    private static ?PDO $instance = null;

    /**
     * Lấy PDO instance (Singleton)
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = $_ENV['DB_HOST'] ?? 'db';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $database = $_ENV['DB_DATABASE'] ?? 'game_topup';
            $username = $_ENV['DB_USERNAME'] ?? 'game_user';
            $password = $_ENV['DB_PASSWORD'] ?? '123456';

            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

            try {
                self::$instance = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]);
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                die("Không thể kết nối database. Vui lòng kiểm tra cấu hình.");
            }
        }

        return self::$instance;
    }

    /**
     * Đóng kết nối
     */
    public static function close(): void
    {
        self::$instance = null;
    }
}
