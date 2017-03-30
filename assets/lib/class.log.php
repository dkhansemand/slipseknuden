<?php

class log extends dbconnector{

    public  $logCodes = array(
        0 => 'Internal error',
        1 => 'Login',
        2 => 'Created',
        3 => 'Updated',
        4 => 'Deleted',
        5 => 'System',
        6 => 'Info'
    );
   
    public function logToFile($logDetails){
        if(is_array($logDetails)){
            ##Insert error into DB
            $date = date("d-m-Y");
            $logPath = $_SERVER['DOCUMENT_ROOT'] . '/slipseknuden/log/log_'.$date.'.log';
            $timetamp = date("d-m-Y H:i:s");
            $logCode = $logDetails['logCode'];
            $logEntry = '[' . $this->logCodes[$logCode] . '][' . $timetamp . '][UserID:' . $logDetails['logUserId'] . '] - ' . $logDetails['logMsg'] . PHP_EOL;
            if(file_exists($logPath)){
                ## Log for the current date exsist, add new log entry.
                
                file_put_contents($logPath, $logEntry, FILE_APPEND) or die("Not able to write logentry to file");
            }else{
                ## Log for the current date does not exsist, create it first. Then add new log entry
                if(fopen($logPath, 'w')){
                    file_put_contents($logPath, $logEntry, FILE_APPEND) or die("Not able to write logentry to file");
                }else{
                    return 'Not able to create file' . $logPath;
                } 
            }
        }else{
            $internalError = 'Log informationer skal angives i et array med kode (INT), fejlbesked (STRING) og bruger ID (INT)';
            return $internalError;
        }
    }

    public function logToDB($logInfo){
        if(is_array($logInfo)){
            $logCode = (int)$logInfo['logCode'];
            $logMsg = $logInfo['logMsg'];
            $logUserId = $logInfo['logUserId'];
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
            $internalError = 'Bruger logging skal angives i et array med log kode (int), log besked(String og bruger ID (INT)';
            return $internalError;
        }
    }

    private function getIP(){
        $userIP = $_SERVER['REMOTE_ADDR'];
        return $userIP;
    }
}
