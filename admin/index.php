<?php
    session_start();

    ## Global check for all pages if login session is true
    if(!isset($_SESSION["isLoggedIn"])){
        header('Location: ./login.php');
        exit();
    }

if(!empty($_GET['p'])){
    $page = (string)$_GET['p'];
    if(file_exists('./pages/' . $page . '.php')){
        require_once './partials/header.php';
        include './pages/' . $page . '.php';
        require_once './partials/footer.php';
    }else{
         header('Location: ./index.php?p=Dashboard', true);
         exit;
    }
}else{
    header('Location: ./index.php?p=Dashboard', true);
    exit;
}
