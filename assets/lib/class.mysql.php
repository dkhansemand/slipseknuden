<?php
## Class that handles the MySQL connection
class dbconnector {
    const   SERVER = 'localhost',
            USERNAME = 'root',
            PASSWORD = '',
            DATABASE = 'hifishop';


    private function newPDOConn(){
         try{
            $PDOConn = new PDO("mysql:host=".self::SERVER.";dbname=".self::DATABASE, self::USERNAME, self::PASSWORD,
            array(
                PDO::ATTR_TIMEOUT => 10,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
            return $PDOConn;
        }catch(PDOExecption $err){
            $PDOConn = null;
            echo 'Connection failed: ' . $err->getMessage();
        }
    }
    public function testConnection(){
        try{
            $conn = $this->newPDOConn();
            echo "Connection is working fine to server: " . self::SERVER;
        }catch(PDOExecption $err){
            $conn = null;
            echo 'Connection failed: ' . $err->getMessage();
        }
    }

    public function newQuery($input){
         try{
            $conn = $this->newPDOConn();
            $query = $conn->prepare($input);

            return $query;
         }catch(PDOException $e){
             $conn = null;
             echo $e->getMessage();
         }
    }
}
