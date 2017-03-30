<?php
## Class that handles the MySQL connection
class dbconnector {
    const   SERVER = 'localhost',
            USERNAME = 'root',
            PASSWORD = '',
            DATABASE = 'slipseknuden';


    private function newPDOConn(){
         try{
            $PDOConn = new PDO("mysql:host=".self::SERVER.";dbname=".self::DATABASE.";charset=utf8", self::USERNAME, self::PASSWORD,
            array(
                PDO::ATTR_TIMEOUT => 10,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
            return $PDOConn;
        }catch(PDOException $err){
            $PDOConn = null;
            return 'Connection failed: ' . $err->getMessage();
        }
    }
    public function testConnection(){
        try{
            $conn = $this->newPDOConn();
            return "Connection is working fine to server: " . self::SERVER;
        }catch(PDOException $err){
            $conn = null;
            return 'Connection failed: ' . $err->getMessage();
        }
    }

    public function newQuery($input){
         try{
            $conn = $this->newPDOConn();
            $query = $conn->prepare($input);

            return $query;
         }catch(PDOException $e){
             $conn = null;
             return $e->getMessage();
         }
    }
}
