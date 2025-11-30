<?php
class MATHANG{
    // khai báo các thuộc tính
    private $id;
    private $tenmathang;
    private $mota;
    private $giagoc;
    private $giaban;
    private $soluongton;
    private $hinhanh;
    private $danhmuc_id; // Sửa thành danhmuc_id để thống nhất
    private $luotxem;
    private $luotmua;
    private $thongso;
    private $hinhphu;

    public function getid(){ return $this->id; }
    public function setid($value){ $this->id = $value; }
    public function gettenmathang(){ return $this->tenmathang; }
    public function settenmathang($value){ $this->tenmathang = $value; }
    public function getmota(){ return $this->mota; }
    public function setmota($value){ $this->mota = $value; }
    public function getgiagoc(){ return $this->giagoc; }
    public function setgiagoc($value){ $this->giagoc = $value; }
    public function getgiaban(){ return $this->giaban; }
    public function setgiaban($value){ $this->giaban = $value; }
    public function getsoluongton(){ return $this->soluongton; }
    public function setsoluongton($value){ $this->soluongton = $value; }
    public function gethinhanh(){ return $this->hinhanh; }
    public function sethinhanh($value){ $this->hinhanh = $value; }
    public function getdanhmuc_id(){ return $this->danhmuc_id; }
    public function setdanhmuc_id($value){ $this->danhmuc_id = $value; }
    public function getluotxem(){ return $this->luotxem; }
    public function setluotxem($value){ $this->luotxem = $value; }
    public function getluotmua(){ return $this->luotmua; }
    public function setluotmua($value){ $this->luotmua = $value; }
    public function getthongso(){ return $this->thongso; }
    public function setthongso($value){ $this->thongso = $value; }
    public function gethinhphu(){ return $this->hinhphu; }
    public function sethinhphu($value){ $this->hinhphu = $value; }


    // Lấy danh sách
    public function laymathang(){
        $dbcon = DATABASE::connect();
        try{
            $sql = "SELECT * FROM mathang ORDER BY id DESC";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            $result = $cmd->fetchAll();
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    
    // Lấy danh sách mặt hàng thuộc 1 danh mục
    public function laymathangtheodanhmuc($danhmuc_id){
        $dbcon = DATABASE::connect();
        try{
            $sql = "SELECT * FROM mathang WHERE danhmuc_id=:madm" ;
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":madm",$danhmuc_id);
            $cmd->execute();
            $result = $cmd->fetchAll();
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }

    // Lấy mặt hàng theo id
    public function laymathangtheoid($id){
        $dbcon = DATABASE::connect();
        try{
            $sql = "SELECT * FROM mathang WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $result = $cmd->fetch();             
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    
    // Cập nhật lượt xem
    public function tangluotxem($id){
        $dbcon = DATABASE::connect();
        try{
            $sql = "UPDATE mathang SET luotxem=luotxem+1 WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $result = $cmd->execute();            
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    
    // LẤY SẢN PHẨM XEM NHIỀU 
    public function laymathangxemnhieu($limit = 8){
        $dbcon = DATABASE::connect();
        try{
            $sql = "SELECT id, tenmathang, hinhanh, giaban, luotxem, mota 
                    FROM mathang 
                    ORDER BY luotxem DESC 
                    LIMIT :limit";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(':limit', $limit, PDO::PARAM_INT);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            // Ghi log thay vì die trang (chuyên nghiệp hơn)
            error_log("Lỗi laymathangxemnhieu: " . $e->getMessage());
            return []; // Trả về mảng rỗng nếu lỗi
        }
    }

    // Thêm mới - ĐÃ SỬA LỖI
    public function themmathang($mathang){
        $dbcon = DATABASE::connect();
        try{
            $sql = "INSERT INTO mathang(tenmathang, mota, thongso, giagoc, giaban, soluongton, danhmuc_id, hinhanh, luotxem, luotmua)
                    VALUES(:tenmathang, :mota, :thongso, :giagoc, :giaban, :soluongton, :danhmuc_id, :hinhanh, 0, 0)";
            
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tenmathang", $mathang->tenmathang);
            $cmd->bindValue(":mota", $mathang->mota);
            $cmd->bindValue(":thongso", $mathang->thongso);
            $cmd->bindValue(":giagoc", $mathang->giagoc);
            $cmd->bindValue(":giaban", $mathang->giaban);
            $cmd->bindValue(":soluongton", $mathang->soluongton);
            $cmd->bindValue(":danhmuc_id", $mathang->danhmuc_id);
            $cmd->bindValue(":hinhanh", $mathang->hinhanh);
            
            $result = $cmd->execute();            
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }

    // Xóa 
    public function xoamathang($mathang){
        $dbcon = DATABASE::connect();
        try{
            $sql = "DELETE FROM mathang WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $mathang->id);
            $result = $cmd->execute();            
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }

    // Cập nhật 
    public function suamathang($mathang){
        $dbcon = DATABASE::connect();
        try{
            $sql = "UPDATE mathang SET tenmathang=:tenmathang,
                                        mota=:mota,
                                        thongso=:thongso,
                                        giagoc=:giagoc,
                                        giaban=:giaban,
                                        soluongton=:soluongton,
                                        danhmuc_id=:danhmuc_id,
                                        hinhanh=:hinhanh,
                                        luotxem=:luotxem,
                                        luotmua=:luotmua
                                    WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tenmathang", $mathang->tenmathang);
            $cmd->bindValue(":mota", $mathang->mota);
            $cmd->bindValue(":thongso", $mathang->thongso);
            $cmd->bindValue(":giagoc", $mathang->giagoc);
            $cmd->bindValue(":giaban", $mathang->giaban);
            $cmd->bindValue(":soluongton", $mathang->soluongton);
            $cmd->bindValue(":danhmuc_id", $mathang->danhmuc_id);
            $cmd->bindValue(":hinhanh", $mathang->hinhanh);
            $cmd->bindValue(":luotxem", $mathang->luotxem);
            $cmd->bindValue(":luotmua", $mathang->luotmua);
            $cmd->bindValue(":id", $mathang->id);
            $result = $cmd->execute();            
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    
    // Cập nhật số lượng tồn
    public function capnhatsoluong($id, $soluong){
        $dbcon = DATABASE::connect();
        try{
            $sql = "UPDATE mathang SET soluongton=soluongton - :soluong WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":soluong", $soluong);
            $cmd->bindValue(":id", $id);
            $result = $cmd->execute();            
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    
    // CẬP NHẬT ẢNH PHỤ
    public function capnhathinhphu($id, $hinhphu){
        $dbcon = DATABASE::connect();
        try{
            $sql = "UPDATE mathang SET hinhphu = :hinhphu WHERE id = :id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":hinhphu", $hinhphu);
            $cmd->bindValue(":id", $id);
            return $cmd->execute();
        }catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p class='text-danger'>Lỗi cập nhật ảnh phụ: $error_message</p>";
            return false;
        }
    }
    
    // TÌM KIẾM MẶT HÀNG THEO TỪ KHÓA (tên sản phẩm)
    public function timkiem($tukhoa){
        $dbcon = DATABASE::connect();
        try{
            $sql = "SELECT mh.*, dm.tendanhmuc 
                    FROM mathang mh 
                    LEFT JOIN danhmuc dm ON mh.danhmuc_id = dm.id 
                    WHERE mh.tenmathang LIKE :tukhoa 
                    ORDER BY mh.id DESC";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tukhoa", "%$tukhoa%");
            $cmd->execute();
            $result = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p class='text-danger'>Lỗi tìm kiếm: $error_message</p>";
            exit();
        }
    }
}
?>