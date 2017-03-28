<?php

    if(!empty($_POST)){
        if(!empty($_POST['address']) && 
            !empty($_POST['zipcode']) && 
            !empty($_POST['city']) && 
            !empty($_POST['phone']) &&
            !empty($_POST['email'])){

            $errCount = 0;
            if(!preg_match('/[a-zæøåA-ZÆØÅ0-9\s]+$/', $_POST['address'])){
                ++$errCount;
                $errAddr = 'Feltet må kun indholde bogstaver og tal.';
            }

            if(!preg_match('/[0-9]{4}+$/', $_POST['zipcode'])){
                ++$errCount;
                $errZipcode = 'Feltet må kun indholde tal.';
            }

            if(!preg_match('/[a-zA-ZæøåÆØÅ\s]+$/', $_POST['city'])){
                ++$errCount;
                $errCity = 'Feltet må kun indholde bogstaver.';
            }

            if(!preg_match('/[+0-9\s]{8,15}+$/', $_POST['phone'])){
                ++$errCount;
                $errPhone = 'Feltet må kun indholde tal og evt. landekode (+45).';
            }

            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                ++$errCount;
                $errEmail = 'E-mail er ikke i korrekt format.';
            }

            if($errCount === 0){
                $queryUpdate = $conn->newQuery("UPDATE shopsettings 
                                                SET shopTitle = :TITLE,
                                                    shopBase = :BASE,
                                                    shopAddress = :ADDR,
                                                    shopZipcode = :ZIP,
                                                    shopCity = :CITY,
                                                    shopTelephone = :TEL,
                                                    shopEmail = :EMAIL,
                                                    shopSettingFacebook = :FB,
                                                    shopSettingTwitter = :TWIT
                                                WHERE settingsId = 1");
                $queryUpdate->bindParam(':TITLE', $_POST['title'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':BASE', $_POST['base'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':ADDR', $_POST['address'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':ZIP', $_POST['zipcode'], PDO::PARAM_INT);
                $queryUpdate->bindParam(':CITY', $_POST['city'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':TEL', $_POST['phone'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':EMAIL', $_POST['email'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':FB', $_POST['facebook'], PDO::PARAM_STR);
                $queryUpdate->bindParam(':TWIT', $_POST['twitter'], PDO::PARAM_STR);

                if($queryUpdate->execute()){
                    $productUpdate = $_POST;
                    $success = true;
                    $successErr = false;
                    $successTitle = 'Oplysniger opdateret!';
                    $successMsg = 'Oplysningerne er nu opdateret i databasen.';
                }                        

            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning';
                $successMsg = 'Alle felter skal udfyldes, og være i korrekt format.';
            }

        }else{
            $success = true;
            $successErr = true;
            $successTitle = 'Fejl i indtastning';
            $successMsg = 'Alle felter skal udfyldes, og være i korrekt format.';
        }
    }


    $querySesstings = $conn->newQuery("SELECT shopTitle, shopBase, shopAddress, shopZipcode, shopCity, shopTelephone, shopEmail, shopSettingFacebook, shopSettingTwitter FROM shopsettings WHERE settingsId = 1");
    if($querySesstings->execute()){
        $settings = $querySesstings->fetch(PDO::FETCH_ASSOC);
        $shopAddr = $settings['shopAddress'];
        $shopZipcode = $settings['shopZipcode'];
        $shopCity = $settings['shopCity'];
        $shopPhone = $settings['shopTelephone'];
        $shopEmail = $settings['shopEmail'];
        $shopTitle = $settings['shopTitle'];
        $shopBase = $settings['shopBase'];
        $shopFacebook = $settings['shopSettingFacebook'];
        $shopTwitter = $settings['shopSettingTwitter'];
    }
?>

<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                 <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Kontrolpanel
                            <small>Indstillinger</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                             <li class="<?=@empty($getParamOpt) ? '' : 'active'?>">
                                <i class="fa fa-newspaper-o"></i>  <a href="./index.php?p=Settings">Indstillingerr</a>
                            </li>
                            
                        </ol>
                    </div>
                </div>


                <!-- /.row -->
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
                <!-- /.row -->

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
                            <?=print_r($_GET)?><br> Defined base : <?=BASE?><br>
                            <?=print_r($_POST, true)?>
                            <?=print_r(@$settings, true)?>
                          </pre>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="panel panel-default col-lg-8">
                        <div class="panel-heading">
                            Generelle Indstillinger
                        </div>
                        <div class="panel-body">
                            <form method="post" action="" id="settingsInfoForm">
                                <div class="input-group has-feedback">
                                    <span class="input-group-addon" id="sizing-addon1">Titel</span>
                                    <input type="text" class="form-control" placeholder="titel" name="title" id="title" value="<?=@$shopTitle?>" aria-describedby="sizing-addon1" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errTitle?></span>
                                </div><br>
                                <div class="input-group has-feedback">
                                    <span class="input-group-addon" id="sizing-addon2">Shop URL</span>
                                    <input type="text" class="form-control" placeholder="URL" name="base" id="base" value="<?=@$shopBase?>" aria-describedby="sizing-addon2" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errBase?></span>
                                </div><br>
                                <div class="input-group has-feedback">
                                    <span class="input-group-addon" id="sizing-addon3">Facebook URL</span>
                                    <input type="text" class="form-control" placeholder="Facebook URL" name="facebook" id="facebook" value="<?=@$shopFacebook?>" aria-describedby="sizing-addon3" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errFacebook?></span>
                                </div><br>
                                <div class="input-group has-feedback">
                                    <span class="input-group-addon" id="sizing-addon4">Twitter URL</span>
                                    <input type="text" class="form-control" placeholder="Twitter URL" name="twitter" id="twitter" value="<?=@$shopTwitter?>" aria-describedby="sizing-addon4" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errTwitter?></span>
                                </div>
                            
                        </div>
                    </div>
                    
                    <div class="panel panel-info col-lg-8">
                        <div class="panel-heading">
                             Kontakt oplysninger
                        </div>
                        <div class="panel-body">
                                <div class="input-group col-lg-6 has-feedback">
                                    <span class="input-group-addon" id="sizing-addon1">Adresse</span>
                                    <input type="text" class="form-control" placeholder="Adresse" name="address" id="address" value="<?=@$shopAddr?>" aria-describedby="sizing-addon1" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errAddr?></span>
                                </div><br>
                                <div class="input-group col-lg-3 has-feedback">
                                    <span class="input-group-addon" id="sizing-addon2">Post nr.</span>
                                    <input type="text" pattern="[0-9]{4}" class="form-control" placeholder="post nr." name="zipcode" id="zipcode" value="<?=@$shopZipcode?>" aria-describedby="sizing-addon2" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errZipcode?></span>
                                </div><br>
                                <div class="input-group col-lg-4 has-feedback">
                                    <span class="input-group-addon" id="sizing-addon3">By</span>
                                    <input type="text" class="form-control" placeholder="By" name="city" id="city" value="<?=@$shopCity?>" aria-describedby="sizing-addon3" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errCity?></span>
                                </div><br>
                                <div class="input-group col-lg-4 has-feedback">
                                    <span class="input-group-addon" id="sizing-addon4">Tlf. nr.</span>
                                    <input type="text" pattern="[+0-9\s]{8,15}" class="form-control" placeholder="Tlf. nr." name="phone" id="phone" value="<?=@$shopPhone?>" aria-describedby="sizing-addon4" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errPhone?></span>
                                </div><br>
                                <div class="input-group col-lg-4 has-feedback">
                                    <span class="input-group-addon" id="sizing-addon6">E-mail</span>
                                    <input type="email" class="form-control" placeholder="E-mail" name="email" id="email" value="<?=@$shopEmail?>" aria-describedby="sizing-addon6" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="errMsg alert-warning"><?=@$errEmail?></span>
                                </div><br>
                            
                                <button type="submit" name="btnAdd" class="btn btn-lg btn-success pull-right">Ret oplysninger</button>
                        </form>
                        </div>
                    </div>
                    
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->