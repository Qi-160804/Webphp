<?php 
require("inc/init.php");
include("inc/top.php");

// Kiểm tra giỏ hàng
$giohang = laygiohang();
if (empty($giohang)) {
    echo '<script>alert("Giỏ hàng trống! Vui lòng chọn sản phẩm."); location.href = "index.php?action=giohang";</script>';
    exit();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION["khachhang"])) {
    $_SESSION['redirect_url'] = 'index.php?action=thanhtoan';
    echo '<script>alert("Vui lòng đăng nhập để thanh toán!"); location.href = "index.php?action=dangnhap";</script>';
    exit();
}

$khach = $_SESSION["khachhang"];
$dc = new DIACHI();
$diachi_hientai = $dc->laydiachikhachhang($khach['id']);
$diachi_giaohang = $diachi_hientai ? $diachi_hientai['diachi'] : ($khach["diachi"] ?? '');
?>

<div class="container py-5">
    <h2 class="text-center text-primary mb-5 fw-bold">XÁC NHẬN ĐƠN HÀNG</h2>
    <div class="row g-5">
        <!-- Thông tin giao hàng -->
        <div class="col-lg-7">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Thông tin giao hàng</h4>
                    <small class="text-warning"><i class="bi bi-person-check-fill me-1"></i>Đã đăng nhập</small>
                </div>
                <div class="card-body">
                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="luudonhang">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Họ tên</label>
                                <input type="text" class="form-control bg-light" value="<?=htmlspecialchars($khach["hoten"])?>" readonly>
                                <small class="text-muted">Thông tin từ tài khoản của bạn</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control bg-light" value="<?=htmlspecialchars($khach["email"])?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" class="form-control bg-light" value="<?=htmlspecialchars($khach["sodienthoai"])?>" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-danger">Địa chỉ giao hàng * <small class="text-muted">(có thể chỉnh sửa)</small></label>
                                <textarea name="txtdiachi" class="form-control" rows="4" required placeholder="Nhập địa chỉ giao hàng chi tiết"><?=htmlspecialchars($diachi_giaohang)?></textarea>
                                <small class="text-muted"><?=$diachi_hientai ? 'Địa chỉ đã được cập nhật từ trang cá nhân' : 'Nhập địa chỉ giao hàng của bạn'?></small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Ghi chú đơn hàng</label>
                                <textarea name="txtghichu" class="form-control" rows="3" placeholder="Ghi chú về đơn hàng (nếu có)"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i><strong>Thông báo:</strong> Thông tin cá nhân được lấy từ tài khoản của bạn. 
                                    Để thay đổi thông tin, vui lòng cập nhật trong <a href="index.php?action=profile" class="alert-link">trang cá nhân</a>.
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <a href="index.php?action=giohang" class="btn btn-outline-secondary me-3"><i class="bi bi-arrow-left me-1"></i>Quay lại giỏ hàng</a>
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow"><i class="bi bi-check-circle me-2"></i>HOÀN TẤT ĐƠN HÀNG</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="col-lg-5">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Đơn hàng (<?=count($giohang)?> sản phẩm)</h4>
                </div>
                <div class="card-body">
                    <?php foreach($giohang as $item): ?>
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <img src="../<?=htmlspecialchars($item["hinhanh"])?>" width="60" class="rounded me-3" alt="<?=htmlspecialchars($item["tenmathang"])?>">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?=htmlspecialchars($item["tenmathang"])?></h6>
                            <small class="text-muted">x<?=$item["soluong"]?></small>
                        </div>
                        <strong class="text-danger"><?=number_format($item["thanhtien"])?>đ</strong>
                    </div>
                    <?php endforeach; ?>
                    <div class="pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold">TỔNG TIỀN:</h4>
                            <h3 class="text-danger mb-0 fw-bold"><?=number_format(tinhtiengiohang())?>đ</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="index.php?action=giohang" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Sửa giỏ hàng</a>
                </div>
            </div>
            
            <!-- Thông tin tài khoản -->
            <div class="card shadow border-0 mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Thông tin tài khoản</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-person text-white fs-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?=htmlspecialchars($khach["hoten"])?></h6>
                            <small class="text-muted"><?=htmlspecialchars($khach["email"])?></small>
                        </div>
                    </div>
                    <?php if ($diachi_hientai): ?>
                    <div class="mb-3">
                        <small class="text-muted">Địa chỉ hiện tại:</small>
                        <p class="mb-1 small"><?=htmlspecialchars($diachi_hientai['diachi'])?></p>
                    </div>
                    <?php endif; ?>
                    <div class="text-center">
                        <a href="index.php?action=profile" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i>Cập nhật thông tin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>