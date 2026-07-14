<?php use App\Helpers\View; ?>

<div class="container py-4">
    <div class="result-card animate-fade-in">
        <div class="result-icon success">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h3 class="fw-bold mb-2">Thanh Toán Thành Công!</h3>
        <p class="text-muted mb-4">Giao dịch đã được xử lý thành công. Đơn vị game đã được cộng vào tài khoản.</p>

        <?php if ($order): ?>
        <div class="text-start mb-4">
            <div class="confirm-item">
                <span class="label">Game</span>
                <span class="value"><?= View::e($order['game_name'] ?? '') ?></span>
            </div>
            <div class="confirm-item">
                <span class="label">Gói nạp</span>
                <span class="value"><?= View::e($order['package_name'] ?? '') ?></span>
            </div>
            <div class="confirm-item">
                <span class="label">Số tiền</span>
                <span class="value text-success fw-bold"><?= View::money($order['amount']) ?></span>
            </div>
            <div class="confirm-item">
                <span class="label">Mã giao dịch MoMo</span>
                <span class="value"><code><?= View::e($transId ?? '') ?></code></span>
            </div>
            <div class="confirm-item">
                <span class="label">Mã đơn hàng</span>
                <span class="value"><code><?= View::e($order['order_id_momo'] ?? '') ?></code></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-3">
            <a href="/dashboard" class="btn btn-glow"><i class="bi bi-speedometer2 me-2"></i>Về Dashboard</a>
            <a href="/topup" class="btn btn-outline-glow"><i class="bi bi-lightning-charge me-2"></i>Nạp thêm</a>
        </div>
    </div>
</div>
