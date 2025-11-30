<?php
// Chỉ khởi động session 1 lần duy nhất
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include các model
require_once("../model/database.php");
require_once("../model/mathang.php");
require_once("../model/danhmuc.php");
require_once("../model/khachhang.php");
require_once("../model/donhang.php");   

// Khởi tạo các object
$mh = new MATHANG();
$dm = new DANHMUC();
$kh = new KHACHHANG();

// QUAN TRỌNG: THÊM CÁC HÀM GIỎ HÀNG
if (!function_exists('demhangtronggio')) {
    function demhangtronggio() {
        if (isset($_SESSION['cart'])) {
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['soluong'];
            }
            return $total;
        }
        return 0;
    }
}

if (!function_exists('tinhtiengiohang')) {
    function tinhtiengiohang() {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['thanhtien'];
            }
        }
        return $total;
    }
}
?>