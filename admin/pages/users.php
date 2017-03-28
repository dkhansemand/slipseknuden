<?php
    require_once '../assets/lib/class.mysql.php';
    $conn = new dbconnector();
    $queryUserTitle =  $conn->newQuery("SELECT roleId, userRoleName FROM userRoles");
    $queryPic = $conn->newQuery("SELECT pictureid, picturefilename, pictureTypeFolderPath FROM pictures
            INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId AND pictureType.pictureTypeId = 2;");    

    if($queryUserTitle->execute()){
        $infoArr['userTitle'] =  $queryUserTitle->fetchAll(PDO::FETCH_ASSOC);
    }
     if($queryPic->execute()){
        $infoArr['Pic'] = $queryPic->fetchAll(PDO::FETCH_ASSOC);  
    }
    if(isset($_GET['option'])){
        $getParamOpt = $_GET['option'];

        if(!empty($_POST) && $getParamOpt === 'Add'){
            if(!empty($_POST['username']) && 
                !empty($_POST['firstname']) && 
                !empty($_POST['lastname']) &&
                !empty($_POST['email']) &&
                !empty($_POST['password'])){
                
                $errCount = 0;
                $username = $_POST['username'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $title = $_POST['userTitle'];
                $userPicture = $_POST['userPicture'];
                $passwordOne = $_POST['password'];
                $passwordTwo = $_POST['password2'];

                if(!preg_match('/\w+$/', $username)){
                    ++$errCount;
                    $errUsername = 'Feltet må kun indholde bogstaver.';
                }
                if(!preg_match('/^[a-zA-ZÆØÅæøå\s-]+$/', $firstname)){
                    ++$errCount;
                    $errFirstname = 'Feltet må kun indholde bogstaver og - .';
                }
                if(!preg_match('/^[a-zA-ZÆØÅæøå\s-]+$/', $lastname)){
                    ++$errCount;
                    $errLastname = 'Feltet må kun indholde bogstaver og - .';
                }
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    ++$errCount;
                    $errEmail = 'Emailen er ikke skrevet korrekt.';
                }
                if($passwordOne !== $passwordTwo){
                    ++$errCount;
                    $errPassword2 = 'Passwords stemmer ikke overens';
                }

                if($errCount === 0){
                    $options  = array('cost' => 10);
                    $hash     = password_hash($passwordOne, PASSWORD_BCRYPT, $options);

                    $query = $conn->newQuery("INSERT INTO users (userName, userPassword, userEmail, userFirstname, userLastname, userPictureId, userRole) 
                                                VALUES (:username, '$hash', :email, :firstname, :lastname, :PICID, :ROLE)");
                    $query->bindParam(':username', $username, PDO::PARAM_STR);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                    $query->bindParam(':PICID', $userPicture, PDO::PARAM_INT);
                    $query->bindParam(':ROLE', $title, PDO::PARAM_INT);

                    if($query->execute()){
                        $success = true;
                        $successErr = false;
                        $successTitle = 'Medarbejder tilføjet!';
                        $successMsg = 'Medarbejder er nu tilføjet!';
                        unset($errCount, $username, $firstname, $lastname, $email, $passwordOne, $passwordTwo);   
                    }                
                }else{
                    $success = true;
                    $successErr = true;
                    $successTitle = 'Fejl i indtastning!';
                    $successMsg = 'Alle felter skal udfyldes og være i korrekt format.';
                }
            }
        }
    }

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

    unset($conn);
?>
<script src="./js/userHandler.js"></script>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Kontrolpanel
                    <small> - Slipseknuden</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                    </li>
                        <li class="active">
                        <i class="fa fa-user"></i>  <a href="./index.php?p=Users">Medarbejdere</a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="row <?=@$success ? '' : 'hidden'?>">
            <div class="col-lg-12">
                <div class="panel panel-info">
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


        <div class="row">
            <div class="col-lg-10">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <i class="fa fa-bug fa-2x"></i>
                                - DEBUG
                        </div>
                        
                    </div>
                </div>
                <div class="panel-body">
                    <pre>
                    <?=print_r($_GET)?>
                    
                    <?php print_r($_POST)?>
                    </pre>
                </div>
            </div>
            </div>
        </div>


        <!-- /.row -->
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-8">
                                <i class="fa fa-user fa-2x"></i>
                                    - Tilføj medarbejder
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                    Ny medarbejder
                    </button>
                        <div class="collapse" id="collapseUser">
                            <div class="well">
                            <h2>Indtast information</h2>
                               <form action="./index.php?p=Users&option=Add" method="post" id="userAddForm">
                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="sizing-addon1">Brugernavn</span>
                                        <input type="text" class="form-control" placeholder="brugernavn" name="username" id="username" value="<?=@$username?>" aria-describedby="sizing-addon1" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="errMsg alert-warning"><?=@$errUsername?></span>
                                    </div><br>
                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="sizing-addon2">Fornavn</span>
                                        <input type="text" class="form-control" placeholder="Fornavn" name="firstname" id="firstname" value="<?=@$firstname?>" aria-describedby="sizing-addon2" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="errMsg alert-warning"><?=@$errFirstname?></span>
                                    </div><br>
                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="sizing-addon3">Efternavn</span>
                                        <input type="text" class="form-control" placeholder="Efternavn" name="lastname" id="lastname" value="<?=@$lastname?>" aria-describedby="sizing-addon3" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="errMsg alert-warning"><?=@$errLastname?></span>
                                    </div><br>
                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="sizing-addon4">E-mail</span>
                                        <input type="email" class="form-control" placeholder="E-mail" name="email" id="email" value="<?=@$email?>" aria-describedby="sizing-addon4" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="errMsg alert-warning"><?=@$errEmail?></span>
                                    </div><br>
                                    <div class="input-group">
                                        <label for="">Titel</label>
                                        <select name="userTitle">
                                            <?php
                                                foreach($infoArr['userTitle'] as $userTitle){
                                            ?>
                                                <option value="<?=$userTitle['roleId']?>"><?=$userTitle['userRoleName']?></option>

                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div><br>

                                    <div class="input-group">
                                <label for="basic-url">Medarbejder billede</label>
                                
                                <select id="userPic" name="userPicture">
                                        <?php
                                        foreach($infoArr['Pic'] as $Picture){
                                    ?>
                                        <option value="<?=$Picture['pictureid']?>"><?=$Picture['picturefilename']?></option>

                                        <?php
                                        }
                                        ?>
                                </select>
                                
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddPicture"><i class="fa fa-plus"></i> Tilføj billede </button>
                                <br>

                                
                                <script>
                                    $(document).ready(()=>{
                                        var picture = $('#userPic option:selected').text();
                                            $("#showPic").attr("src","../assets/media/employees/" + picture);
                                        $('#userPic').on('change', function() {
                                            var picture = $('#userPic option:selected').text();
                                            $("#showPic").attr("src","../assets/media/employees/" + picture);
                                        });
                                    });
                                    </script>
                                <img id="showPic" src="">
                                <span id="showPic"></span>
                            </div><br>

                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="sizing-addon5">Password</span>
                                        <input type="password" class="form-control" name="password" id="password" aria-describedby="sizing-addon5" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="errMsg alert-warning"><?=@$errPassword?></span>
                                    </div><br>

                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="sizing-addon6">Gentag Password</span>
                                        <input type="password" class="form-control" name="password2" id="password2" aria-describedby="sizing-addon6" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="errMsg alert-warning"><?=@$errPassword2?></span>
                                    </div><br>
                                    
                                    <button type="submit" class="btn btn-lg btn-success">Tilføj</button>
                               </form>

                            <div class="modal fade" id="modalAddPicture" tabindex="-1" role="dialog" aria-labelledby="ModalAddPicture">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Tilføj nyt billede</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" id="pictureUserForm" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="pictureTitle">Billede titel</label>
                                                    <input type="text" class="form-control" id="pictureTitle" name="pictureTitle" placeholder="Titel" required>
                                                </div>
                                                <div class="form-group">
                                                <label for="pictureAssign">Billede placering</label>
                                                    <select name="pictureAssign" id="pictureAssign">
                                                        <option value="2">Medarbejder billede</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Billede</label>
                                                    <input type="file" name="picturefile" id="exampleInputFile" required>
                                                    <p class="help-block">Billede må max være på 1.5MB og i formater (.jpg, .jpeg, .png, .gif).</p>
                                                </div>
                                                
                                                <button type="submit" id="btnUpload" class="btn btn-success">Upload</button><br>
                                                <div class="progress">
                                                    <progress class="hidden"></progress><br>
                                                </div>
                                                <div class="alert alert-danger hidden" id="errMsg"></div>
                                                <div class="alert alert-success hidden" id="successMsg"></div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Luk</button>
                                            
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
