<?php use App\Helpers\View; ?>

<div class="mb-4">
    <a href="/admin/reports" class="btn btn-outline-secondary btn-sm mb-3" id="backToReports">
        <i class="bi bi-arrow-left me-1"></i>Quay lại danh sách
    </a>

    <div class="glass-card p-4">
        <!-- Header thông tin người gửi -->
        <div class="d-flex align-items-start justify-content-between mb-4 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="d-flex align-items-center gap-3">
                <div style="background: linear-gradient(135deg,#f59e0b,#ef4444); border-radius:50%; width:50px; height:50px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#fff; flex-shrink:0; font-weight:700;">
                    <?= strtoupper(substr($report['username'], 0, 1)) ?>
                </div>
                <div>
                    <div class="fw-bold fs-5"><?= View::e($report['username']) ?></div>
                    <div class="text-muted small"><?= View::e($report['full_name']) ?></div>
                    <div class="text-muted small"><i class="bi bi-clock me-1"></i><?= View::datetime($report['created_at']) ?></div>
                </div>
            </div>
            <span class="badge bg-warning text-dark">Báo cáo #<?= $report['id'] ?></span>
        </div>

        <!-- Tiêu đề báo cáo -->
        <div class="mb-4">
            <label class="form-label text-muted small fw-semibold text-uppercase letter-spacing-1">
                <i class="bi bi-tag-fill me-1"></i>Tiêu đề báo cáo
            </label>
            <div class="p-3 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); font-size: 1.1rem; font-weight: 600;">
                <!-- [SECURITY FIX GTU-190626-01] Đã encode qua View::e() — htmlspecialchars() -->
                <?= View::e($report['title']) ?>
            </div>
        </div>

        <!-- Nội dung báo cáo - điểm kích hoạt Stored XSS -->
        <div>
            <label class="form-label text-muted small fw-semibold text-uppercase letter-spacing-1">
                <i class="bi bi-file-text-fill me-1"></i>Nội dung chi tiết
            </label>
            <div class="p-4 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); line-height: 1.8; min-height: 150px; white-space: pre-wrap;" id="report-content-display">
                <!-- [SECURITY FIX GTU-190626-01] Đã encode qua View::e() — htmlspecialchars()
                     white-space: pre-wrap giữ định dạng xuống dòng mà không dùng innerHTML -->
                <?= View::e($report['content']) ?>
            </div>
        </div>
    </div>
</div>
