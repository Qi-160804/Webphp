<?php 
require("inc/init.php");
include("inc/top.php");

if (!isset($_SESSION["khachhang"])) {
    echo '<script>alert("Vui lòng đăng nhập để xem thông tin cá nhân!"); location.href = "index.php?action=dangnhap";</script>';
    exit();
}

$khach = $_SESSION["khachhang"];
$msg = $err = '';
$dc = new DIACHI();
$dh = new DONHANG();
$diachi_val = ($temp = $dc->laydiachikhachhang($khach['id'])) ? $temp['diachi'] : '';

// CẬP NHẬT THÔNG TIN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnCapNhat'])) {
    $ht = $_POST['txthoten'] ?? '';
    $sdt = $_POST['txtsodienthoai'] ?? '';
    $dchi = $_POST['txtdiachi'] ?? '';
    
    if (empty($ht)) {
        $err = "Họ tên không được để trống!";
    } else {
        if ($kh->capnhatthongtin($khach['id'], $ht, $sdt, $dchi)) {
            $dc->capnhatdiachi($khach['id'], $dchi);
            $_SESSION['khachhang']['hoten'] = $ht;
            $_SESSION['khachhang']['sodienthoai'] = $sdt;
            $khach = $_SESSION["khachhang"];
            $msg = "Cập nhật thông tin thành công!";
        } else {
            $err = "Có lỗi xảy ra khi cập nhật thông tin!";
        }
    }
}

// ĐỔI MẬT KHẨU
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDoiMatKhau'])) {
    $mkcu = $_POST['txtmatkhaucu'] ?? '';
    $mkmoi = $_POST['txtmatkhaumoi'] ?? '';
    $xnmk = $_POST['txtxacnhanmatkhau'] ?? '';
    
    if (!$kh->kiemtramatkhau($khach['id'], $mkcu)) {
        $err = "Mật khẩu cũ không đúng!";
    } elseif (empty($mkmoi)) {
        $err = "Mật khẩu mới không được để trống!";
    } elseif ($mkmoi !== $xnmk) {
        $err = "Xác nhận mật khẩu không khớp!";
    } elseif (strlen($mkmoi) < 6) {
        $err = "Mật khẩu mới phải có ít nhất 6 ký tự!";
    } else {
        $msg = $kh->doimatkhau($khach['id'], $mkmoi) ? "Đổi mật khẩu thành công!" : "Có lỗi xảy ra khi đổi mật khẩu!";
    }
}

$sosp = demsoluongtronggio();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px">
                    <i class="bi bi-person text-white fs-4"></i>
                </div>
                <div>
                    <h1 class="fw-bold text-primary mb-1">Thông tin cá nhân</h1>
                    <p class="text-muted mb-0">Quản lý thông tin tài khoản của bạn</p>
                </div>
            </div>

            <?php if($msg): ?>
            <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle-fill me-2"></i><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; if($err): ?>
            <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= $err ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="bi bi-person-vcard me-2"></i>Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control bg-light" value="<?=htmlspecialchars($khach["email"])?>" readonly>
                                    <small class="text-muted">Email không thể thay đổi</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-danger">Họ tên *</label>
                                    <input type="text" name="txthoten" class="form-control" value="<?=htmlspecialchars($khach["hoten"])?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Số điện thoại</label>
                                    <input type="text" name="txtsodienthoai" class="form-control" value="<?=htmlspecialchars($khach["sodienthoai"] ?? '')?>" placeholder="Nhập số điện thoại">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Địa chỉ</label>
                                    <textarea name="txtdiachi" class="form-control" rows="3" placeholder="Nhập địa chỉ của bạn"><?=htmlspecialchars($diachi_val)?></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="btnCapNhat" class="btn btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>Cập nhật thông tin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-danger">Mật khẩu cũ *</label>
                                    <input type="password" name="txtmatkhaucu" class="form-control" required placeholder="Nhập mật khẩu hiện tại">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-danger">Mật khẩu mới *</label>
                                    <input type="password" name="txtmatkhaumoi" class="form-control" required placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)">
                                    <small class="text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-danger">Xác nhận mật khẩu *</label>
                                    <input type="password" name="txtxacnhanmatkhau" class="form-control" required placeholder="Nhập lại mật khẩu mới">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="btnDoiMatKhau" class="btn btn-warning btn-lg"><i class="bi bi-key me-2"></i>Đổi mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow border-0">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Thông tin tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <i class="bi bi-calendar-check fs-1 text-primary"></i>
                                        <h6 class="mt-2 fw-bold">Ngày tham gia</h6>
                                        <p class="mb-0 text-muted"><?= isset($khach['ngaytao']) ? date('d/m/Y', strtotime($khach['ngaytao'])) : date('d/m/Y') ?></p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <i class="bi bi-cart-check fs-1 text-success"></i>
                                        <h6 class="mt-2 fw-bold">Đơn hàng</h6>
                                        <p class="mb-0 text-muted"><?php try { echo $dh->demdonhang($khach['id']); } catch (Exception $e) { echo 0; } ?> đơn</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <i class="bi bi-cart fs-1 text-warning"></i>
                                        <h6 class="mt-2 fw-bold">Giỏ hàng</h6>
                                        <p class="mb-0 text-muted"><?= $sosp ?> sản phẩm</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <i class="bi bi-telephone fs-1 text-danger"></i>
                                        <h6 class="mt-2 fw-bold">Liên hệ</h6>
                                        <p class="mb-0 text-muted">076 3841190</p>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($sosp > 0): ?>
                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-info-circle me-2"></i><strong>Bạn có <?= $sosp ?> sản phẩm trong giỏ hàng!</strong> 
                                <a href="index.php?action=giohang" class="alert-link">Xem giỏ hàng</a> hoặc 
                                <a href="index.php?action=thanhtoan" class="alert-link">Thanh toán ngay</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-outline-secondary me-2"><i class="bi bi-house me-1"></i>Trang chủ</a>
                <a href="index.php?action=thanhtoan" class="btn btn-outline-primary"><i class="bi bi-cart-check me-1"></i>Quay lại thanh toán</a>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>