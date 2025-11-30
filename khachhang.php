<?php
class KHACHHANG {
    
    // Thêm khách hàng mới
    public function themkhachhang($email, $sodienthoai, $hoten, $matkhau = null) {
        $db = DATABASE::connect();
        try {
            // Nếu không có mật khẩu, tạo mật khẩu mặc định từ số điện thoại
            if ($matkhau === null) {
                $matkhau = $sodienthoai;
            }
            
            $sql = "INSERT INTO nguoidung (email, matkhau, sodienthoai, hoten, loai, trangthai) 
                    VALUES (:email, :matkhau, :sodienthoai, :hoten, 3, 1)";
            
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                ':email' => $email,
                ':matkhau' => md5($matkhau),
                ':sodienthoai' => $sodienthoai,
                ':hoten' => $hoten
            ]);
            
            if ($result) {
                return $db->lastInsertId();
            }
            return false;
            
        } catch (PDOException $e) {
            error_log("Lỗi themkhachhang: " . $e->getMessage());
            return false;
        }
    }

    // Phương thức đăng ký mới
    public function dangky($hoten, $email, $matkhau, $sodienthoai) {
        return $this->themkhachhang($email, $sodienthoai, $hoten, $matkhau);
    }
    
    // Kiểm tra khách hàng hợp lệ
    public function kiemtrakhachhanghople($email, $matkhau) {
        return $this->executeCheck(
            "SELECT id FROM nguoidung WHERE email=:email AND matkhau=:matkhau AND trangthai=1 AND loai=3",
            [':email' => $email, ':matkhau' => md5($matkhau)]
        );
    }
    
    // Lấy thông tin khách hàng theo email
    public function laythongtinkhachhang($email) {
        return $this->executeFetch(
            "SELECT * FROM nguoidung WHERE email=:email AND loai=3",
            [':email' => $email]
        );
    }

    // Đăng nhập
    public function dangnhap($email, $matkhau) {
        return $this->executeFetch(
            "SELECT * FROM nguoidung WHERE email=:email AND matkhau=:matkhau AND trangthai=1 AND loai=3",
            [':email' => $email, ':matkhau' => md5($matkhau)]
        );
    }

    // Kiểm tra email tồn tại
    public function kiemtraemail($email) {
        return $this->executeCheck(
            "SELECT id FROM nguoidung WHERE email=:email AND loai=3",
            [':email' => $email]
        );
    }

    // Cập nhật thông tin
    public function capnhatthongtin($id, $hoten, $sodienthoai, $trangthai) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET hoten=:hoten, sodienthoai=:sodienthoai, trangthai=:trangthai 
             WHERE id=:id AND loai=3",
            [':hoten' => $hoten, ':sodienthoai' => $sodienthoai, ':trangthai' => $trangthai, ':id' => $id]
        );
    }

    // Kiểm tra mật khẩu
    public function kiemtramatkhau($id, $matkhau) {
        return $this->executeCheck(
            "SELECT id FROM nguoidung WHERE id=:id AND matkhau=:matkhau AND loai=3",
            [':id' => $id, ':matkhau' => md5($matkhau)]
        );
    }

    // Đổi mật khẩu
    public function doimatkhau($id, $matkhau_moi) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET matkhau=:matkhau WHERE id=:id AND loai=3",
            [':matkhau' => md5($matkhau_moi), ':id' => $id]
        );
    }

    // Lấy thông tin theo ID
    public function laythongtintheoid($id) {
        return $this->executeFetch(
            "SELECT * FROM nguoidung WHERE id=:id AND loai=3",
            [':id' => $id]
        );
    }

    // Lấy tất cả khách hàng
    public function laytatcakhachhang() {
        return $this->executeFetchAll(
            "SELECT * FROM nguoidung WHERE loai = 3 ORDER BY id DESC"
        );
    }

    // Cập nhật trạng thái
    public function capnhattrangthai($id, $trangthai) {
        return $this->executeUpdate(
            "UPDATE nguoidung SET trangthai=:trangthai WHERE id=:id AND loai=3",
            [':trangthai' => $trangthai, ':id' => $id]
        );
    }

    // Tìm kiếm khách hàng
    public function timkiemkhachhang($tukhoa) {
        return $this->executeFetchAll(
            "SELECT * FROM nguoidung WHERE loai = 3 AND 
             (hoten LIKE :tukhoa OR email LIKE :tukhoa OR sodienthoai LIKE :tukhoa) 
             ORDER BY id DESC",
            [':tukhoa' => '%' . $tukhoa . '%']
        );
    }

    // Lấy top khách hàng - PHIÊN BẢN TEST ĐƠN GIẢN
public function layTopKhachHang($nam = null, $thang = null, $tungay = null, $denngay = null, $limit = 5) {
    $db = DATABASE::connect();
    try {
        // Đầu tiên, kiểm tra xem có khách hàng và đơn hàng không
        $sql_check = "SELECT COUNT(*) as total_kh FROM nguoidung WHERE loai = 3";
        $check_kh = $db->query($sql_check)->fetch(PDO::FETCH_ASSOC);
        
        $sql_check_dh = "SELECT COUNT(*) as total_dh FROM donhang";
        $check_dh = $db->query($sql_check_dh)->fetch(PDO::FETCH_ASSOC);
        
        error_log("DEBUG: Tổng khách hàng: " . $check_kh['total_kh'] . ", Tổng đơn hàng: " . $check_dh['total_dh']);
        
        // Query chính - đơn giản nhất
        $sql = "SELECT 
                    nd.id, nd.hoten, nd.email, nd.sodienthoai,
                    COUNT(dh.id) as so_don_hang,
                    COALESCE(SUM(dh.tongtien), 0) as tong_tien_mua
                FROM nguoidung nd
                LEFT JOIN donhang dh ON nd.id = dh.nguoidung_id
                WHERE nd.loai = 3
                GROUP BY nd.id, nd.hoten, nd.email, nd.sodienthoai
                ORDER BY tong_tien_mua DESC
                LIMIT 5";
        
        $cmd = $db->prepare($sql);
        $cmd->execute();
        
        $result = $cmd->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("DEBUG: Kết quả top khách hàng: " . print_r($result, true));
        
        return $result;
        
    } catch (PDOException $e) {
        error_log("Lỗi layTopKhachHang: " . $e->getMessage());
        return [];
    }
}

    // Helper methods để giảm code lặp
    private function executeCheck($sql, $params = []) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            $result = $cmd->rowCount() > 0;
            $cmd->closeCursor();
            return $result;
        }
        catch(PDOException $e){
            error_log("Lỗi executeCheck: " . $e->getMessage());
            return false;
        }
    }

    private function executeFetch($sql, $params = []) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            $result = $cmd->fetch();
            $cmd->closeCursor();
            return $result;
        }
        catch(PDOException $e){
            error_log("Lỗi executeFetch: " . $e->getMessage());
            return false;
        }
    }

    private function executeFetchAll($sql, $params = []) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            $result = $cmd->fetchAll();
            $cmd->closeCursor();
            return $result;
        }
        catch(PDOException $e){
            error_log("Lỗi executeFetchAll: " . $e->getMessage());
            return [];
        }
    }

    private function executeUpdate($sql, $params = []) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare($sql);
            return $cmd->execute($params);
        }
        catch(PDOException $e){
            error_log("Lỗi executeUpdate: " . $e->getMessage());
            return false;
        }
    }
}
?>