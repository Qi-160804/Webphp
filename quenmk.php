<?php include("inc/top.php"); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark text-center">
                    <h4>QUÊN MẬT KHẨU</h4>
                </div>
                <div class="card-body p-5">
                    <?php showAlert(); ?>

                    <?php if (!isset($_SESSION['alert']) || $_SESSION['alert']['type'] !== 'success'): ?>
                    <p class="text-center text-muted">Nhập email đăng ký để nhận link đặt lại mật khẩu</p>
                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="xlquenmatkhau">
                        <div class="mb-3">
                            <input type="email" name="txtemail" class="form-control form-control-lg text-center" 
                                   placeholder="email của bạn" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg w-100">GỬI LINK ĐẶT LẠI</button>
                    </form>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="index.php?action=dangnhap">Quay lại đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("inc/bottom.php"); ?>