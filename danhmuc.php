<?php
class DANHMUC{
    private $id;
    private $tendanhmuc;

    public function getid(){ return $this->id; }
    public function setid($value){ $this->id = $value; }
    public function gettendanhmuc(){ return $this->tendanhmuc; }
    public function settendanhmuc($value){ $this->tendanhmuc = $value; }

    // Xử lý lỗi chung
    private function handleError($e){
        echo "<p>Lỗi truy vấn: " . $e->getMessage() . "</p>";
        exit();
    }

    // Lấy danh sách
    public function laydanhmuc(){
        try{
            $sql = "SELECT * FROM danhmuc";
            $cmd = DATABASE::connect()->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch(PDOException $e){ $this->handleError($e); }
    }

    // Lấy danh mục theo id
    public function laydanhmuctheoid($id){
        try{
            $sql = "SELECT * FROM danhmuc WHERE id=:id";
            $cmd = DATABASE::connect()->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return $cmd->fetch();
        } catch(PDOException $e){ $this->handleError($e); }
    }

    // Thêm mới
    public function themdanhmuc($danhmuc){
        try{
            $sql = "INSERT INTO danhmuc(tendanhmuc) VALUES(:tendanhmuc)";
            $cmd = DATABASE::connect()->prepare($sql);
            $cmd->bindValue(":tendanhmuc", $danhmuc->tendanhmuc);
            return $cmd->execute();
        } catch(PDOException $e){ $this->handleError($e); }
    }

    // Xóa 
    public function xoadanhmuc($danhmuc){
        try{
            $sql = "DELETE FROM danhmuc WHERE id=:id";
            $cmd = DATABASE::connect()->prepare($sql);
            $cmd->bindValue(":id", $danhmuc->id);
            return $cmd->execute();
        } catch(PDOException $e){ $this->handleError($e); }
    }

    // Cập nhật 
    public function suadanhmuc($danhmuc){
        try{
            $sql = "UPDATE danhmuc SET tendanhmuc=:tendanhmuc WHERE id=:id";
            $cmd = DATABASE::connect()->prepare($sql);
            $cmd->bindValue(":tendanhmuc", $danhmuc->tendanhmuc);
            $cmd->bindValue(":id", $danhmuc->id);
            return $cmd->execute();
        } catch(PDOException $e){ $this->handleError($e); }
    }
}
?>