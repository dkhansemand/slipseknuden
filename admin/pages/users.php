<?php

    ##Quick script to add user - for the tests - ONLY for DEV
   /* require_once '../../assets/lib/class.mysql.php';
     $conn = new dbconnector();
    $username = 'admin';
    $password = '1234';
    $firstname = '';
    $lastname = '';
    $title = 'Administrator';
    $email    = 'admin@slipseknuden.shop';

    $options  = array('cost' => 10);
    $hash     = password_hash($password, PASSWORD_BCRYPT, $options);

    $query = $conn->newQuery("INSERT INTO users (userName, userPassword, userEmail, userFirstname, userLastname, userTitle) VALUES (:username, '$hash', :email, :firstname, :lastname, :title)");
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':title', $title, PDO::PARAM_STR);

    if($query->execute()){
        $conn = null;
        $success = 'Din bruger er nu oprettet!';
        echo $success;
        
    }*/


?>