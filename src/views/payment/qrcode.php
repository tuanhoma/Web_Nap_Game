<?php use App\Helpers\View; ?>

<div class="container py-4 text-center">
    <div class="result-card animate-fade-in mx-auto">
        <h3 class="fw-bold mb-3">Thanh Toán Bằng MoMo</h3>
        <p class="text-muted mb-4">Mở ứng dụng MoMo và quét mã QR để thanh toán.</p>
        
        <div class="bg-white p-3 d-inline-block rounded mb-4">
            <img src="<?= View::e($qrCodeUrl) ?>" alt="QR Code" style="max-width: 250px;">
        </div>
        
        <div class="mb-4">
            <p class="mb-1"><strong><?= View::e($package['game_name']) ?> - <?= View::e($package['name']) ?></strong></p>
            <h4 class="text-primary fw-bold"><?= View::money($package['price']) ?></h4>
        </div>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= View::e($deeplink) ?>" class="btn btn-momo d-md-none"><i class="bi bi-wallet2 me-2"></i>Mở ứng dụng MoMo</a>
            <a href="/dashboard" class="btn btn-outline-glow"><i class="bi bi-arrow-left me-2"></i>Về Dashboard</a>
        </div>
        
        <div class="mt-4 text-muted small">
            <i class="bi bi-info-circle me-1"></i>Trạng thái giao dịch sẽ tự động cập nhật sau khi bạn thanh toán thành công.
        </div>
    </div>
</div>
