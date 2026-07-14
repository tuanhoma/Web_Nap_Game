<?php use App\Helpers\View; use App\Helpers\Session; ?>

<div class="container py-4">
    <!-- Welcome + Balance -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="balance-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="balance-label mb-1">
                            <i class="bi bi-wallet2 me-2"></i>Số dư tài khoản
                        </p>
                        <div class="balance-amount"><?= View::money($user['balance']) ?></div>
                        <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.7); position: relative; z-index: 1;">
                            Xin chào, <strong><?= View::e($user['full_name']) ?></strong> 👋
                        </p>
                    </div>
                    <a href="/topup" class="btn btn-light btn-lg fw-bold" style="position: relative; z-index: 1;">
                        <i class="bi bi-lightning-charge me-1"></i>Nạp Game
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <h6 class="text-muted mb-3"><i class="bi bi-person-badge me-2"></i>Thông tin tài khoản</h6>
                <div class="mb-2">
                    <small class="text-muted">Username:</small>
                    <div class="fw-bold"><?= View::e($user['username']) ?></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Email:</small>
                    <div class="fw-bold"><?= View::e($user['email']) ?></div>
                </div>
                <div>
                    <small class="text-muted">Ngày tham gia:</small>
                    <div class="fw-bold"><?= View::datetime($user['created_at']) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch sử đơn hàng -->
    <div class="glass-card p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-info"></i>Lịch sử nạp game</h5>
        
        <?php if (empty($orders)): ?>
        <div class="text-center py-4">
            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-2">Chưa có giao dịch nào. <a href="/topup">Nạp game ngay!</a></p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Game</th>
                        <th>Gói nạp</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><span class="text-muted">#<?= $order['id'] ?></span></td>
                        <td class="fw-semibold"><?= View::e($order['game_name']) ?></td>
                        <td><?= View::e($order['package_name']) ?></td>
                        <td class="fw-bold text-info"><?= View::money($order['amount']) ?></td>
                        <td>
                            <?php
                            $statusClass = match($order['status']) {
                                'success' => 'badge-success',
                                'failed' => 'badge-failed',
                                default => 'badge-pending',
                            };
                            $statusText = match($order['status']) {
                                'success' => 'Thành công',
                                'failed' => 'Thất bại',
                                default => 'Đang xử lý',
                            };
                            ?>
                            <span class="badge-status <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td class="text-muted"><?= View::datetime($order['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Form gửi báo cáo -->
    <div class="glass-card p-4 mb-4">
        <h5 class="fw-bold mb-1"><i class="bi bi-flag-fill me-2 text-warning"></i>Gửi Báo cáo / Hỗ trợ</h5>
        <p class="text-muted small mb-4">Gặp vấn đề? Hãy gửi báo cáo để đội ngũ hỗ trợ xử lý sớm nhất.</p>
        <form method="POST" action="/dashboard/report" id="reportForm">
            <div class="mb-3">
                <label for="report_title" class="form-label fw-semibold">
                    <i class="bi bi-pencil-square me-1"></i>Tiêu đề báo cáo
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="report_title"
                    name="title"
                    placeholder="VD: Lỗi thanh toán không phản hồi..."
                    required
                >
            </div>
            <div class="mb-3">
                <label for="report_content" class="form-label fw-semibold">
                    <i class="bi bi-textarea-resize me-1"></i>Nội dung chi tiết
                </label>
                <textarea
                    class="form-control"
                    id="report_content"
                    name="content"
                    rows="5"
                    placeholder="Mô tả chi tiết vấn đề bạn gặp phải..."
                    required
                ></textarea>
                <div class="form-text text-muted">Hãy mô tả càng chi tiết càng tốt để chúng tôi hỗ trợ nhanh hơn.</div>
            </div>
            <button type="submit" class="btn btn-accent px-4" id="submitReportBtn">
                <i class="bi bi-send-fill me-2"></i>Gửi báo cáo
            </button>
        </form>
    </div>
</div>
