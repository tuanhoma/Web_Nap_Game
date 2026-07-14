<?php use App\Helpers\View; ?>

<div class="glass-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h5 class="fw-bold mb-0">Danh sách người dùng</h5>
        <form method="GET" action="/admin/users" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
            <input type="text" name="search" class="form-control bg-dark text-light border-secondary" placeholder="Tìm tên, username, email..." value="<?= View::e($search ?? '') ?>">
            <button type="submit" class="btn btn-outline-info">
                <i class="bi bi-search"></i>
            </button>
            <?php if (!empty($search)): ?>
                <a href="/admin/users" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Họ và tên</th>
                    <th>Vai trò</th>
                    <th>Số dư</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><strong><?= View::e($user['username']) ?></strong></td>
                    <td><?= View::e($user['email']) ?></td>
                    <td><?= View::e($user['full_name']) ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                        <span class="badge bg-danger">Admin</span>
                        <?php else: ?>
                        <span class="badge bg-secondary">User</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-warning fw-bold"><?= View::money($user['balance']) ?></td>
                    <td>
                        <a href="/admin/users/<?= $user['id'] ?>" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Không tìm thấy người dùng nào</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
