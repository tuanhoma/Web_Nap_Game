<?php

namespace App\Models;

/**
 * Order Model (Đơn hàng)
 */
class Order
{
    public ?int $id;
    public int $user_id;
    public int $package_id;
    public float $amount;
    public ?string $order_id_momo;
    public ?string $request_id;
    public string $status;
    public ?string $payment_url;
    public ?int $result_code;
    public ?string $message;
    public ?string $created_at;
    public ?string $updated_at;

    // Relations
    public ?string $username;
    public ?string $package_name;
    public ?string $game_name;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->user_id = (int)($data['user_id'] ?? 0);
        $this->package_id = (int)($data['package_id'] ?? 0);
        $this->amount = (float)($data['amount'] ?? 0);
        $this->order_id_momo = $data['order_id_momo'] ?? null;
        $this->request_id = $data['request_id'] ?? null;
        $this->status = $data['status'] ?? 'pending';
        $this->payment_url = $data['payment_url'] ?? null;
        $this->result_code = isset($data['result_code']) ? (int)$data['result_code'] : null;
        $this->message = $data['message'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->package_name = $data['package_name'] ?? null;
        $this->game_name = $data['game_name'] ?? null;
    }
}
