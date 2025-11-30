<?php
// admin/inc/auth.php

function kiemtraquyen($loaiyeucau = 'staff') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Chưa đăng nhập
    if (!isset($_SESSION["nguoidung"])) {
        // Chỉ redirect nếu không phải trang login
        if (strpos($_SERVER['REQUEST_URI'], 'login.php') === false && 
            strpos($_SERVER['REQUEST_URI'], 'dangnhap') === false) {
            header("Location: ../ktnguoidung/login.php");
            exit;
        }
        return false;
    }
    
    // Đã đăng nhập, kiểm tra quyền
    // THÊM REQUIRE DATABASE TRƯỚC KHI REQUIRE NGUOIDUNG
    require_once("../../model/database.php");
    require_once("../../model/nguoidung.php");
    
    $nd = new NGUOIDUNG();
    $loainguoidung = $_SESSION["nguoidung"]["loai"];
    
    // Khách hàng (loai = 3) không được vào admin
    if ($loainguoidung == 3) {
        header("Location: ../../index.php?error=not_admin");
        exit;
    }
    
    // Kiểm tra quyền cụ thể
    if (!$nd->kiemtraquyen($loaiyeucau)) {
        hienthiloikhongcoquyen();
        exit;
    }
    
    return true;
}

function kiemtraquyenmodule($module) {
    if (!isset($_SESSION["nguoidung"])) {
        return false;
    }
    
    // THÊM REQUIRE Ở ĐÂY NỮA
    require_once("../../model/database.php");
    require_once("../../model/nguoidung.php");
    
    $nd = new NGUOIDUNG();
    return $nd->coquyen($module);
}

function hienthiloikhongcoquyen() {
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="utf-8">
        <title>Không có quyền truy cập</title>
        <link href="../inc/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h4 class="mb-0"><i class="align-middle me-2" data-feather="alert-triangle"></i> Không có quyền truy cập</h4>
                        </div>
                        <div class="card-body text-center">
                            <i class="align-middle text-danger mb-3" data-feather="lock" style="width: 64px; height: 64px;"></i>
                            <h5 class="text-danger">Bạn không có quyền truy cập trang này</h5>
                            <p class="text-muted">Liên hệ quản trị viên để được cấp quyền nếu bạn cần truy cập.</p>
                            <div class="mt-4">
                                <a href="../ktnguoidung/index.php" class="btn btn-primary me-2">
                                    <i class="align-middle me-1" data-feather="home"></i> Về trang chủ
                                </a>
                                <a href="../ktnguoidung/index.php?action=dangxuat" class="btn btn-outline-secondary">
                                    <i class="align-middle me-1" data-feather="log-out"></i> Đăng xuất
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../inc/js/app.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                feather.replace();
            });
        </script>
    </body>
    </html>
    <?php
}
?>