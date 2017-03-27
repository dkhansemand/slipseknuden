<?php
    require_once 'class.mysql.php';
    class getData extends dbconnector{

        public function categories(){
            try{
                $conn = $this->newQuery("SELECT categoryId, categoryName FROM categories WHERE categoryIsActive = 1 ORDER BY categoryPosition ASC");
                if($conn->execute()){
                    $returnData = $conn->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[Categories]SQL error.';
                }
                
                unset($conn);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PSOExecption $err){
                $conn = null;
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Categories]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function home(){
            try{
                $conn = $this->newQuery("SELECT pageDetailsTitle, pageDetailsText from pages 
                INNER JOIN pageDetails ON pageTxtId = pageDetailId
                WHERE pageName = 'Hjem'");
                if($conn->execute()){
                    $returnData = $conn->fetch(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[Home]SQL error.';
                }
                
                unset($conn);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PDOExecption $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Home]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function products($categoryId){
            try{
            if((int)$categoryId === 0){
                $conn = $this->newQuery("SELECT ");
            }else{
                $conn = $this->newQuery("SELECT ");
            }

            if($conn->execute()){
                $returnData = $conn->fetch(PDO::FETCH_ASSOC);
            }else{
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Home]SQL error.';
            }
            unset($conn);
            return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PDOExecption $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Home]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }
    }
