<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Panel') ?> | GameTopup Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header p-3">
                <a href="/admin" class="text-decoration-none">
                    <h5 class="text-gradient mb-0"><i class="bi bi-controller me-2"></i>GameTopup</h5>
                    <small class="text-muted">Admin Panel</small>
                </a>
            </div>
            <hr class="border-secondary mx-3">
            <ul class="nav flex-column px-2">
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link" href="/admin">
                        <i class="bi bi-grid-1x2-fill me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link" href="/admin/users">
                        <i class="bi bi-people-fill me-2"></i>Người dùng
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link" href="/admin/orders">
                        <i class="bi bi-receipt me-2"></i>Giao dịch
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link" href="/admin/packages">
                        <i class="bi bi-box-seam me-2"></i>Gói nạp
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link" href="/admin/reports">
                        <i class="bi bi-flag-fill me-2"></i>Báo cáo
                    </a>
                </li>
                <hr class="border-secondary mx-2">
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link" href="/">
                        <i class="bi bi-house-door me-2"></i>Về trang chủ
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link sidebar-link text-danger" href="/logout">
                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="admin-content flex-grow-1">
            <!-- Top Bar -->
            <div class="admin-topbar d-flex justify-content-between align-items-center p-3">
                <div>
                    <h4 class="mb-0 fw-bold"><?= htmlspecialchars($title ?? 'Dashboard') ?></h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success me-3"><i class="bi bi-circle-fill me-1 small"></i>Online</span>
                    <span class="text-muted">
                        <i class="bi bi-person-circle me-1"></i>
                        <?= htmlspecialchars(\App\Helpers\Session::get('full_name', 'Admin')) ?>
                    </span>
                </div>
            </div>

            <!-- Flash Messages -->
            <div class="px-4">
                <?php if (\App\Helpers\Session::hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= htmlspecialchars(\App\Helpers\Session::getFlash('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                <?php if (\App\Helpers\Session::hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= htmlspecialchars(\App\Helpers\Session::getFlash('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
            </div>

            <!-- Page Content -->
            <div class="p-4">
                <?= $content ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
