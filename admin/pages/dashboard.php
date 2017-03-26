<?php
  $getNewMessages = $conn->newQuery("SELECT COUNT(cmIsOpened) AS new FROM hifi_contactmessages");
  $getNewMessages->execute();
  $newMessages = $getNewMessages->fetch();
?>

<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Kontrolpanel
                            <small> - HiFi</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                        </ol>
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
                            <?=print_r($_GET) . PHP_EOL?>
                            Defined base : <?=BASE?><br>
                            <?php #print_r($newMessages)?>
                          </pre>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
                 <div class="row">
                  <div class="col-lg-8">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <i class="fa fa-tasks fa-2x"></i>
                                     - Tilføj
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                           <a href="./index.php?p=Pictures" class="btn btn-success">Billede</a>
                           <a href="./index.php?p=Brands" class="btn btn-success">Brand</a>
                           <a href="./index.php?p=Categories" class="btn btn-success">Kategori</a>
                          <a href="./index.php?p=Products&option=Add" class="btn btn-success">Produkt</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-envelope fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$newMessages['new']?></div>
                                        <div><?=$newMessages['new'] > 1 ? 'Nye beskeder': 'Ny besked'?>!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./index.php?p=Messages">
                                <div class="panel-footer">
                                    <span class="pull-left">Se nye beskeder</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->