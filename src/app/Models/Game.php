<?php

namespace App\Models;

/**
 * Game Model
 */
class Game
{
    public ?int $id;
    public string $name;
    public string $slug;
    public ?string $image_url;
    public ?string $description;
    public string $status;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->slug = $data['slug'] ?? '';
        $this->image_url = $data['image_url'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->status = $data['status'] ?? 'active';
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }
}
