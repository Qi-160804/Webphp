<?php
class DONHANG{
    // CONSTANTS FOR ORDER STATUS - 3 TRẠNG THÁI
    const CHO_XAC_NHAN = 1;
    const DANG_GIAO = 2;
    const DA_GIAO = 3;
    
    // Get status text
    public static function getStatusText($status) {
        $statuses = [
            self::CHO_XAC_NHAN => 'Chờ xác nhận',
            self::DANG_GIAO => 'Đang giao',
            self::DA_GIAO => 'Đã giao'
        ];
        return $statuses[$status] ?? 'Không xác định';
    }
    
    // Get status color
    public static function getStatusColor($status) {
        $colors = [
            self::CHO_XAC_NHAN => 'bg-info',
            self::DANG_GIAO => 'bg-warning',
            self::DA_GIAO => 'bg-success'
        ];
        return $colors[$status] ?? 'bg-secondary';
    }
    
    // Get status icon
    public static function getStatusIcon($status) {
        $icons = [
            self::CHO_XAC_NHAN => 'bi-clock',
            self::DANG_GIAO => 'bi-truck',
            self::DA_GIAO => 'bi-check-circle'
        ];
        return $icons[$status] ?? 'bi-question-circle';
    }

    private $id, $nguoidung_id, $diachi_id, $ngay, $tongtien, $ghichu, $trangthai;

    // Getter và Setter
    public function getid(){ return $this->id; }
    public function setid($value){ $this->id = $value; }
    public function getnguoidung_id(){ return $this->nguoidung_id; }
    public function setnguoidung_id($value){ $this->nguoidung_id = $value; }
    public function getdiachi_id(){ return $this->diachi_id; }
    public function setdiachi_id($value){ $this->diachi_id = $value; }
    public function getngay(){ return $this->ngay; }
    public function setngay($value){ $this->ngay = $value; }
    public function gettongtien(){ return $this->tongtien; }
    public function settongtien($value){ $this->tongtien = $value; }
    public function getghichu(){ return $this->ghichu; }
    public function setghichu($value){ $this->ghichu = $value; }
    public function gettrangthai(){ return $this->trangthai; }
    public function settrangthai($value){ $this->trangthai = $value; }
	
    // Thêm đơn hàng mới
    public function themdonhang($nguoidung_id, $diachi_id, $tongtien, $ghichu = null){
        $db = DATABASE::connect();
        try{
            $sql = "INSERT INTO donhang(nguoidung_id, diachi_id, tongtien, ghichu, trangthai) 
                    VALUES(:nguoidung_id, :diachi_id, :tongtien, :ghichu, 1)";
            $cmd = $db->prepare($sql);
            $cmd->execute([
                ':nguoidung_id' => $nguoidung_id,
                ':diachi_id' => $diachi_id,
                ':tongtien' => $tongtien,
                ':ghichu' => $ghichu
            ]);
            return $db->lastInsertId();
        }
        catch(PDOException $e){
            error_log("Lỗi themdonhang: " . $e->getMessage());
            return false;
        }
    }
	
    // Đọc ds đơn hàng của 1 khách
    public function laydanhsachdonhangtheokh($id, $page = 1, $limit = 10){
        $dbcon = DATABASE::connect();
        try{
            $offset = ($page - 1) * $limit;
            $sql = "SELECT dh.*, dc.diachi 
                    FROM donhang dh 
                    LEFT JOIN diachi dc ON dh.diachi_id = dc.id 
                    WHERE dh.nguoidung_id = :id 
                    ORDER BY dh.ngay DESC 
                    LIMIT :limit OFFSET :offset";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->bindValue(':limit', $limit, PDO::PARAM_INT);
            $cmd->bindValue(':offset', $offset, PDO::PARAM_INT);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Lỗi laydanhsachdonhangtheokh: " . $e->getMessage());
            return [];
        }
    }
	
    // Đếm đơn hàng của khách hàng
    public function demdonhang($khachhang_id) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare("SELECT COUNT(*) as total FROM donhang WHERE nguoidung_id = :khachhang_id");
            $cmd->execute([':khachhang_id' => $khachhang_id]);
            return $cmd->fetch(PDO::FETCH_ASSOC)['total'];
        }
        catch(PDOException $e){
            error_log("Lỗi demdonhang: " . $e->getMessage());
            return 0;
        }
    }
	
    // Lấy tất cả đơn hàng với phân trang
    public function laytatcadonhang($page = 1, $limit = 15, $search = '', $trangthai = '') {
        $db = DATABASE::connect();
        try{
            $offset = ($page - 1) * $limit;
            $sql = "SELECT dh.*, nd.hoten, nd.email, nd.sodienthoai, dc.diachi 
                    FROM donhang dh 
                    LEFT JOIN nguoidung nd ON dh.nguoidung_id = nd.id 
                    LEFT JOIN diachi dc ON dh.diachi_id = dc.id 
                    WHERE 1=1";
            
            $params = [];
            if(!empty($search)) {
                $sql .= " AND (dh.id LIKE :search OR nd.hoten LIKE :search OR nd.email LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }
            if(!empty($trangthai)) {
                $sql .= " AND dh.trangthai = :trangthai";
                $params[':trangthai'] = $trangthai;
            }
            
            $sql .= " ORDER BY dh.ngay DESC LIMIT :limit OFFSET :offset";
            $cmd = $db->prepare($sql);
            foreach($params as $key => $value) {
                $cmd->bindValue($key, $value);
            }
            $cmd->bindValue(':limit', $limit, PDO::PARAM_INT);
            $cmd->bindValue(':offset', $offset, PDO::PARAM_INT);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Lỗi laytatcadonhang: " . $e->getMessage());
            return [];
        }
    }
	
    // Đếm tổng số đơn hàng
    public function demtongdonhang($search = '', $trangthai = '') {
        $db = DATABASE::connect();
        try{
            $sql = "SELECT COUNT(*) as total 
                    FROM donhang dh 
                    LEFT JOIN nguoidung nd ON dh.nguoidung_id = nd.id 
                    WHERE 1=1";
            
            $params = [];
            if(!empty($search)) {
                $sql .= " AND (dh.id LIKE :search OR nd.hoten LIKE :search OR nd.email LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }
            if(!empty($trangthai)) {
                $sql .= " AND dh.trangthai = :trangthai";
                $params[':trangthai'] = $trangthai;
            }
            
            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            return $cmd->fetch(PDO::FETCH_ASSOC)['total'];
        }
        catch(PDOException $e){
            error_log("Lỗi demtongdonhang: " . $e->getMessage());
            return 0;
        }
    }
	
    // Lấy thông tin đơn hàng theo ID
    public function laythongtindonhang($id) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare("SELECT dh.*, nd.hoten, nd.email, nd.sodienthoai, dc.diachi as diachi_giaohang
                    FROM donhang dh 
                    LEFT JOIN nguoidung nd ON dh.nguoidung_id = nd.id 
                    LEFT JOIN diachi dc ON dh.diachi_id = dc.id
                    WHERE dh.id = :id");
            $cmd->execute([":id" => $id]);
            return $cmd->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Lỗi laythongtindonhang: " . $e->getMessage());
            return false;
        }
    }
	
    // Cập nhật ghi chú đơn hàng
    public function capnhatghichu($id, $ghichu) {
        return $this->executeUpdate("UPDATE donhang SET ghichu = :ghichu WHERE id = :id", 
            [':ghichu' => $ghichu, ':id' => $id], "capnhatghichu");
    }

    // Cập nhật trạng thái đơn hàng
    public function capnhattrangthai($id, $trangthai) {
        return $this->executeUpdate("UPDATE donhang SET trangthai = :trangthai WHERE id = :id", 
            [':trangthai' => $trangthai, ':id' => $id], "capnhattrangthai");
    }
    
    // Helper method cho các câu lệnh UPDATE
    private function executeUpdate($sql, $params, $logName) {
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare($sql);
            return $cmd->execute($params);
        }
        catch(PDOException $e){
            error_log("Lỗi $logName: " . $e->getMessage());
            return false;
        }
    }
	
    // Xóa đơn hàng
    public function xoadonhang($id) {
        $db = DATABASE::connect();
        try{
            $db->beginTransaction();
            $db->prepare("DELETE FROM donhangct WHERE donhang_id = :id")->execute([':id' => $id]);
            $result = $db->prepare("DELETE FROM donhang WHERE id = :id")->execute([':id' => $id]);
            $db->commit();
            return $result;
        }
        catch(PDOException $e){
            $db->rollBack();
            error_log("Lỗi xoadonhang: " . $e->getMessage());
            return false;
        }
    }
	
    public function timkiemdonhang($tukhoa = '', $trangthai = '', $sapxep = 'moinhat') {
        $db = DATABASE::connect();
        try{
            $sql = "SELECT dh.*, nd.hoten, nd.email, nd.sodienthoai, dc.diachi 
                    FROM donhang dh 
                    LEFT JOIN nguoidung nd ON dh.nguoidung_id = nd.id 
                    LEFT JOIN diachi dc ON dh.diachi_id = dc.id 
                    WHERE 1=1";
            
            $params = [];
            if(!empty($tukhoa)) {
                $sql .= " AND (dh.id LIKE :tukhoa OR nd.hoten LIKE :tukhoa OR nd.email LIKE :tukhoa)";
                $params[':tukhoa'] = '%' . $tukhoa . '%';
            }
            if(!empty($trangthai)) {
                $sql .= " AND dh.trangthai = :trangthai";
                $params[':trangthai'] = $trangthai;
            }
            
            $orderBy = [
                'cunhat' => 'dh.ngay ASC',
                'caonhat' => 'dh.tongtien DESC',
                'thapnhat' => 'dh.tongtien ASC'
            ];
            $sql .= " ORDER BY " . ($orderBy[$sapxep] ?? 'dh.ngay DESC');
            
            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Lỗi timkiemdonhang: " . $e->getMessage());
            return [];
        }
    }

    public function layThongKeTongQuan($nam = null, $thang = null, $tungay = null, $denngay = null) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT 
                        COUNT(*) as tong_don_hang,
                        COALESCE(SUM(tongtien), 0) as tong_doanh_thu,
                        AVG(tongtien) as don_hang_trung_binh
                    FROM donhang 
                    WHERE trangthai = 3";

            $params = [];
            if (!empty($nam)) {
                $sql .= " AND YEAR(ngay) = :nam";
                $params[':nam'] = $nam;
            }
            if (!empty($thang)) {
                $sql .= " AND MONTH(ngay) = :thang";
                $params[':thang'] = $thang;
            }
            if (!empty($tungay) && !empty($denngay)) {
                $sql .= " AND DATE(ngay) BETWEEN :tungay AND :denngay";
                $params[':tungay'] = $tungay;
                $params[':denngay'] = $denngay;
            }

            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            $result = $cmd->fetch(PDO::FETCH_ASSOC);
            
            $result['tang_truong'] = 0;
            $result['don_hang_trung_binh'] = $result['don_hang_trung_binh'] ?? 0;
            return $result;
            
        } catch (PDOException $e) {
            error_log("Lỗi layThongKeTongQuan: " . $e->getMessage());
            return [
                'tong_don_hang' => 0,
                'tong_doanh_thu' => 0,
                'don_hang_trung_binh' => 0,
                'tang_truong' => 0
            ];
        }
    }

    // Lấy doanh thu theo tháng
    public function layDoanhThuTheoThang($nam = null) {
        $db = DATABASE::connect();
        try {
            $nam = $nam ?? date('Y');
            $cmd = $db->prepare("SELECT 
                        MONTH(ngay) as thang,
                        COALESCE(SUM(tongtien), 0) as tong_doanh_thu,
                        COUNT(*) as so_don_hang
                    FROM donhang 
                    WHERE trangthai = 3 AND YEAR(ngay) = :nam
                    GROUP BY MONTH(ngay)
                    ORDER BY thang");
            $cmd->execute([':nam' => $nam]);
            $result = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            // Đảm bảo có đủ 12 tháng
            $full_year = [];
            for ($i = 1; $i <= 12; $i++) {
                $found = array_filter($result, fn($item) => $item['thang'] == $i);
                $full_year[] = !empty($found) ? reset($found) : [
                    'thang' => $i,
                    'tong_doanh_thu' => 0,
                    'so_don_hang' => 0
                ];
            }
            return $full_year;
        } catch (PDOException $e) {
            error_log("Lỗi layDoanhThuTheoThang: " . $e->getMessage());
            return [];
        }
    }

    // Lấy doanh thu theo năm
    public function layDoanhThuTheoNam() {
        $db = DATABASE::connect();
        try {
            $cmd = $db->prepare("SELECT 
                        YEAR(ngay) as nam,
                        COALESCE(SUM(tongtien), 0) as tong_doanh_thu,
                        COUNT(*) as so_don_hang
                    FROM donhang 
                    WHERE trangthai = 3
                    GROUP BY YEAR(ngay)
                    ORDER BY nam DESC
                    LIMIT 5");
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi layDoanhThuTheoNam: " . $e->getMessage());
            return [];
        }
    }

    // Lấy đơn hàng theo ngày
    public function layDonHangTheoNgay($tungay, $denngay) {
        return $this->executeQuery("SELECT 
                    DATE(ngay) as ngay,
                    COUNT(*) as so_don_hang,
                    COALESCE(SUM(tongtien), 0) as tong_doanh_thu
                FROM donhang 
                WHERE trangthai = 3 AND DATE(ngay) BETWEEN :tungay AND :denngay
                GROUP BY DATE(ngay)
                ORDER BY ngay", 
            [':tungay' => $tungay, ':denngay' => $denngay], 
            "layDonHangTheoNgay");
    }

    // Lấy chi tiết doanh thu
    public function layDoanhThuChiTiet($tungay, $denngay) {
        return $this->executeQuery("SELECT 
                    dh.id, dh.ngay, dh.tongtien, nd.hoten, nd.email,
                    COUNT(dhct.id) as so_san_pham
                FROM donhang dh
                LEFT JOIN nguoidung nd ON dh.nguoidung_id = nd.id
                LEFT JOIN donhangct dhct ON dh.id = dhct.donhang_id
                WHERE dh.trangthai = 3 AND DATE(dh.ngay) BETWEEN :tungay AND :denngay
                GROUP BY dh.id, dh.ngay, dh.tongtien, nd.hoten, nd.email
                ORDER BY dh.ngay DESC", 
            [':tungay' => $tungay, ':denngay' => $denngay], 
            "layDoanhThuChiTiet");
    }
    
    // Helper method cho các câu lệnh SELECT
    private function executeQuery($sql, $params, $logName) {
        $db = DATABASE::connect();
        try {
            $cmd = $db->prepare($sql);
            $cmd->execute($params);
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi $logName: " . $e->getMessage());
            return [];
        }
    }
}
?>