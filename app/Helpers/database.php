<?php
class CDB{
    private static $db = null;

    public static function connection(){
        if(!isset(self::$db)){
            try{
                self::$db=new PDO("mysql:host=localhost;dbname=unimart","root","");
                self::$db->exec("SET NAMES 'utf8'");
            }catch(PDOException $ex){
                echo "Lỗi trong quá trình kết nối CSDL". $ex->getMessage();
            }
        }
        return self::$db;
    }
}