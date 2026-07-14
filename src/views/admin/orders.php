<?php use App\Helpers\View; ?>

<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Tất cả giao dịch</h5>
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
                    <th>Mã MoMo</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
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
                    <td>
                        <small class="text-muted"><?= View::e($order['order_id_momo']) ?></small>
                    </td>
                    <td class="text-muted small"><?= View::datetime($order['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Chưa có giao dịch nào</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
