<?php

    ##Quick script to add user - for the tests - ONLY for DEV
    /*require_once '../../lib/class.mysql.php';
     $conn = new dbconnector();
    $username = 'admin';
    $password = '1234';
    $email    = 'admin@butik.hifi';

    $options  = array('cost' => 10);
    $hash     = password_hash($password, PASSWORD_BCRYPT, $options);

    $query = $conn->newQuery("INSERT INTO hifi_users (username, userPwd, userEmail) VALUES (:username, '$hash', :email)");
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    if($query->execute()){
        $conn = null;
        $success = 'Din bruger er nu oprettet!';
        echo $success;
        
    }*/


?>