<?php

namespace App\Services;

use App\Repositories\UserRepository;

/**
 * AuthService
 * Xử lý logic đăng ký, đăng nhập, xác thực
 */
class AuthService
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    /**
     * Đăng ký tài khoản mới
     * @return array ['success' => bool, 'message' => string, 'user_id' => int|null]
     */
    public function register(array $data): array
    {
        // Kiểm tra username đã tồn tại
        if ($this->userRepo->findByUsername($data['username'])) {
            return ['success' => false, 'message' => 'Tên đăng nhập đã tồn tại.'];
        }

        // Kiểm tra email đã tồn tại
        if ($this->userRepo->findByEmail($data['email'])) {
            return ['success' => false, 'message' => 'Email đã được sử dụng.'];
        }

        // Hash mật khẩu
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        // Tạo user
        $userId = $this->userRepo->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $passwordHash,
            'full_name' => $data['full_name'],
            'role' => 'user',
            'balance' => 0,
        ]);

        return ['success' => true, 'message' => 'Đăng ký thành công!', 'user_id' => $userId];
    }

    /**
     * Đăng nhập
     * @return array ['success' => bool, 'message' => string, 'user' => array|null]
     */
    public function login(string $username, string $password): array
    {
        // Tìm user theo username
        $user = $this->userRepo->findByUsername($username);

        if (!$user) {
            return ['success' => false, 'message' => 'Tên đăng nhập không tồn tại.'];
        }

        // Xác thực mật khẩu
        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Mật khẩu không đúng.'];
        }

        return ['success' => true, 'message' => 'Đăng nhập thành công!', 'user' => $user];
    }

    /**
     * Lấy thông tin user hiện tại từ session
     */
    public function getCurrentUser(): ?array
    {
        $userId = \App\Helpers\Session::getUserId();
        if (!$userId) return null;
        return $this->userRepo->findById($userId);
    }
}
