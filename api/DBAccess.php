<?php
require_once('DBConnect.php');

class DBAccess{
    protected static $db;
    public static $instance;

    private function __construct(){
        self::$db = DBConnect::getConn();
        self::$instance = $this;
    }

    public static function getAccess(){
        if(!self::$instance){
            new DBAccess();
        }

        return self::$instance;
    }
    
    public function getData($query,$fields){
        try{
            $stmt = self::$db->prepare($query);
            $stmt->execute($fields);

            $result_array = [];
            while($result = $stmt->fetchObject()){
                array_push($result_array, $result);
            }

            if(sizeof($result_array) == 0){
                http_response_code(404);
                throw new Exception("Not Found");
            }

            return $result_array;

        }catch(PDOException $e){
            throw new Exception("Query error");
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    public function postData($query,$fields){
        try{
            $stmt = self::$db->prepare($query);
            $stmt->execute($fields);

            return "Successfully";
        }catch(PDOException $e){
            throw new Exception("Query error");
        }
    }
}