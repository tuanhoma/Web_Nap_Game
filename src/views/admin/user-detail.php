<?php use App\Helpers\View; ?>

<div class="mb-3">
    <a href="/admin/users" class="btn btn-outline-glow btn-sm"><i class="bi bi-arrow-left me-1"></i>Quay lại danh sách</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-4">Thông tin User</h5>
            <div class="mb-3">
                <label class="text-muted small">Username</label>
                <div class="fs-5 fw-bold"><?= View::e($user['username']) ?></div>
            </div>
            <div class="mb-3">
                <label class="text-muted small">Email</label>
                <div><?= View::e($user['email']) ?></div>
            </div>
            <div class="mb-3">
                <label class="text-muted small">Họ tên</label>
                <div><?= View::e($user['full_name']) ?></div>
            </div>
            <div class="mb-3">
                <label class="text-muted small">Vai trò</label>
                <div>
                    <?php if ($user['role'] === 'admin'): ?>
                    <span class="badge bg-danger">Admin</span>
                    <?php else: ?>
                    <span class="badge bg-secondary">User</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="text-muted small">Số dư hiện tại</label>
                <div class="fs-4 text-warning fw-bold"><?= View::money($user['balance']) ?></div>
            </div>
            <div>
                <label class="text-muted small">Ngày tham gia</label>
                <div><?= View::datetime($user['created_at']) ?></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-4">Lịch sử giao dịch</h5>
            <div class="table-responsive">
                <table class="table table-dark-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Game / Gói</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
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
                        <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Không có dữ liệu</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
