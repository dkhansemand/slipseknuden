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


        <div class="row hidden">
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
                    
                    <?php print_r($_SESSION)?>
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
                                <i class="fa fa-tasks fa-2x"></i>
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
                               <form action="./index.php?p=Users&option=Add" method="post" id="userForm">
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
                                        <input type="text" class="form-control" placeholder="E-mail" name="email" id="email" value="<?=@$email?>" aria-describedby="sizing-addon4" required>
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
                                
                                <select id="UserPic" name="userPicture">
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
                            </div>
                                    
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
