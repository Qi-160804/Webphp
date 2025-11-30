<?php
if (!isset($_SESSION["nguoidung"]) || ($_SESSION["nguoidung"]["loai"] != 1 && $_SESSION["nguoidung"]["loai"] != 2)) {
    header("location:../../index.php");
    exit();
}

require_once("../../model/database.php");
require_once("../../model/donhang.php");
require_once("../../model/donhangct.php");

$dh = new DONHANG();
$dhct = new DONHANGCT();

$id = $_GET["id"] ?? 0;
if ($id <= 0) {
    header("location:index.php");
    exit();
}

$donhang = $dh->laythongtindonhang($id);
$chitiet = $dhct->laychitietdonhang($id); 

if (!$donhang) {
    $_SESSION['thongbao'] = "Đơn hàng không tồn tại!";
    header("location:index.php");
    exit();
}
?>
<?php include("../inc/top.php"); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0">
                        Chi tiết đơn hàng #<?= $donhang['id'] ?>
                        <span class="badge <?= DONHANG::getStatusColor($donhang['trangthai']) ?> fs-5 px-4 py-2">
    Trạng thái: <strong><?= DONHANG::getStatusText($donhang['trangthai']) ?></strong>
</span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">Thông tin khách hàng</h6>
                            <p><strong>Họ tên:</strong> <?= htmlspecialchars($donhang['hoten'] ?? 'Khách vãng lai') ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($donhang['email'] ?? '—') ?></p>
                            <p><strong>Điện thoại:</strong> <?= htmlspecialchars($donhang['sodienthoai'] ?? '—') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">Thông tin giao hàng</h6>
                            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i:s', strtotime($donhang['ngay'])) ?></p>
                            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($donhang['diachi_giaohang'] ?? '—') ?></p>
                            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($donhang['ghichu'] ?? 'Không có') ?></p>
                        </div>
                    </div>

                    <h5 class="text-info mb-3">Danh sách sản phẩm đã mua</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">Hình</th>
                                    <th>Sản phẩm</th>
                                    <th width="120" class="text-center">Số lượng</th>
                                    <th width="150" class="text-end">Đơn giá</th>
                                    <th width="150" class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($chitiet as $ct):
                                    $anh = trim($ct['hinhanh'] ?? '');
                                    $anh = $anh ?: 'images/products/no-image.jpg'; 
                                ?>
                                <tr>
                                    <td>
                                        <img src="../../<?= htmlspecialchars($anh) ?>" 
                                            width="70" height="70" 
                                            class="rounded border object-fit-cover" 
                                            alt="<?= htmlspecialchars($ct['tenmathang']) ?>"
                                            style="object-fit:cover">
                                    </td>
                                    <td class="fw-medium align-middle"><?= htmlspecialchars($ct['tenmathang']) ?></td>
                                    <td class="text-center align-middle"><span class="badge bg-primary fs-6"><?= $ct['soluong'] ?></span></td>
                                    <td class="text-end align-middle"><?= number_format($ct['dongia'],0,',','.') ?> ₫</td>
                                    <td class="text-end text-danger fw-bold align-middle"><?= number_format($ct['thanhtien'],0,',','.') ?> ₫</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-danger">
                                    <th colspan="4" class="text-end fw-bold fs-5">TỔNG CỘNG:</th>
                                    <th class="text-end fs-5"><?= number_format($donhang['tongtien'],0,',','.') ?> đ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body text-center py-5">
                    <h1 class="text-success"><?= number_format($donhang['tongtien'],0,',','.') ?> đ</h1>
                    <p class="text-muted">Tổng tiền thanh toán</p>
                    <hr>
                    <div class="text-center mt-4">
                        <a href="index.php?action=chitietdoanhthu&tungay=<?= urlencode($_GET['tungay'] ?? '') ?>&denngay=<?= urlencode($_GET['denngay'] ?? '') ?>" 
                        class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách chi tiết doanh thu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../inc/bottom.php"); ?>