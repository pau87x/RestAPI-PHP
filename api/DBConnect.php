<?php

class DBConnect{
    protected static $db;
    const HOST = "127.0.0.1";
    const USERNAME = "pau";
    const PASSWORD = "123456";
    const DATABASE = "db";

    private function __construct(){
        try{
            $host = self::HOST;
            $username = self::USERNAME;
            $password = self::PASSWORD;
            $db = self::DATABASE;

            self::$db = new PDO("mysql:host=$host; dbname=$db", $username, $password);

            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Database connection Error: ".$e->getMessage();
            die;
        }
    }

    public static function getConn(){
        if (!self::$db) {
            new DBConnect();
        }

        return self::$db;
    }

}
