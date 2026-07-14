<?php use App\Helpers\View; use App\Helpers\Session; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-0">
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
                <span class="me-2"><?= $icon ?></span><?= View::e($game['name']) ?>
            </h2>
            <p class="text-muted">Chọn gói nạp phù hợp</p>
        </div>
        <a href="/topup" class="btn btn-outline-glow btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Chọn game khác
        </a>
    </div>
    
    <form action="/topup/confirm" method="POST">
        <?= Session::csrfField() ?>
        <input type="hidden" name="package_id" id="selected_package_id" value="">
        
        <div class="row g-3 mb-4">
            <?php foreach ($packages as $index => $pkg): ?>
            <div class="col-lg-4 col-md-6">
                <div class="package-card animate-fade-in animate-delay-<?= ($index % 4) + 1 ?>" 
                     data-package-id="<?= $pkg['id'] ?>">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold mb-1"><?= View::e($pkg['name']) ?></h5>
                            <p class="text-muted small mb-0"><?= View::e($pkg['description'] ?? '') ?></p>
                        </div>
                        <i class="bi bi-gem text-warning fs-4"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <span class="package-diamonds"><?= number_format($pkg['diamonds']) ?></span>
                            <span class="text-muted small ms-1">đơn vị</span>
                        </div>
                        <div class="package-price"><?= View::money($pkg['price']) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-glow btn-lg px-5" id="btn-confirm" disabled>
                <i class="bi bi-cart-check me-2"></i>Tiếp tục thanh toán
            </button>
        </div>
    </form>
</div>
