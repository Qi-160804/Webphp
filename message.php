<?php 
require("inc/init.php");
include("inc/top.php");

$dh = $_SESSION['donhang_moi'] ?? null;
if (!$dh) { header('Location: index.php'); exit(); }

$ct = (new DONHANGCT())->laychitietdonhang($dh['id']);
unset($_SESSION['donhang_moi']);
$kh = $_SESSION['khachhang'] ?? null;
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 text-center">
                <div class="card-header bg-success text-white py-4">
                    <i class="bi bi-check-circle-fill display-1"></i>
                    <h2 class="mt-3 mb-0">ĐẶT HÀNG THÀNH CÔNG!</h2>
                </div>
                <div class="card-body p-5">
                    <div class="mb-4">
                        <h4 class="text-primary">Cảm ơn bạn đã mua hàng!</h4>
                        <p class="text-muted">Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                    </div>
                    
                    <div class="row text-start mb-4">
                        <div class="col-md-6">
                            <h5>Thông tin đơn hàng</h5>
                            <p><strong>Mã đơn hàng:</strong> #<?= $dh['id'] ?></p>
                            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i') ?></p>
                            <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?= number_format($dh['tongtien']) ?>đ</span></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Thông tin khách hàng</h5>
                            <p><strong>Họ tên:</strong> <?= htmlspecialchars($dh['hoten']) ?></p>
                            <?php if ($kh): ?>
                            <p><strong>Email:</strong> <?= htmlspecialchars($kh['email'] ?? '') ?></p>
                            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($kh['sodienthoai'] ?? '') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($ct): ?>
                    <div class="mb-4">
                        <h5>Chi tiết đơn hàng</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr><th>Sản phẩm</th><th>Hình ảnh</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ct as $i): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($i['tenmathang']) ?></td>
                                        <td><?php if ($i['hinhanh']): ?><img src="../<?= htmlspecialchars($i['hinhanh']) ?>" width="50" class="rounded"><?php endif; ?></td>
                                        <td><?= $i['soluong'] ?></td>
                                        <td><?= number_format($i['dongia']) ?>đ</td>
                                        <td class="text-danger fw-bold"><?= number_format($i['thanhtien']) ?>đ</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="4" class="text-end fw-bold">TỔNG CỘNG:</td>
                                        <td class="text-danger fw-bold"><?= number_format($dh['tongtien']) ?>đ</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Đơn hàng của bạn sẽ được giao trong vòng 2-3 ngày làm việc. Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng.
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <a href="index.php" class="btn btn-primary btn-lg me-2"><i class="bi bi-house me-1"></i>Tiếp tục mua sắm</a>
                        <?php if ($kh): ?>
                        <a href="index.php?action=thongtin" class="btn btn-outline-primary btn-lg"><i class="bi bi-list-check me-1"></i>Theo dõi đơn hàng</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("inc/bottom.php"); ?>