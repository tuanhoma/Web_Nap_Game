<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Services\GameService;

/**
 * HomeController
 * Trang chủ và danh sách game
 */
class HomeController
{
    private GameService $gameService;

    public function __construct()
    {
        $this->gameService = new GameService();
    }

    /**
     * Trang chủ - hiển thị danh sách game
     */
    public function index(): void
    {
        $games = $this->gameService->getActiveGames();

        View::render('home/index', [
            'title' => 'Trang chủ - Cổng Nạp Game',
            'games' => $games,
        ]);
    }
}
