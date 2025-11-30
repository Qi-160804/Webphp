<?php
// Khởi tạo giỏ hàng nếu chưa tồn tại
if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Thêm sản phẩm vào giỏ
function themhangvaogio($id, $soluong) {
    $soluong = max(0, round($soluong, 0));
    $_SESSION['giohang'][$id] = ($_SESSION['giohang'][$id] ?? 0) + $soluong;
}

// Cập nhật số lượng
function capnhatsoluong($id, $soluong) {
    if (isset($_SESSION['giohang'][$id])) {
        $_SESSION['giohang'][$id] = max(0, round($soluong, 0));
    }
}

// Xóa một sản phẩm
function xoamotmathang($id) {
    unset($_SESSION['giohang'][$id]);
}

// Lấy danh sách sản phẩm trong giỏ
function laygiohang() {
    $mh = [];
    $mh_db = new MATHANG();
    
    foreach ($_SESSION['giohang'] as $id => $soluong) {
        $m = $mh_db->laymathangtheoid($id);
        if (!$m) continue;
        
        $dongia = floatval($m['giaban'] ?? 0);
        $solg = max(0, intval($soluong));
        
        $mh[$id] = [
            'tenmathang' => $m['tenmathang'] ?? '',
            'hinhanh' => $m['hinhanh'] ?? '',
            'giaban' => $dongia,
            'soluong' => $solg,
            'thanhtien' => round($dongia * $solg, 2)
        ];
    }
    return $mh;
}

// Đếm số sản phẩm trong giỏ
function demhangtronggio() {
    return count($_SESSION['giohang']);
}

// Đếm tổng số lượng
function demsoluongtronggio() {
    return array_sum(array_column(laygiohang(), 'soluong'));
}

// Tính tổng tiền
function tinhtiengiohang() {
    return array_sum(array_column(laygiohang(), 'thanhtien'));
}

// Xóa toàn bộ giỏ hàng
function xoagiohang() {
    $_SESSION['giohang'] = [];
}
?>