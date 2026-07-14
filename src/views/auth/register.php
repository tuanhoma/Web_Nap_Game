<?php use App\Helpers\Session; ?>

<div class="auth-container animate-fade-in">
    <div class="text-center mb-4">
        <i class="bi bi-person-plus text-gradient" style="font-size: 3rem;"></i>
        <h3 class="fw-bold mt-2">Tạo Tài Khoản</h3>
        <p class="text-muted small">Đăng ký miễn phí để bắt đầu nạp game.</p>
    </div>
    
    <form action="/register" method="POST" id="registerForm">
        <?= Session::csrfField() ?>
        
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" 
                   placeholder="Chỉ chữ cái, số và gạch dưới" required minlength="3" maxlength="50">
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   placeholder="email@example.com" required>
        </div>
        
        <div class="mb-3">
            <label for="full_name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="full_name" name="full_name" 
                   placeholder="Nguyễn Văn A" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" 
                   placeholder="Tối thiểu 6 ký tự" required minlength="6">
        </div>
        
        <div class="mb-4">
            <label for="password_confirm" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" 
                   placeholder="Nhập lại mật khẩu" required>
        </div>
        
        <button type="submit" class="btn btn-glow w-100 mb-3">
            <i class="bi bi-person-plus me-2"></i>Đăng Ký
        </button>
    </form>
    
    <p class="text-center text-muted small mt-3 mb-0">
        Đã có tài khoản? 
        <a href="/login" class="fw-bold">Đăng nhập</a>
    </p>
</div>
