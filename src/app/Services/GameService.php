<?php

namespace App\Services;

use App\Repositories\GameRepository;
use App\Repositories\PackageRepository;

/**
 * GameService
 * Xử lý logic liên quan đến game và gói nạp
 */
class GameService
{
    private GameRepository $gameRepo;
    private PackageRepository $packageRepo;

    public function __construct()
    {
        $this->gameRepo = new GameRepository();
        $this->packageRepo = new PackageRepository();
    }

    /**
     * Lấy danh sách game đang hoạt động
     */
    public function getActiveGames(): array
    {
        return $this->gameRepo->getActiveGames();
    }

    /**
     * Lấy thông tin game theo ID
     */
    public function getGameById(int $id): ?array
    {
        return $this->gameRepo->findById($id);
    }

    /**
     * Lấy gói nạp theo game ID
     */
    public function getPackagesByGameId(int $gameId): array
    {
        return $this->packageRepo->getByGameId($gameId);
    }

    /**
     * Lấy thông tin gói nạp theo ID
     */
    public function getPackageById(int $id): ?array
    {
        return $this->packageRepo->findById($id);
    }
}
