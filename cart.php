<?php
include("inc/init.php");
include("inc/top.php");
?>

<?php if(demhangtronggio() == 0): ?>
    <div class="text-center py-5 my-5">
        <h2 class="text-info">Giỏ hàng trống!</h2>
        <p class="lead">Bạn chưa chọn sản phẩm nào.</p>
        <a href="index.php" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
    </div>
<?php else: ?>
    <h2 class="text-info mb-4">Giỏ hàng của bạn</h2>
    
    <?php if(isset($_SESSION['thongbao'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i><?= $_SESSION['thongbao'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?php unset($_SESSION['thongbao']); ?>
    </div>
    <?php endif; ?>
    
    <form action="index.php" method="post">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr><th>Hình</th><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th><th width="100">Xóa</th></tr>
                </thead>
                <tbody>
                    <?php foreach($giohang as $id => $i): ?>
                    <tr>
                        <td><img width="70" class="rounded shadow-sm" src="../<?=htmlspecialchars($i["hinhanh"])?>" alt="<?=htmlspecialchars($i["tenmathang"])?>"></td>
                        <td class="fw-medium"><?=htmlspecialchars($i["tenmathang"])?></td>
                        <td class="fw-bold"><?=number_format($i["giaban"])?>đ</td>
                        <td width="120"><input type="number" name="mh[<?=$id?>]" value="<?=$i["soluong"]?>" min="0" class="form-control text-center"></td>
                        <td class="text-danger fw-bold"><?=number_format($i["thanhtien"])?>đ</td>
                        <td>
                            <div class="text-center">
                                <a href="index.php?action=xoamotmathang&id=<?=$id?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa <?=htmlspecialchars($i['tenmathang'])?> khỏi giỏ hàng?')" title="Xóa sản phẩm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-success">
                        <td colspan="5" class="text-end fw-bold fs-4">TỔNG CỘNG:</td>
                        <td class="text-danger fw-bold fs-3"><?=number_format(tinhtiengiohang())?>đ</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <a href="index.php?action=xoagiohang" class="btn btn-outline-danger me-2" onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')">
                <i class="bi bi-trash-fill me-1"></i>Xóa tất cả
            </a>
            <button type="submit" name="action" value="capnhatgio" class="btn btn-warning me-2">
                <i class="bi bi-arrow-clockwise me-1"></i>Cập nhật
            </button>
            <a href="index.php?action=thanhtoan" class="btn btn-success btn-lg px-5">
                <i class="bi bi-credit-card me-2"></i>Thanh toán ngay
            </a>
        </div>
    </form>
<?php endif; ?>

<?php include("inc/bottom.php"); ?>