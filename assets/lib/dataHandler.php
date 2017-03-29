<?php
ini_set('display_errors', 0);
ini_set('html_errors', false);
    require_once './class.getData.php';
    ##GET handlers to return JSON data on request from front-end
    if(!empty($_GET)){

        if(isset($_GET['page'])){
            $getPageText = new getData();
            print_r($getPageText->pageTexts($_GET['page']));
            unset($getPageText);
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

        if(isset($_GET['randomProducts'])){
            $getDataRandom = new getData();
            print_r($getDataRandom->getRandomProducts());
            unset($getDataRandom);
        }

        if(isset($_GET['latestNews'])){
            $getDataLatestNews = new getData();
            print_r($getDataLatestNews->latestNews());
            unset($getDataLatestNews);
        }

        if(isset($_GET['employees'])){
            $getDataEmployees = new getData();
            print_r($getDataEmployees->getEmployees());
            unset($getDataEmployees);
        }

        if(isset($_GET['products'])){
            $id = (int)$_GET['categoryId'];
            $getDataProducts = new getData();
            print_r($getDataProducts->products($id));
            unset($getDataProducts);
        }

        if(isset($_GET['product'])){
            $id = (int)$_GET['id'];
            $getDataProduct = new getData();
            print_r($getDataProduct->product($id));
            unset($getDataProduct);
        }

        if(isset($_GET['search'])){
            $value = $_GET['value'];
            $getDataSearch = new getData();
            print_r($getDataSearch->search($value));
            unset($getDataSearch);
        }


    }

    ##POST handlers to insert data from Admin panel
    if(!empty($_POST)){

    }
