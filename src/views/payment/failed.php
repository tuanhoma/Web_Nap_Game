<?php use App\Helpers\View; ?>

<div class="container py-4">
    <div class="result-card animate-fade-in">
        <div class="result-icon failed">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <h3 class="fw-bold mb-2">Thanh Toán Thất Bại</h3>
        <p class="text-muted mb-4">Rất tiếc, giao dịch không thành công. Vui lòng thử lại.</p>

        <?php if (isset($message) && $message): ?>
        <div class="alert alert-danger glass-alert mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Lỗi:</strong> <?= View::e($message) ?>
            <?php if (isset($resultCode)): ?>
            <br><small class="text-muted">Mã lỗi: <?= $resultCode ?></small>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-3">
            <a href="/topup" class="btn btn-glow"><i class="bi bi-arrow-clockwise me-2"></i>Thử lại</a>
            <a href="/dashboard" class="btn btn-outline-glow"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        </div>
    </div>
</div>
