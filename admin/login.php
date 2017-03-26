<?php
    session_start();

    ##Check if $_POST is set and data is not empty, and then require class to connect
    if(!empty($_POST)){
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            ## Import dbconnetor class
            require_once '../lib/class.mysql.php';
            
            ## Create global connection variable
            $conn = new dbconnector();

            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = $conn->newQuery("SELECT userId, username, userPwd, userRole FROM hifi_users WHERE username = :username");
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() === 1){
                $result = $query->fetch(PDO::FETCH_ASSOC);

                if(password_verify($password, $result['userPwd'])){
                    $_SESSION['userId'] = $result['userId'];
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['userRole'] = $result['userRole'];
                    $_SESSION['isLoggedIn'] = true;
                    unset($conn);
                    header('Location: ./index.php?p=Dashboard');
                    exit;
                }else{
                    unset($conn);
                    $success = true;
                    $successErr = true;
                    $successTitle = 'Fejl i indtastning!';
                    $successMsg = 'Brugernavn eller password forkert!';
                }
            }else{
                unset($conn);
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Brugernavn eller password forkert!';
            }


        }else{
            $success = true;
            $successErr = true;
            $successTitle = 'Fejl i indtastning!';
            $successMsg = 'Brugernavn og password skal udfyldes!';
        }
    }
?>
<!DOCTYPE html>
<html lang="da">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HiFi - Kontrolpanel</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                <a class="navbar-brand" href="./">HiFi Kontrolpanel</a>
            </div>
            <!-- Top Menu Items -->
           
                
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Kontrolpanel
                            <small>Login</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-key"></i> Login
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Login</h2>
                        <div class="row <?=@$success ? '' : 'hidden'?>">
                            <div class="col-lg-12">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <?=@$successTitle?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="alert <?=@$successErr ? 'alert-danger':'alert-success'?>" role="alert">
                                            <?=@$successMsg?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <form action="" method="post" id="loginForm" class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brugernavn</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Brugernavn">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>
                            
                            <button type="submit" class="btn btn-success pull-right">Login</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
