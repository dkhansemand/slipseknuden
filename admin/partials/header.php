<?php
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    $devfolder = '/hifi';
    $file_headers = @get_headers($root.$devfolder);
    $username = 'Administrator';

    if($file_headers[0] === "HTTP/1.1 404 Not Found"){
        define('BASE', $root.'/admin_hifi');
        define('IMGBASE', $root);
    }else{
        define('BASE', $root.$devfolder.'/admin_hifi');
        define('IMGBASE', $root.$devfolder);
    }

    ## Import dbconnetor class
    require_once '../lib/class.mysql.php';
    ## Create global connection variable
    $conn = new dbconnector();

?>
<!DOCTYPE html>
<html lang="da">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="HiFi Kontrolpanel">
    <meta name="author" content="HiFi">

    <title>HiFi - Kontrolpanel</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=BASE?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=BASE?>/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=BASE?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php?p=Dashboard">HiFi - Kontrolpanel</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li>
                    <a href="./index.php?p=Profile"><i class="fa fa-user"></i> <?=$_SESSION['username']?></a>
                </li>
                <li>
                    <a href="./logout.php"><i class="fa fa-power-off"></i> Log ud</a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                 
                    <li class="active">
                        <a href="javascript:;" data-toggle="collapse" data-target="#general"><i class="fa fa-fw fa-arrows-v"></i> Generalt <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="general" class="collapse in">
                            <li>
                                <a href="./index.php?p=Dashboard"><i class="fa fa-fw fa-dashboard"></i> Kontrolpanel</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Users"><i class="fa fa-fw fa-user"></i> Brugere</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Settings"><i class="fa fa-fw fa-wrench"></i> Shop indstillinger</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#indhold"><i class="fa fa-fw fa-arrows-v"></i> Indhold <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="indhold" class="collapse">
                            <li>
                                <a href="./index.php?p=Messages"><i class="fa fa-fw fa-envelope"></i> Beskeder</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Pictures"><i class="fa fa-fw fa-picture-o"></i> Billeder</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Brands"><i class="fa fa-fw fa-tags"></i> Brands</a>
                            </li>
                            <li>
                                <a href="./index.php?p=FrontPage"><i class="fa fa-fw fa-home"></i> Forside</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Categories"><i class="fa fa-fw fa-list-alt"></i> Kategorier</a>
                            </li>
                            <li>
                                <a href="./index.php?p=News"><i class="fa fa-fw fa-newspaper-o"></i> Nyheder</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Products"><i class="fa fa-fw fa-cubes"></i> Produkter</a>
                            </li>
                            <li>
                                <a href="./index.php?p=Slider"><i class="fa fa-fw fa-object-group"></i> Slider</a>
                            </li>
                        </ul>
                    </li>
                    
                   
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
