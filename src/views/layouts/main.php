<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cổng Nạp Game - Nạp game nhanh, an toàn, giá tốt nhất">
    <title><?= htmlspecialchars($title ?? 'Cổng Nạp Game') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="bi bi-controller me-2 fs-4"></i>
                <span class="fw-bold">GameTopup</span>
                <span class="badge bg-accent ms-2 small">VN</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house-door me-1"></i>Trang chủ</a>
                    </li>
                    <?php if (\App\Helpers\Session::isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/topup"><i class="bi bi-lightning-charge me-1"></i>Nạp Game</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                    </li>
                    <?php if (\App\Helpers\Session::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/admin"><i class="bi bi-shield-lock me-1"></i>Admin</a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (\App\Helpers\Session::isLoggedIn()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="avatar-sm me-2">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <?= htmlspecialchars(\App\Helpers\Session::get('full_name', 'User')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-accent btn-sm ms-2 px-3" href="/register">Đăng ký</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php if (\App\Helpers\Session::hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show glass-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars(\App\Helpers\Session::getFlash('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if (\App\Helpers\Session::hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show glass-alert" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars(\App\Helpers\Session::getFlash('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-gradient fw-bold"><i class="bi bi-controller me-2"></i>GameTopup VN</h5>
                    <p class="text-muted small">Cổng nạp game uy tín, nhanh chóng, giá tốt nhất Việt Nam.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-light">Liên kết</h6>
                    <ul class="list-unstyled small">
                        <li><a href="/" class="text-muted text-decoration-none">Trang chủ</a></li>
                        <li><a href="/topup" class="text-muted text-decoration-none">Nạp game</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-light">Hỗ trợ</h6>
                    <ul class="list-unstyled small">
                        <li class="text-muted"><i class="bi bi-envelope me-1"></i>support@gametopup.vn</li>
                        <li class="text-muted"><i class="bi bi-telephone me-1"></i>1900-xxxx</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <p class="text-center text-muted small mb-0">&copy; 2024 GameTopup VN - Demo Project. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
