<?php 
if (session_status() == PHP_SESSION_NONE) session_start();

require("../model/database.php");
require("../model/danhmuc.php");
require("../model/mathang.php");
require("../model/giohang.php");
require("../model/khachhang.php");
require("../model/diachi.php");
require("../model/donhang.php");
require("../model/donhangct.php");

$dm = new DANHMUC();
$danhmuc = $dm->laydanhmuc();
$mh = new MATHANG();
$mathangxemnhieu = $mh->laymathangxemnhieu();
$conn = DATABASE::connect();

$action = $_REQUEST["action"] ?? "null";

switch($action){
    case "null":
        $mathang = $mh->laymathang();
        include("main.php");
        break;
        
    case "group":
        if(isset($_REQUEST["id"])){
            $madm = $_REQUEST["id"];
            $dmuc = $dm->laydanhmuctheoid($madm);
            $tendm = $dmuc["tendanhmuc"];
            $mathang = $mh->laymathangtheodanhmuc($madm);
            include("group.php");
        } else {
            include("main.php");
        }
        break;
        
    case "detail":
        if(isset($_GET["id"])){
            $mahang = $_GET["id"];
            $mh->tangluotxem($mahang);
            $mhct = $mh->laymathangtheoid($mahang);
            $madm = $mhct["danhmuc_id"];
            $mathang = $mh->laymathangtheodanhmuc($madm);
            include("detail.php");
        }
        break;
        
    case "profile":
        if(isset($_SESSION["khachhang"])){
            include("in4kh.php");
        } else {
            echo '<script>alert("Vui lòng đăng nhập để xem thông tin cá nhân!"); location.href = "index.php?action=dangnhap";</script>';
            exit();
        }
        break;
        
    case "chovaogio":
        if(isset($_REQUEST["id"])) $id = $_REQUEST["id"];
        $soluong = $_REQUEST["soluong"] ?? 1;
        
        if(isset($_SESSION['giohang'][$id])){
            $_SESSION['giohang'][$id] += $soluong;
        } else {
            themhangvaogio($id, $soluong);
        }
        
        $giohang = laygiohang();
        include("cart.php");
        break;
        
    case "giohang":
        $giohang = laygiohang();
        include("cart.php");
        break;
        
    case "xoamotmathang":
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            if(isset($_SESSION['giohang'][$id])) {
                $mh_temp = new MATHANG();
                $sanpham = $mh_temp->laymathangtheoid($id);
                $ten_sanpham = $sanpham ? $sanpham['tenmathang'] : 'Sản phẩm';
                unset($_SESSION['giohang'][$id]);
                $_SESSION['thongbao'] = "Đã xóa '<strong>$ten_sanpham</strong>' khỏi giỏ hàng!";
            }
        }
        header("Location: index.php?action=giohang");
        exit();
        
    case "capnhatgio":
        if(isset($_REQUEST["mh"])){
            foreach ($_REQUEST["mh"] as $id => $soluong) {
                if($soluong > 0)
                    capnhatsoluong($id, $soluong);
                else 
                    xoamotmathang($id);
            }
        }
        $giohang = laygiohang();
        include("cart.php");
        break;
        
    case "xoagiohang":
        xoagiohang();
        $giohang = laygiohang();
        include("cart.php");
        break;
        
    case "thanhtoan":
        $giohang = laygiohang();
        if(isset($_SESSION["khachhang"])){
            $dc = new DIACHI();
            $diachi = $dc->laydiachikhachhang($_SESSION["khachhang"]["id"]);
        }
        include("checkout.php");
        break;
        
    case "luudonhang":
        $diachi = $_POST["txtdiachi"];
        
        if(!isset($_SESSION["khachhang"])){
            $email = $_POST["txtemail"];
            $hoten = $_POST["txthoten"];
            $sodienthoai = $_POST["txtsodienthoai"];
            
            $kh = new KHACHHANG();
            if($kh->laythongtinkhachhang($email) == null){
                $nguoidung_id = $kh->themkhachhang($email,$sodienthoai,$hoten);
                $dc = new DIACHI();
                $diachi_id = $dc->themdiachi($nguoidung_id,$diachi);
            } else {
                $khachhang = $kh->laythongtinkhachhang($email);
                $nguoidung_id = $khachhang["id"];
                $dc = new DIACHI();
                $diachi_obj = $dc->laydiachikhachhang($nguoidung_id);
                $diachi_id = $diachi_obj ? $diachi_obj["id"] : $dc->themdiachi($nguoidung_id, $diachi);
            }
        } else {
            $nguoidung_id = $_SESSION["khachhang"]["id"];
            $hoten = $_SESSION["khachhang"]["hoten"];
            $dc = new DIACHI();
            $diachi_obj = $dc->laydiachikhachhang($nguoidung_id);
            $diachi_id = $diachi_obj ? $diachi_obj["id"] : $dc->themdiachi($nguoidung_id, $diachi);
        }
        
        $dh = new DONHANG();
        $tongtien = tinhtiengiohang();
        $donhang_id = $dh->themdonhang($nguoidung_id, $diachi_id, $tongtien);
        
        if ($donhang_id) {
            $ct = new DONHANGCT();
            $giohang = laygiohang();
            foreach($giohang as $id => $mh_item){
                $ct->themchitietdonhang($donhang_id,$id,$mh_item["giaban"],$mh_item["soluong"],$mh_item["thanhtien"]);
                $mh_obj = new MATHANG();
                $mh_obj->capnhatsoluong($id, $mh_item["soluong"]);
            }
            
            xoagiohang();
            
            $_SESSION['donhang_moi'] = array(
                'id' => $donhang_id,
                'nguoidung_id' => $nguoidung_id,
                'tongtien' => $tongtien,
                'hoten' => $hoten
            );
            
            include("message.php");
            exit();
        } else {
            $_SESSION['loi'] = "Có lỗi xảy ra khi đặt hàng!";
            header('Location: index.php?action=thanhtoan');
            exit();
        }
        break;
        
    case "dangnhap":
        include("loginform.php");
        break;
        
    case "xldangnhap":
    $email = $_POST["txtemail"];
    $matkhau = $_POST["txtmatkhau"];
    $kh = new KHACHHANG();
    
    // SỬA: Dùng phương thức dangnhap thay vì kiemtrakhachhanghople
    $khachhang = $kh->dangnhap($email, $matkhau);
    if($khachhang){
        $_SESSION["khachhang"] = $khachhang;
        $_SESSION['thongbao'] = "Đăng nhập thành công! Chào mừng " . $khachhang["hoten"];
        
        // Quay về trang chủ hoặc trang trước đó
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['loi'] = "Email hoặc mật khẩu không đúng!";
        include("loginform.php");
    }
    break;
        
    case "thongtin":
        if(isset($_SESSION["khachhang"])){
            $dh = new DONHANG();
            $donhang = $dh->laydanhsachdonhangtheokh($_SESSION["khachhang"]["id"]);
            
            if(isset($_REQUEST["dhid"])){
                $dhct = new DONHANGCT();
                $donhangct = $dhct->laychitietdonhang($_REQUEST["dhid"]);
            }
        }
        include("info.php");
        break;
        
    case "dangxuat":
        unset($_SESSION["khachhang"]);
        $mathang = $mh->laymathang();
        include("main.php");
        break;
        
    case "timkiem":
        $q = trim($_GET["q"] ?? "");
        $q = htmlspecialchars($q);
        
        if ($q === "") {
            $mathang = $mh->laymathang();
            include("main.php");
        } else {
            $ketqua_timkiem = $mh->timkiem($q);
            include("search.php");
        }
        break;
        
    case "introduce":
        include("introduce.php");
        break;
        
    case "muangay":
        if(isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $soluong = $_REQUEST["soluong"] ?? 1;
            
            if(isset($_SESSION['giohang'][$id])){ 
                $_SESSION['giohang'][$id] += $soluong;
            } else { 
                themhangvaogio($id, $soluong);
            }
            
            header("Location: index.php?action=thanhtoan");
            exit();
        }
        break;
    
case "xldangky":
    $hoten = trim($_POST["txthoten"]);
    $email = trim($_POST["txtemail"]);
    $sodienthoai = trim($_POST["txtsodienthoai"]);
    $matkhau = trim($_POST["txtmatkhau"]);
    
    $kh = new KHACHHANG();
    
    // Kiểm tra dữ liệu
    if(empty($hoten) || empty($email) || empty($sodienthoai) || empty($matkhau)) {
        $_SESSION['loi'] = "Vui lòng điền đầy đủ thông tin!";
        include("loginform.php");
        break;
    }
    
    // Kiểm tra email đã tồn tại
    if($kh->kiemtraemail($email)){
        $_SESSION['loi'] = "Email này đã được đăng ký! Vui lòng sử dụng email khác.";
        include("loginform.php");
        break;
    }
    
    // DEBUG: Hiển thị thông tin trước khi đăng ký
    error_log("DEBUG ĐĂNG KÝ: Email: $email, MK: $matkhau, SDT: $sodienthoai, Tên: $hoten");
    
    // SỬA: Sử dụng phương thức dangky
    $result = $kh->dangky($hoten, $email, $matkhau, $sodienthoai);
    
    if($result !== false){
        // DEBUG: Thông báo thành công
        error_log("DEBUG: Đăng ký thành công, ID: " . $result);
        
        // Thử đăng nhập ngay
        $khachhang_moi = $kh->dangnhap($email, $matkhau);
        
        if($khachhang_moi){
            $_SESSION["khachhang"] = $khachhang_moi;
            $_SESSION['thongbao'] = "Đăng ký thành công! Chào mừng " . $hoten;
            
            // DEBUG: Thông tin session
            error_log("DEBUG: Đăng nhập thành công, Session: " . print_r($_SESSION["khachhang"], true));
            
            header("Location: index.php");
            exit();
        } else {
            // DEBUG: Lỗi đăng nhập
            error_log("DEBUG: Đăng ký thành công nhưng không đăng nhập được");
            
            $_SESSION['thongbao'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            include("loginform.php");
        }
    } else {
        // DEBUG: Lỗi đăng ký
        error_log("DEBUG: Đăng ký thất bại");
        
        $_SESSION['loi'] = "Đăng ký thất bại! Vui lòng thử lại.";
        include("loginform.php");
    }
    break;
    default:
        break;
}
?>