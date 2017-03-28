<?php
    $queryTexts = $conn->newQuery("SELECT pageDetailId, pageName, pageDetailsTitle, pageDetailsText FROM pages 
                                INNER JOIN pageDetails ON pageTxtId = pageDetailId
                                ORDER BY pagePosition    ASC");
    if($queryTexts->execute()){
        $pageDetails = $queryTexts->fetchAll(PDO::FETCH_ASSOC);
    }

?>

<div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
                <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Kontrolpanel
                        <small>Side tekster</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                        </li>
                            <li class="active">
                            <i class="fa fa-home"></i>  <a href="./index.php?p=PageText">Side tekster</a>
                        </li>
                        
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <i class="fa fa-home fa-2x"></i>
                                      Side tekster
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                foreach($pageDetails as $pageDetail){
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?=$pageDetail['pageDetailId']?>">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$pageDetail['pageDetailId']?>" aria-expanded="true" aria-controls="collapse<?=$pageDetail['pageDetailId']?>">
                                        <?=$pageDetail['pageName']?>
                                        </a>
                                    </h4>
                                    </div>
                                    <div id="collapse<?=$pageDetail['pageDetailId']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$pageDetail['pageDetailId']?>">
                                    <div class="panel-body">
                                       <?=$pageDetail['pageDetailsText']?>
                                    </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>