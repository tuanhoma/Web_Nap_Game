<?php use App\Helpers\View; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative">
        <h1 class="hero-title">
            <span class="text-gradient">Nạp Game</span> Nhanh Chóng<br>
            An Toàn & Uy Tín
        </h1>
        <p class="hero-subtitle">
            Cổng nạp game hàng đầu Việt Nam. Thanh toán qua MoMo, nhận ngay trong tích tắc.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/topup" class="btn btn-glow"><i class="bi bi-lightning-charge me-2"></i>Nạp Ngay</a>
            <a href="/register" class="btn btn-outline-glow"><i class="bi bi-person-plus me-2"></i>Đăng Ký</a>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-4">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="glass-card p-4 text-center animate-fade-in animate-delay-1">
                    <div class="mb-3"><i class="bi bi-lightning-charge-fill text-warning" style="font-size: 2.5rem;"></i></div>
                    <h5 class="fw-bold">Nạp Siêu Nhanh</h5>
                    <p class="text-muted small mb-0">Xử lý giao dịch chỉ trong vài giây sau khi thanh toán thành công.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 text-center animate-fade-in animate-delay-2">
                    <div class="mb-3"><i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i></div>
                    <h5 class="fw-bold">Bảo Mật Tuyệt Đối</h5>
                    <p class="text-muted small mb-0">Thanh toán qua MoMo với mã hóa HMAC SHA-256. An toàn 100%.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 text-center animate-fade-in animate-delay-3">
                    <div class="mb-3"><i class="bi bi-headset text-info" style="font-size: 2.5rem;"></i></div>
                    <h5 class="fw-bold">Hỗ Trợ 24/7</h5>
                    <p class="text-muted small mb-0">Đội ngũ hỗ trợ luôn sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Game List -->
<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0"><i class="bi bi-fire me-2 text-danger"></i>Game Phổ Biến</h2>
            <a href="/topup" class="btn btn-outline-glow btn-sm">Xem tất cả <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        
        <div class="row g-4">
            <?php foreach ($games as $index => $game): ?>
            <div class="col-lg-4 col-md-6">
                <a href="<?= \App\Helpers\Session::isLoggedIn() ? '/topup/' . $game['id'] : '/login' ?>" class="text-decoration-none">
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
                            <span class="game-badge">NẠP NGAY</span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 mt-4">
    <div class="container">
        <div class="glass-card p-5 text-center">
            <h3 class="fw-bold mb-3">Sẵn sàng nạp game? 🎮</h3>
            <p class="text-muted mb-4">Tạo tài khoản miễn phí và bắt đầu nạp game ngay hôm nay!</p>
            <a href="/register" class="btn btn-glow btn-lg"><i class="bi bi-rocket-takeoff me-2"></i>Bắt Đầu Ngay</a>
        </div>
    </div>
</section>
