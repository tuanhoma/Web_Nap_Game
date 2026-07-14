<?php use App\Helpers\View; use App\Helpers\Session; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-0"><i class="bi bi-lightning-charge me-2 text-warning"></i>Chọn Game Nạp</h2>
            <p class="text-muted">Chọn game bạn muốn nạp tiền</p>
        </div>
        <a href="/dashboard" class="btn btn-outline-glow btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Dashboard
        </a>
    </div>
    
    <div class="row g-4">
        <?php foreach ($games as $index => $game): ?>
        <div class="col-lg-4 col-md-6">
            <a href="/topup/<?= $game['id'] ?>" class="text-decoration-none">
                <div class="game-card animate-fade-in animate-delay-<?= ($index % 4) + 1 ?>">
                    <div class="game-image-wrapper">
                        <?php 
                        $gameIcons = [
                            'lien-quan-mobile' => '⚔️',
                            'free-fire' => '🔥',
                            'roblox' => '🎮',
                            'genshin-impact' => '🌟',
                            'pubg-mobile' => '🎯',
                        ];
                        $icon = $gameIcons[$game['slug']] ?? '🎮';
                        ?>
                        <div class="game-icon-placeholder">
                            <span style="font-size: 4rem;"><?= $icon ?></span>
                        </div>
                    </div>
                    <div class="game-info">
                        <h5 class="game-name text-white"><?= View::e($game['name']) ?></h5>
                        <p class="text-muted small mb-2"><?= View::e($game['description'] ?? '') ?></p>
                        <span class="game-badge"><i class="bi bi-lightning-charge me-1"></i>CHỌN GÓI</span>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
