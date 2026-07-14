<?php use App\Helpers\View; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1"><i class="bi bi-flag-fill me-2 text-warning"></i>Danh sách Báo cáo</h5>
        <p class="text-muted small mb-0">Xem tất cả báo cáo được gửi từ người dùng.</p>
    </div>
    <span class="badge bg-warning text-dark fs-6"><?= count($reports) ?> báo cáo</span>
</div>

<div class="glass-card">
    <?php if (empty($reports)): ?>
    <div class="text-center py-5">
        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
        <p class="text-muted mt-3 mb-0">Chưa có báo cáo nào từ người dùng.</p>
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Người gửi</th>
                    <th>Tiêu đề</th>
                    <th style="width:180px">Thời gian</th>
                    <th style="width:120px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                <tr>
                    <td class="text-muted"><?= $report['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2" style="background: linear-gradient(135deg,#f59e0b,#ef4444); border-radius:50%; width:32px; height:32px; display:flex; align-items:center; justify-content:center; font-size:14px; color:#fff; flex-shrink:0;">
                                <?= strtoupper(substr($report['username'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-semibold"><?= View::e($report['username']) ?></div>
                                <small class="text-muted"><?= View::e($report['full_name']) ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <!-- [SECURITY FIX GTU-190626-01] Đã encode qua View::e() -->
                        <span><?= View::e($report['title']) ?></span>
                    </td>
                    <td class="text-muted small"><?= View::datetime($report['created_at']) ?></td>
                    <td>
                        <a href="/admin/reports/<?= $report['id'] ?>"
                           class="btn btn-outline-glow btn-sm"
                           id="view-report-<?= $report['id'] ?>">
                            <i class="bi bi-eye me-1"></i>Xem
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
