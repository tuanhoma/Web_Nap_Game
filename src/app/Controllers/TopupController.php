<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\View;
use App\Services\GameService;

/**
 * TopupController
 * Xử lý flow chọn game và gói nạp
 */
class TopupController
{
    private GameService $gameService;

    public function __construct()
    {
        $this->gameService = new GameService();
    }

    /**
     * Hiển thị danh sách game để nạp
     */
    public function showGames(): void
    {
        $games = $this->gameService->getActiveGames();

        View::render('topup/games', [
            'title' => 'Chọn Game Nạp',
            'games' => $games,
        ]);
    }

    /**
     * Hiển thị gói nạp theo game
     */
    public function showPackages(string $gameId): void
    {
        $game = $this->gameService->getGameById((int)$gameId);

        if (!$game) {
            Session::flash('error', 'Game không tồn tại.');
            header('Location: /topup');
            exit;
        }

        $packages = $this->gameService->getPackagesByGameId((int)$gameId);

        View::render('topup/packages', [
            'title' => 'Gói nạp - ' . $game['name'],
            'game' => $game,
            'packages' => $packages,
        ]);
    }

    /**
     * Xác nhận trước khi thanh toán
     */
    public function confirm(): void
    {
        $packageId = (int)($_POST['package_id'] ?? $_GET['package_id'] ?? 0);

        if (!$packageId) {
            Session::flash('error', 'Vui lòng chọn gói nạp.');
            header('Location: /topup');
            exit;
        }

        $package = $this->gameService->getPackageById($packageId);

        if (!$package) {
            Session::flash('error', 'Gói nạp không tồn tại.');
            header('Location: /topup');
            exit;
        }

        View::render('topup/confirm', [
            'title' => 'Xác nhận thanh toán',
            'package' => $package,
        ]);
    }
}
