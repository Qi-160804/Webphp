<?php

if (!class_exists('NGUOIDUNG')) {

class NGUOIDUNG {
    private $db;
    
    // Constants for user types
    const ADMIN = 1;
    const STAFF = 2;
    const CUSTOMER = 3;
    
    // User properties
    private $id, $email, $sodienthoai, $matkhau, $hoten, $loai, $trangthai, $hinhanh;
    
    public function __construct() {
        $this->db = DATABASE::connect();
    }
    
    // Getters and Setters
    public function getid() { return $this->id; }
    public function setid($value) { $this->id = $value; }
    public function getemail() { return $this->email; }
    public function setemail($value) { $this->email = $value; }
    public function getsodienthoai() { return $this->sodienthoai; }
    public function setsodienthoai($value) { $this->sodienthoai = $value; }
    public function getmatkhau() { return $this->matkhau; }
    public function setmatkhau($value) { $this->matkhau = $value; }
    public function gethoten() { return $this->hoten; }
    public function sethoten($value) { $this->hoten = $value; }
    public function getloai() { return $this->loai; }
    public function setloai($value) { $this->loai = $value; }
    public function gettrangthai() { return $this->trangthai; }
    public function settrangthai($value) { $this->trangthai = $value; }
    public function gethinhanh() { return $this->hinhanh; }
    public function sethinhanh($value) { $this->hinhanh = $value; }
    
    // Kiểm tra người dùng hợp lệ
    public function kiemtranguoidunghople($email, $matkhau) {
        return $this->executeCheck(
            "SELECT id FROM nguoidung WHERE email=:email AND matkhau=:matkhau AND trangthai=1",
            [':email' => $email, ':matkhau' => md5($matkhau)]
        );
    }
    
    // Lấy thông tin người dùng theo email
    public function laythongtinnguoidung($email) {
        return $this->executeFetch(
            "SELECT * FROM nguoidung WHERE email=:email",
            [':email' => $email]
        );
    }
    
    // Lấy thông tin người dùng theo ID
    public function laythongtinnguoidungtheoid($id) {
        return $this->executeFetch(
            "SELECT * FROM nguoidung WHERE id=:id",
            [':id' => $id]
        );
    }
    
    // Cập nhật thông tin người dùng
    public function capnhatnguoidung($nguoidung) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET sodienthoai=:sodienthoai, hoten=:hoten, hinhanh=:hinhanh WHERE id=:id",
            [
                ':sodienthoai' => $nguoidung->getsodienthoai(),
                ':hoten' => $nguoidung->gethoten(),
                ':hinhanh' => $nguoidung->gethinhanh(),
                ':id' => $nguoidung->getid()
            ]
        );
    }
    
    // Đổi mật khẩu
    public function doimatkhau($nguoidung) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET matkhau=:matkhau WHERE email=:email",
            [':matkhau' => md5($nguoidung->getmatkhau()), ':email' => $nguoidung->getemail()]
        );
    }
    
    // Lấy danh sách người dùng
    public function laydanhsachnguoidung($loai = null) {
        $sql = "SELECT * FROM nguoidung WHERE 1=1";
        $params = [];
        
        if ($loai !== null) {
            $sql .= " AND loai=:loai";
            $params[':loai'] = $loai;
        }
        
        $sql .= " ORDER BY id DESC";
        return $this->executeFetchAll($sql, $params);
    }
    
    // Thêm người dùng mới
    public function themnguoidung($nguoidung) {
        return $this->executeUpdate(
            "INSERT INTO nguoidung (email, sodienthoai, matkhau, hoten, loai, trangthai, hinhanh) 
             VALUES (:email, :sodienthoai, :matkhau, :hoten, :loai, :trangthai, :hinhanh)",
            [
                ':email' => $nguoidung->getemail(),
                ':sodienthoai' => $nguoidung->getsodienthoai(),
                ':matkhau' => md5($nguoidung->getmatkhau()),
                ':hoten' => $nguoidung->gethoten(),
                ':loai' => $nguoidung->getloai(),
                ':trangthai' => $nguoidung->gettrangthai(),
                ':hinhanh' => $nguoidung->gethinhanh()
            ]
        );
    }
    
    // Xóa người dùng
    public function xoanguoidung($id) {
        return $this->executeUpdate("DELETE FROM nguoidung WHERE id=:id", [':id' => $id]);
    }
    
    // Cập nhật loại người dùng
    public function capnhatloainguoidung($id, $loai) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET loai=:loai WHERE id=:id",
            [':loai' => $loai, ':id' => $id]
        );
    }
    
    // Cập nhật trạng thái người dùng
    public function capnhattrangthainguoidung($id, $trangthai) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET trangthai=:trangthai WHERE id=:id",
            [':trangthai' => $trangthai, ':id' => $id]
        );
    }
    
    // Kiểm tra email đã tồn tại
    public function kiemtraemailtonTai($email, $id = null) {
        $sql = "SELECT id FROM nguoidung WHERE email=:email";
        $params = [':email' => $email];
        
        if ($id !== null) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        
        return $this->executeCheck($sql, $params);
    }
    
    // Kiểm tra quyền
    public function kiemtraquyen($loaiyeucau) {
        if (!isset($_SESSION["nguoidung"])) return false;
        
        $loainguoidung = $_SESSION["nguoidung"]["loai"];
        
        $quyenMap = [
            'admin' => [$loainguoidung == self::ADMIN],
            'staff' => [in_array($loainguoidung, [self::ADMIN, self::STAFF])],
            'customer' => [$loainguoidung == self::CUSTOMER]
        ];
        
        return $quyenMap[$loaiyeucau][0] ?? false;
    }
    
    // Lấy danh sách quyền
    public function laydanhsachquyen() {
        if (!isset($_SESSION["nguoidung"])) return [];
        
        $quyenTheoLoai = [
            self::ADMIN => ['qlnguoidung', 'qldanhmuc', 'qlmathang', 'qlkhachhang', 'qldonhang', 'qldoanhthu', 'qlhethong'],
            self::STAFF => ['qldanhmuc', 'qlmathang', 'qlkhachhang', 'qldonhang'],
            self::CUSTOMER => []
        ];
        
        return $quyenTheoLoai[$_SESSION["nguoidung"]["loai"]] ?? [];
    }
    
    // Kiểm tra có quyền module
    public function coquyen($module) {
        return isset($_SESSION["nguoidung"]) && in_array($module, $this->laydanhsachquyen());
    }
    
    // Lấy tên loại người dùng
    public function laytenloai($loai = null) {
        $loai = $loai ?? ($_SESSION["nguoidung"]["loai"] ?? null);
        
        $tenLoai = [
            self::ADMIN => "Quản trị viên",
            self::STAFF => "Nhân viên",
            self::CUSTOMER => "Khách hàng"
        ];
        
        return $tenLoai[$loai] ?? "Không xác định";
    }
    
    // Lấy badge cho loại người dùng
    public function laybadgeloai($loai = null) {
        $loai = $loai ?? ($_SESSION["nguoidung"]["loai"] ?? null);
        
        $badges = [
            self::ADMIN => "<span class='badge bg-danger'>Quản trị viên</span>",
            self::STAFF => "<span class='badge bg-primary'>Nhân viên</span>",
            self::CUSTOMER => "<span class='badge bg-success'>Khách hàng</span>"
        ];
        
        return $badges[$loai] ?? "<span class='badge bg-secondary'>Không xác định</span>";
    }
    
    // Lấy badge cho trạng thái
    public function laybadgetrangthai($trangthai) {
        return $trangthai == 1 
            ? "<span class='badge bg-success'>Hoạt động</span>" 
            : "<span class='badge bg-danger'>Khóa</span>";
    }
    
    // Thống kê người dùng
    public function thongkenguoidung() {
        try {
            $stmt = $this->db->prepare("SELECT 
                    COUNT(*) as tong,
                    SUM(CASE WHEN loai = 1 THEN 1 ELSE 0 END) as admin,
                    SUM(CASE WHEN loai = 2 THEN 1 ELSE 0 END) as staff,
                    SUM(CASE WHEN loai = 3 THEN 1 ELSE 0 END) as customer,
                    SUM(CASE WHEN trangthai = 1 THEN 1 ELSE 0 END) as hoatdong,
                    SUM(CASE WHEN trangthai = 0 THEN 1 ELSE 0 END) as khóa
                FROM nguoidung");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi thongkenguoidung: " . $e->getMessage());
            return ['tong' => 0, 'admin' => 0, 'staff' => 0, 'customer' => 0, 'hoatdong' => 0, 'khóa' => 0];
        }
    }
    
    // Helper methods
    private function executeCheck($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Lỗi executeCheck: " . $e->getMessage());
            return false;
        }
    }
    
    private function executeFetch($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi executeFetch: " . $e->getMessage());
            return null;
        }
    }
    
    private function executeFetchAll($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi executeFetchAll: " . $e->getMessage());
            return [];
        }
    }
    
    private function executeUpdate($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Lỗi executeUpdate: " . $e->getMessage());
            return false;
        }
    }
}

}
?>