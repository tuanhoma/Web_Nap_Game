<?php use App\Helpers\View; use App\Helpers\Session; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Quản lý Gói Nạp</h5>
    <button type="button" class="btn btn-glow" data-bs-toggle="modal" data-bs-target="#createPackageModal">
        <i class="bi bi-plus-lg me-1"></i>Thêm gói mới
    </button>
</div>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Game</th>
                    <th>Tên gói</th>
                    <th>Số lượng (đơn vị)</th>
                    <th>Giá tiền</th>
                    <th>Trạng thái</th>
                    <th>Thời gian tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $pkg): ?>
                <tr>
                    <td><?= $pkg['id'] ?></td>
                    <td><strong><?= View::e($pkg['game_name']) ?></strong></td>
                    <td><?= View::e($pkg['name']) ?></td>
                    <td class="text-warning fw-bold"><?= number_format($pkg['diamonds']) ?></td>
                    <td class="text-info fw-bold"><?= View::money($pkg['price']) ?></td>
                    <td>
                        <?php if ($pkg['status'] === 'active'): ?>
                        <span class="badge bg-success">Hoạt động</span>
                        <?php else: ?>
                        <span class="badge bg-danger">Tạm khóa</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small"><?= View::datetime($pkg['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($packages)): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Chưa có gói nạp nào</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create Package -->
<div class="modal fade" id="createPackageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Thêm gói nạp mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/packages/create" method="POST">
                <?= Session::csrfField() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Chọn Game</label>
                        <select class="form-select bg-dark text-light border-secondary" name="game_id" required>
                            <option value="">-- Chọn Game --</option>
                            <?php foreach ($games as $game): ?>
                            <option value="<?= $game['id'] ?>"><?= View::e($game['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên gói</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" name="name" placeholder="VD: Gói 100 Kim Cương" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số lượng (đơn vị)</label>
                            <input type="number" class="form-control bg-dark text-light border-secondary" name="diamonds" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá tiền (VNĐ)</label>
                            <input type="number" class="form-control bg-dark text-light border-secondary" name="price" min="1000" step="1000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả (tùy chọn)</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" name="description">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu gói nạp</button>
                </div>
            </form>
        </div>
    </div>
</div>
