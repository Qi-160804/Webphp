<?php
if (!class_exists('DATABASE')) {

class DATABASE{
    private static $dns = "mysql:host=localhost;dbname=shop_dienthoai;port=3306;charset=utf8";
    private static $username = "root";
    private static $password = "";
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );    
    private static $db;
    
    private function __construct() {} 
    
    public static function connect(){
        if(!isset(self::$db)){
            try{
                self::$db = new PDO(self::$dns, self::$username, self::$password, self::$options);
            }
            catch(PDOException $e){
                echo "<p style='color:red;font-weight:bold;'>Lỗi kết nối CSDL: " . $e->getMessage() . "</p>";
                exit();
            }
        }
        return self::$db;
    }
    
    public static function close(){
        self::$db = null;
    }
}
} 
?>