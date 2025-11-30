<?php
// public/inc/functions.php - TOÀN BỘ NỘI DUNG HOÀN CHỈNH

if (!function_exists('sendMail')) {
    function sendMail($to, $name, $subject, $content) {
        // TEST MODE LOCAL – HIỆN LINK TRỰC TIẾP KHÔNG GỬI EMAIL
        preg_match('/href=["\'](.*?)["\']/', $content, $matches);
        $link = $matches[1] ?? '#';

        echo '<div class="container mt-5">
                <div class="alert alert-success text-center p-5">
                    <h4>TEST MODE – KHÔNG GỬI EMAIL</h4>
                    <p>Click nút dưới đây để đổi mật khẩu ngay:</p>
                    <a href="'.$link.'" class="btn btn-primary btn-lg px-5" target="_blank">
                        MỞ TRANG ĐẶT LẠI MẬT KHẨU
                    </a>
                </div>
              </div>';
        return true;
    }
}

if (!function_exists('showAlert')) {
    function showAlert() {
        if (isset($_SESSION['alert'])) {
            $type = $_SESSION['alert']['type'] ?? 'info';
            $msg  = $_SESSION['alert']['msg'] ?? '';
            echo '<div class="alert alert-' . $type . ' alert-dismissible fade show mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    ' . htmlspecialchars($msg) . '
                  </div>';
            unset($_SESSION['alert']);
        }
    }
}

if (!function_exists('demhangtronggio')) {
    function demhangtronggio() {
        $tong = 0;
        if (isset($_SESSION['giohang']) && is_array($_SESSION['giohang'])) {
            foreach ($_SESSION['giohang'] as $soluong) {
                $tong += (int)$soluong;
            }
        }
        return $tong;
    }
}
?>