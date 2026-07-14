<?php

namespace App\Models;

/**
 * GamePackage Model (Gói nạp)
 */
class GamePackage
{
    public ?int $id;
    public int $game_id;
    public string $name;
    public int $diamonds;
    public float $price;
    public ?string $description;
    public string $status;
    public ?string $created_at;
    public ?string $updated_at;

    // Relation
    public ?string $game_name;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->game_id = (int)($data['game_id'] ?? 0);
        $this->name = $data['name'] ?? '';
        $this->diamonds = (int)($data['diamonds'] ?? 0);
        $this->price = (float)($data['price'] ?? 0);
        $this->description = $data['description'] ?? null;
        $this->status = $data['status'] ?? 'active';
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->game_name = $data['game_name'] ?? null;
    }
}
