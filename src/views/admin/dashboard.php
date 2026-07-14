<?php use App\Helpers\View; ?>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-value text-primary"><?= number_format($stats['total_users']) ?></div>
            <div class="stat-label">Tổng người dùng</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-receipt"></i>
            </div>
            <div class="stat-value text-warning"><?= number_format($stats['total_orders']) ?></div>
            <div class="stat-label">Tổng đơn hàng</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="bi bi-controller"></i>
            </div>
            <div class="stat-value text-info"><?= number_format($stats['total_games']) ?></div>
            <div class="stat-label">Game đang mở</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="stat-value text-success"><?= View::money($stats['total_revenue']) ?></div>
            <div class="stat-label">Tổng doanh thu</div>
        </div>
    </div>
</div>

<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Giao dịch gần đây</h5>
        <a href="/admin/orders" class="btn btn-outline-glow btn-sm">Xem tất cả</a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Game / Gói</th>
                    <th>Số tiền</th>
                    <th>Trạng thái</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><strong><?= View::e($order['username']) ?></strong></td>
                    <td>
                        <?= View::e($order['game_name']) ?><br>
                        <small class="text-muted"><?= View::e($order['package_name']) ?></small>
                    </td>
                    <td class="text-info fw-bold"><?= View::money($order['amount']) ?></td>
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
                    <td class="text-muted small"><?= View::datetime($order['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($recentOrders)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Chưa có giao dịch nào</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
