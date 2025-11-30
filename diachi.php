<?php
class DIACHI{
	
	// Thêm địa chỉ mới, trả về khóa của dòng mới thêm
	public function themdiachi($nguoidung_id,$diachi){
		$db = DATABASE::connect();
		try{
			$sql = "INSERT INTO diachi(nguoidung_id, diachi) VALUES(:nguoidung_id,:diachi)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':nguoidung_id',$nguoidung_id);			
			$cmd->bindValue(':diachi',$diachi);			
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		}
		catch(PDOException $e){
			$error_message=$e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Lấy địa chỉ của khách
    public function laydiachikhachhang($id){
        $dbcon = DATABASE::connect();
        try{
            $sql = "SELECT * FROM diachi WHERE nguoidung_id=:id AND macdinh=1 LIMIT 1";
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
	// Cập nhật địa chỉ mặc định của khách hàng
public function capnhatdiachi($nguoidung_id, $diachi_moi) {
    $db = DATABASE::connect();
    try{
        // Kiểm tra xem đã có địa chỉ mặc định chưa
        $sql_check = "SELECT id FROM diachi WHERE nguoidung_id=:nguoidung_id AND macdinh=1";
        $cmd_check = $db->prepare($sql_check);
        $cmd_check->bindValue(':nguoidung_id', $nguoidung_id);
        $cmd_check->execute();
        $existing_address = $cmd_check->fetch();
        
        if ($existing_address) {
            // Cập nhật địa chỉ hiện có
            $sql = "UPDATE diachi SET diachi=:diachi WHERE id=:id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':diachi', $diachi_moi);
            $cmd->bindValue(':id', $existing_address['id']);
        } else {
            // Thêm địa chỉ mới
            $sql = "INSERT INTO diachi(nguoidung_id, diachi, macdinh) VALUES(:nguoidung_id, :diachi, 1)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':nguoidung_id', $nguoidung_id);
            $cmd->bindValue(':diachi', $diachi_moi);
        }
        
        $result = $cmd->execute();
        return $result;
    }
    catch(PDOException $e){
        $error_message=$e->getMessage();
        error_log("Lỗi cập nhật địa chỉ: $error_message");
        return false;
    }
}

}
?>
