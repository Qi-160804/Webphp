<?php include("inc/top.php"); ?>

<style>
.login-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
}
.login-header {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    border-radius: 20px 20px 0 0;
}
.form-control {
    border-radius: 12px;
    padding: 12px 20px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.btn-login {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    border: none;
    border-radius: 12px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}
.social-login {
    border-radius: 12px;
    padding: 10px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}
.social-login:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
}
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card">
                <div class="login-header text-white text-center py-4">
                    <h3 class="fw-bold mb-0"><i class="bi bi-person-circle me-2"></i>ĐĂNG NHẬP</h3>
                    <p class="mb-0 opacity-75">Chào mừng bạn trở lại</p>
                </div>
                
                <div class="card-body p-4">
                    <form method="post" action="index.php">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input class="form-control" type="email" name="txtemail" placeholder="Nhập địa chỉ email" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <input class="form-control" type="password" name="txtmatkhau" placeholder="Nhập mật khẩu" required>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                        </div>

                        <input type="hidden" name="action" value="xldangnhap">
                        
                        <div class="d-grid mb-4">
                            <button class="btn btn-login text-white btn-lg" type="submit">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                            </button>
                        </div>
                    </form>

                    <!-- Social Login -->
                    <div class="text-center mb-4">
                        <div class="position-relative">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">Hoặc</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <a href="#" class="btn social-login w-100 text-decoration-none">
                                <i class="bi bi-google text-danger me-2"></i>Google
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn social-login w-100 text-decoration-none">
                                <i class="bi bi-facebook text-primary me-2"></i>Facebook
                            </a>
                        </div>
                    </div>

                    <!-- Additional Links -->
                    <div class="text-center">
                        <div class="d-flex justify-content-center gap-4 mb-3">
                            <a href="#quenmatkhau" class="text-decoration-none text-primary fw-semibold" data-bs-toggle="modal">
                                <i class="bi bi-key me-1"></i>Quên mật khẩu?
                            </a>
                            <a href="#dangky" class="text-decoration-none text-success fw-semibold" data-bs-toggle="modal">
                                <i class="bi bi-person-plus me-1"></i>Đăng ký tài khoản
                            </a>
                        </div>
                        
                        <div class="mt-3">
                            <a href="index.php" class="text-decoration-none text-muted">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quên mật khẩu -->
<div class="modal fade" id="quenmatkhau" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-key me-2"></i>Quên mật khẩu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>
                
                <form id="forgotPasswordForm">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" placeholder="Nhập địa chỉ email" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Gửi liên kết đặt lại
                        </button>
                    </div>
                </form>
                
                <div class="alert alert-info mt-3" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Liên kết đặt lại mật khẩu sẽ được gửi đến email của bạn trong vòng 5 phút.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đăng ký tài khoản -->
<div class="modal fade" id="dangky" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus me-2"></i>Đăng ký tài khoản
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="post" action="index.php">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Họ và tên</label>
                            <input type="text" class="form-control" name="txthoten" placeholder="Nhập họ và tên" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="txtemail" placeholder="Nhập địa chỉ email" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Số điện thoại</label>
                            <input type="tel" class="form-control" name="txtsodienthoai" placeholder="Nhập số điện thoại" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <input type="password" class="form-control" name="txtmatkhau" placeholder="Nhập mật khẩu" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" name="txtxnmatkhau" placeholder="Nhập lại mật khẩu" required>
                        </div>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" required>
                        <label class="form-check-label small">
                            Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> 
                            và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                        </label>
                    </div>
                    
                    <input type="hidden" name="action" value="xldangky">
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-person-check me-2"></i>Đăng ký tài khoản
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <p class="text-muted small mb-0">
                        Đã có tài khoản? 
                        <a href="#" class="text-decoration-none fw-semibold" data-bs-dismiss="modal">Đăng nhập ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Xử lý form quên mật khẩu
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Hiển thị thông báo thành công
    const alertHTML = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Thành công!</strong> Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    this.innerHTML = alertHTML;
    
    // Tự động đóng modal sau 3 giây
    setTimeout(() => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('quenmatkhau'));
        modal.hide();
    }, 3000);
});

// Xử lý form đăng ký
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = this.querySelector('input[name="txtmatkhau"]').value;
    const confirmPassword = this.querySelector('input[name="txtxnmatkhau"]').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Mật khẩu phải có ít nhất 6 ký tự!');
        return false;
    }
});
</script>

<?php include("inc/bottom.php"); ?>