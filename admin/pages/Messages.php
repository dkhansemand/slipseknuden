<?php

    $QueryMessages = $conn->newQuery("SELECT cmId, cmSubject, cmFullname, cmEmail, cmMessage, cmIsOpened, DATE_FORMAT(cmSubmitDate, '%d/%m %Y %h:%i') AS submitted FROM hifi_contactmessages");
    if($QueryMessages->execute()){
        $messages  = $QueryMessages->fetchAll(PDO::FETCH_ASSOC);

    }

?>


<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                 <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Kontrolpanel
                            <small>Beskeder</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                             <li class="<?=@empty($getParamOpt) ? '' : 'active'?>">
                                <i class="fa fa-newspaper-o"></i>  <a href="./index.php?p=Messages">Beskeder</a>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

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
                            <?=print_r(@$messages, true)?>
                          </pre>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div>
                                <div class="row">
                                    <h2 class="col-lg-6 page-header">Beskeder</h2>
                                </div>
                    <script>
                    $(document).ready( () => {
                        $('.nav-tabs a').click(function (e) {
                            e.preventDefault()
                            $(this).tab('show')
                        });
                    });    
                    </script>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">Nye beskeder</a></li>
                        <li role="presentation"><a href="#read" aria-controls="read" role="tab" data-toggle="tab">Læste beskeder</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="new">
                            <div class="row">
                                <div class="col-lg-8 panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                   <?php
                                        foreach($messages as $message){
                                            if($message['cmIsOpened'] == 0){
                                   ?>
                                    <div class="panel panel-info">
                                        <div class="panel-heading" role="tab" id="<?=$message['cmId']?>">
                                        <h4 class="panel-title">
                                            <p><?=$message['cmSubject']?> - <em>Modtaget: <?=$message['submitted']?></em></p>
                                            <p class="">Afsender: <?=$message['cmFullname']?> - "<?=$message['cmEmail']?>"</p>
                                            <a class="btn btn-md btn-default" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$message['cmId']?>" aria-expanded="true" aria-controls="collapseOne">
                                            Læs besked
                                            </a>
                                        </h4>
                                        </div>
                                        <div id="collapse<?=$message['cmId']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?=$message['cmId']?>">
                                        <div class="panel-body">
                                            <?=$message['cmMessage']?>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="./index.php?p=Messages&option=Answer&id=<?=$message['cmId']?>" class="btn btn-success">Svar</a>
                                            <a href="./index.php?p=Messages&option=Delete&id=<?=$message['cmId']?>" class="btn btn-danger">Slet</a>
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                         }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="read">
                            <div class="row">
                                <div class="col-lg-8 panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <?php
                                        foreach($messages as $message){
                                               
                                            if($message['cmIsOpened'] == 1){
                                                       
                                   ?>
                                    <div class="panel panel-info">
                                        <div class="panel-heading" role="tab" id="<?=$message['cmId']?>">
                                        <h4 class="panel-title">
                                            <p><?=$message['cmSubject']?> - <em>Modtaget: <?=$message['submitted']?></em></p>
                                            <p class="">Afsender: <?=$message['cmFullname']?> - "<?=$message['cmEmail']?>"</p>
                                            <a class="btn btn-md btn-default" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$message['cmId']?>" aria-expanded="true" aria-controls="collapseOne">
                                            Læs besked
                                            </a>
                                        </h4>
                                        </div>
                                        <div id="collapse<?=$message['cmId']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?=$message['cmId']?>">
                                        <div class="panel-body">
                                            <?=$message['cmMessage']?>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="./index.php?p=Messages&option=Answer&id=<?=$message['cmId']?>" class="btn btn-success">Svar</a>
                                            <a href="./index.php?p=Messages&option=Delete&id=<?=$message['cmId']?>" class="btn btn-danger">Slet</a>
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                           
                                            }
                                         
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                    </div>
                </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->