<?php use App\Helpers\Session; ?>

<div class="auth-container animate-fade-in">
    <div class="text-center mb-4">
        <i class="bi bi-controller text-gradient" style="font-size: 3rem;"></i>
        <h3 class="fw-bold mt-2">Đăng Nhập</h3>
        <p class="text-muted small">Chào mừng trở lại! Đăng nhập để tiếp tục.</p>
    </div>
    
    <form action="/login" method="POST" id="loginForm">
        <?= Session::csrfField() ?>
        
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-0 text-muted"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="username" name="username" 
                       placeholder="Nhập username" required autocomplete="username">
            </div>
        </div>
        
        <div class="mb-4">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-0 text-muted"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Nhập mật khẩu" required autocomplete="current-password">
            </div>
        </div>
        
        <button type="submit" class="btn btn-glow w-100 mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>Đăng Nhập
        </button>
    </form>
    
    <p class="text-center text-muted small mt-3 mb-0">
        Chưa có tài khoản? 
        <a href="/register" class="fw-bold">Đăng ký ngay</a>
    </p>
    
    <hr class="border-secondary my-3">
    <p class="text-center text-muted small mb-0">
        <i class="bi bi-info-circle me-1"></i>Demo: <code>admin / 123456</code> hoặc <code>user1 / 123456</code>
    </p>
</div>
