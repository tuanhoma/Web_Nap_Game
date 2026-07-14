<?php

namespace App\Models;

/**
 * Transaction Model (Lịch sử giao dịch)
 */
class Transaction
{
    public ?int $id;
    public int $user_id;
    public ?int $order_id;
    public string $type;
    public float $amount;
    public ?string $description;
    public ?string $created_at;

    // Relations
    public ?string $username;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->user_id = (int)($data['user_id'] ?? 0);
        $this->order_id = isset($data['order_id']) ? (int)$data['order_id'] : null;
        $this->type = $data['type'] ?? 'topup';
        $this->amount = (float)($data['amount'] ?? 0);
        $this->description = $data['description'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->username = $data['username'] ?? null;
    }
}
