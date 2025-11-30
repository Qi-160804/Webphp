<?php
class DONHANGCT{
	
    // Thêm chi tiết đơn hàng mới
    public function themchitietdonhang($donhang_id, $mathang_id, $dongia, $soluong, $thanhtien){
        $db = DATABASE::connect();
        try{
            $cmd = $db->prepare("INSERT INTO donhangct(donhang_id, mathang_id, dongia, soluong, thanhtien) 
                    VALUES(:donhang_id, :mathang_id, :dongia, :soluong, :thanhtien)");
            $cmd->execute([
                ':donhang_id' => $donhang_id,
                ':mathang_id' => $mathang_id,
                ':dongia' => $dongia,
                ':soluong' => $soluong,
                ':thanhtien' => $thanhtien
            ]);
            return $db->lastInsertId();
        }
        catch(PDOException $e){
            error_log("Lỗi themchitietdonhang: " . $e->getMessage());
            return false;
        }
    }

    // Đọc chi tiết 1 đơn hàng
    public function laychitietdonhang($id){
        $dbcon = DATABASE::connect();
        try{
            $cmd = $dbcon->prepare("SELECT c.*, m.id as mhid, m.tenmathang, m.hinhanh 
                    FROM donhangct c 
                    INNER JOIN mathang m ON c.mathang_id = m.id 
                    WHERE c.donhang_id = :id 
                    ORDER BY c.id DESC");
            $cmd->execute([":id" => $id]);
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            error_log("Lỗi laychitietdonhang: " . $e->getMessage());
            return [];
        }
    }

    // Lấy top sản phẩm bán chạy
    public function layTopSanPhamBanChay($nam = null, $thang = null, $tungay = null, $denngay = null, $limit = 5) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT 
                        mh.tenmathang,
                        mh.hinhanh,
                        SUM(dhct.soluong) as tong_so_luong,
                        SUM(dhct.soluong * dhct.dongia) as tong_doanh_thu
                    FROM donhangct dhct
                    INNER JOIN mathang mh ON dhct.mathang_id = mh.id
                    INNER JOIN donhang dh ON dhct.donhang_id = dh.id
                    WHERE dh.trangthai = 3";
            
            $params = [];
            
            if (!empty($nam)) {
                $sql .= " AND YEAR(dh.ngay) = :nam";
                $params[':nam'] = $nam;
            }
            if (!empty($thang)) {
                $sql .= " AND MONTH(dh.ngay) = :thang";
                $params[':thang'] = $thang;
            }
            if (!empty($tungay) && !empty($denngay)) {
                $sql .= " AND DATE(dh.ngay) BETWEEN :tungay AND :denngay";
                $params[':tungay'] = $tungay;
                $params[':denngay'] = $denngay;
            }
            
            $sql .= " GROUP BY mh.id, mh.tenmathang, mh.hinhanh
                      ORDER BY tong_doanh_thu DESC
                      LIMIT :limit";
            
            $cmd = $db->prepare($sql);
            
            foreach ($params as $key => $value) {
                $cmd->bindValue($key, $value);
            }
            $cmd->bindValue(':limit', $limit, PDO::PARAM_INT);
            
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Lỗi layTopSanPhamBanChay: " . $e->getMessage());
            return [];
        }
    }
}
?>