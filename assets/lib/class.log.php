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

    private function getIP(){
        $userIP = $_SERVER['REMOTE_ADDR'];
        return $userIP;
    }
}
