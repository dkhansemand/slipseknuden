<?php

class log extends dbconnector{
   
    private function logError($error){
        if(is_array($error)){
            ##Insert error into DB
            
        }else{
            $internalError = 'Fejl skal angives i et array med fejlkode, fejlbesked og bruger sessions ID';
            return $internalError;
        }
    }

    public function logUser($userInfo){
        if(is_array($userInfo)){
            $logCode = (int)$userInfo['logCode'];
            $logMsg = $userInfo['logMsg'];
            $logUserId = $userInfo['logId'];
            $logIp = $this->getIP();

            $queryLog = $this->newQuery("INSERT INTO log (logCode, logMessage, logIp, logUser)VALUES(:CODE, :MSG, :IP, :USERID)");
            $queryLog->bindParam(':CODE', $logCode, PDO::PARAM_INT);
            $queryLog->bindParam(':MSG', $logMsg, PDO::PARAM_STR);
            $queryLog->bindParam(':IP', $logIp, PDO::PARAM_STR);
            $queryLog->bindParam(':USERID', $logUserId, PDO::PARAM_INT);

            if($queryLog->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            $internalError = 'Bruger logging skal angives i et array med log kode (int), log besked(String og brugernavn(String)';
            return $internalError;
        }
    }

    private function getIP(){
        $userIP = $_SERVER['REMOTE_ADDR'];
        return $userIP;
    }
}
