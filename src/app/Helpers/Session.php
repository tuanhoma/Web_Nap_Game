<?php

namespace App\Helpers;

/**
 * Session Helper
 * Wrapper cho PHP session với flash messages và CSRF
 */
class Session
{
    /**
     * Lấy giá trị session
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set giá trị session
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Xóa giá trị session
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Kiểm tra key có tồn tại
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Hủy toàn bộ session
     */
    public static function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    // ========== Flash Messages ==========

    /**
     * Set flash message (chỉ hiển thị 1 lần)
     */
    public static function flash(string $type, string $message): void
    {
        $_SESSION['_flash'][$type] = $message;
    }

    /**
     * Lấy flash message và xóa
     */
    public static function getFlash(string $type): ?string
    {
        $message = $_SESSION['_flash'][$type] ?? null;
        unset($_SESSION['_flash'][$type]);
        return $message;
    }

    /**
     * Kiểm tra có flash message không
     */
    public static function hasFlash(string $type): bool
    {
        return isset($_SESSION['_flash'][$type]);
    }

    // ========== CSRF Protection ==========

    /**
     * Tạo CSRF token
     */
    public static function generateCsrfToken(): string
    {
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    /**
     * Lấy CSRF token hiện tại
     */
    public static function getCsrfToken(): string
    {
        return self::generateCsrfToken();
    }

    /**
     * Xác thực CSRF token
     */
    public static function verifyCsrfToken(string $token): bool
    {
        $sessionToken = $_SESSION['_csrf_token'] ?? '';
        if (hash_equals($sessionToken, $token)) {
            // Regenerate token sau khi verify thành công
            unset($_SESSION['_csrf_token']);
            return true;
        }
        return false;
    }

    /**
     * Tạo HTML input hidden cho CSRF
     */
    public static function csrfField(): string
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="_csrf_token" value="' . $token . '">';
    }

    // ========== Auth Helpers ==========

    /**
     * Kiểm tra đã đăng nhập chưa
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Lấy user ID đang đăng nhập
     */
    public static function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Lấy role của user đang đăng nhập
     */
    public static function getUserRole(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Kiểm tra có phải admin không
     */
    public static function isAdmin(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'admin';
    }

    /**
     * Lưu thông tin user vào session sau khi login
     */
    public static function setUser(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
    }
}
