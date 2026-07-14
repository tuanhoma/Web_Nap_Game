<?php use App\Helpers\View; use App\Helpers\Session; ?>

<div class="container py-4">
    <div class="confirm-card animate-fade-in">
        <div class="text-center mb-4">
            <i class="bi bi-shield-check text-gradient" style="font-size: 3rem;"></i>
            <h3 class="fw-bold mt-2">Xác Nhận Thanh Toán</h3>
            <p class="text-muted small">Kiểm tra thông tin trước khi thanh toán</p>
        </div>

        <div class="mb-4">
            <div class="confirm-item">
                <span class="label">Game</span>
                <span class="value"><?= View::e($package['game_name']) ?></span>
            </div>
            <div class="confirm-item">
                <span class="label">Gói nạp</span>
                <span class="value"><?= View::e($package['name']) ?></span>
            </div>
            <div class="confirm-item">
                <span class="label">Số lượng</span>
                <span class="value text-warning fw-bold"><?= number_format($package['diamonds']) ?> đơn vị</span>
            </div>
            <div class="confirm-item">
                <span class="label">Thành tiền</span>
                <span class="confirm-total"><?= View::money($package['price']) ?></span>
            </div>
        </div>

        <form action="/payment/create" method="POST" id="payment-form">
            <?= Session::csrfField() ?>
            <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
            
            <button type="submit" class="btn btn-momo w-100 mb-3">
                <i class="bi bi-wallet2 me-2"></i>Thanh toán qua MoMo
            </button>
        </form>

        <div class="text-center">
            <a href="/topup/<?= $package['game_id'] ?>" class="text-muted small">
                <i class="bi bi-arrow-left me-1"></i>Chọn gói khác
            </a>
        </div>

        <div class="mt-4 p-3 rounded" style="background: rgba(99,102,241,0.08);">
            <p class="small text-muted mb-1"><i class="bi bi-info-circle me-1"></i><strong>Lưu ý:</strong></p>
            <ul class="small text-muted mb-0 ps-3">
                <li>Bạn sẽ được chuyển sang trang MoMo để thanh toán</li>
                <li>Sau khi thanh toán thành công, đơn vị game sẽ được cộng tự động</li>
                <li>Đây là môi trường Sandbox (test), không mất tiền thật</li>
            </ul>
        </div>
    </div>
</div>
