<?php
ini_set('display_errors', 0);
ini_set('html_errors', false);
    require_once './class.getData.php';
    ##GET handlers to return JSON data on request from front-end
    if(!empty($_GET)){

        if(isset($_GET['home'])){
            $getHome = new getData();
            print_r($getHome->home());
            unset($getHome);
        }

        if(isset($_GET['categories'])){
            $getCategories = new getData();
            print_r($getCategories->categories());
            unset($getCategories);
        }

        if(isset($_GET['shopInfo'])){
            $getDataShopInfo = new getData();
            print_r($getDataShopInfo->shopInfo());
            unset($getDataShopInfo);
        }

    }

    ##POST handlers to insert data from Admin panel
    if(!empty($_POST)){

    }
