<?php include("inc/top.php"); ?>

<div class="container mt-4">  
<div class="row"> 
    <h4 class="text-info">Thông tin khách hàng</h4> 
    <?php if(isset($_SESSION["khachhang"])){ $i = 1; ?> 
    <p class="text-danger fw-bold"><?= $_SESSION["khachhang"]["hoten"] ?></p>
    
    <h4 class="text-info">Danh sách đơn hàng</h4>
    <table class="table table-hover">
        <tr><th>STT</th><th>Mã đơn hàng</th><th>Ngày đặt</th><th>Số tiền</th><th>Chi tiết đơn hàng</th></tr>
        <?php foreach($donhang as $d){ ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><a href="index.php?action=thongtin&dhid=<?= $d["id"] ?>">DH00000<?= $d["id"] ?></a></td>
            <td><?= date("d/m/Y H:i:s", strtotime($d["ngay"])) ?></td>
            <td class="text-end fw-bold"><?= number_format($d["tongtien"]) ?> đ</td>
            <td><a href="index.php?action=thongtin&dhid=<?= $d["id"] ?>">Xem chi tiết</a></td>
        </tr>
        <?php if(isset($donhangct) && ($d["id"] == $donhangct[0]["donhang_id"])){ ?>
            <tr><td></td><td colspan="5">
                <table class="table table-bordered">
                    <tr class="text-center"><th>Mặt hàng</th><th>Hình ảnh</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>
                    <?php foreach($donhangct as $ct){ ?>
                    <tr class="align-middle">
                        <td><a class="text-decoration-none" href="index.php?action=detail&id=<?= $ct["mathang_id"] ?>"><?= $ct["tenmathang"] ?></a></td>
                        <td><img class="img-thumbnail" width="50" src="../<?= $ct["hinhanh"] ?>" alt="<?= $ct["tenmathang"] ?>"></td>
                        <td class="text-end"><?= number_format($ct["dongia"]) ?> đ</td>
                        <td class="text-end"><?= $ct["soluong"] ?></td>
                        <td class="text-end fw-bold text-danger"><?= number_format($ct["thanhtien"]) ?> đ</td>
                    </tr>
                    <?php } ?>
                    <tr class="table-success">
                        <td colspan="4" class="text-end fw-bold">TỔNG CỘNG:</td>
                        <td class="text-end fw-bold text-danger"><?= number_format(array_sum(array_column($donhangct, "thanhtien"))) ?> đ</td>
                    </tr>
                </table>
                
                <div class="text-center mt-3">
                    <?php 
                    $prev = $_SERVER['HTTP_REFERER'] ?? '';
                    $from_msg = strpos($prev, 'message.php') !== false || strpos($prev, 'action=luudonhang') !== false;
                    if($from_msg && $prev): ?>
                    <a href="<?= $prev ?>" class="btn btn-outline-warning me-2"><i class="bi bi-arrow-left me-1"></i>Quay lại trang cảm ơn</a>
                    <?php endif; ?>
                    <a href="index.php?action=thongtin" class="btn btn-outline-primary me-2"><i class="bi bi-list me-1"></i>Danh sách đơn hàng</a>
                    <a href="index.php" class="btn btn-primary"><i class="bi bi-house me-1"></i>Trang chủ</a>
                </div>
            </td></tr>
        <?php }} ?>
    </table>
    <?php }else{ ?>
    <p>Bạn chưa đăng nhập. Vui lòng <a href="index.php?action=dangnhap">đăng nhập</a> để xem danh sách đơn hàng.</p>
    <?php } ?>
</div>
</div>

<?php include("inc/bottom.php"); ?>