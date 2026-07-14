<?php

namespace App\Models;

/**
 * User Model
 */
class User
{
    public ?int $id;
    public string $username;
    public string $email;
    public string $password_hash;
    public string $full_name;
    public string $role;
    public float $balance;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password_hash = $data['password_hash'] ?? '';
        $this->full_name = $data['full_name'] ?? '';
        $this->role = $data['role'] ?? 'user';
        $this->balance = (float)($data['balance'] ?? 0);
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'role' => $this->role,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
