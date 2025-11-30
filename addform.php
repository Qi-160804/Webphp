<?php include("../inc/top.php"); ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary mb-0"><i class="bi bi-person-plus-fill me-2"></i>Thêm tài khoản người dùng</h3>
            <small class="text-muted">Tạo tài khoản mới cho người dùng hệ thống</small>
        </div>
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <!-- Form thêm mới -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle me-2"></i>Thông tin tài khoản
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="txtemail" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1 text-muted"></i>Email
                            </label>
                            <input class="form-control form-control-lg" 
                                   type="email" 
                                   id="txtemail"
                                   name="txtemail" 
                                   placeholder="Nhập địa chỉ email" 
                                   required>
                            <div class="form-text">Email sẽ được sử dụng để đăng nhập hệ thống</div>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-3">
                            <label for="txtmatkhau" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1 text-muted"></i>Mật khẩu
                            </label>
                            <input class="form-control form-control-lg" 
                                   type="text" 
                                   id="txtmatkhau"
                                   name="txtmatkhau" 
                                   placeholder="Nhập mật khẩu" 
                                   required>
                            <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
                            <label for="txtdienthoai" class="form-label fw-semibold">
                                <i class="bi bi-phone me-1 text-muted"></i>Số điện thoại
                            </label>
                            <input class="form-control form-control-lg" 
                                   type="number" 
                                   id="txtdienthoai"
                                   name="txtdienthoai" 
                                   placeholder="Nhập số điện thoại" 
                                   required>
                        </div>

                        <!-- Họ tên -->
                        <div class="mb-3">
                            <label for="txthoten" class="form-label fw-semibold">
                                <i class="bi bi-person me-1 text-muted"></i>Họ tên
                            </label>
                            <input class="form-control form-control-lg" 
                                   type="text" 
                                   id="txthoten"
                                   name="txthoten" 
                                   placeholder="Nhập họ và tên đầy đủ" 
                                   required>
                        </div>

                        <!-- Loại quyền -->
                        <div class="mb-4">
                            <label for="optloaind" class="form-label fw-semibold">
                                <i class="bi bi-person-gear me-1 text-muted"></i>Phân quyền
                            </label>
                            <select class="form-select form-select-lg" id="optloaind" name="optloaind">
                                <option value="1">Quản trị viên</option>
                                <option value="2" selected>Thành viên</option>
                                <option value="3">Khách hàng</option>
                            </select>
                            <div class="form-text">Lựa chọn quyền truy cập cho người dùng</div>
                        </div>

                        <!-- Hidden field và buttons -->
                        <input type="hidden" name="action" value="xlthem">
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-lg btn-outline-secondary me-md-2">
                                <i class="bi bi-x-circle me-1"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Thêm người dùng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông tin phân quyền -->
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Giải thích phân quyền
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h6 class="text-danger"><i class="bi bi-shield-check me-1"></i>Quản trị viên</h6>
                            <small class="text-muted">Toàn quyền truy cập hệ thống, không thể bị khóa</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-warning"><i class="bi bi-person-gear me-1"></i>Thành viên</h6>
                            <small class="text-muted">Quyền truy cập hạn chế, có thể bị khóa/mở khóa</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-primary"><i class="bi bi-person me-1"></i>Khách hàng</h6>
                            <small class="text-muted">Quyền cơ bản, có thể bị khóa/mở khóa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-lg, .form-select-lg {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
}
.card {
    border-radius: 0.75rem;
}
</style>

<?php include("../inc/bottom.php"); ?>