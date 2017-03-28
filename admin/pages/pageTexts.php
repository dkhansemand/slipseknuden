<?php
    $queryTexts = $conn->newQuery("SELECT pageDetailId, pageName, pageDetailsTitle, pageDetailsText FROM pages 
                                INNER JOIN pageDetails ON pageTxtId = pageDetailId
                                ORDER BY pagePosition    ASC");
    if($queryTexts->execute()){
        $pageDetails = $queryTexts->fetchAll(PDO::FETCH_ASSOC);
    }

    if(!empty($_POST) && $_GET['option'] === 'Edit' && !empty($_GET['id'])){
        if(!empty($_POST['title']) && !empty($_POST['pageText'])){
            $pageId = (int)$_GET['id'];
            $pageTitle = $_POST['title'];
            $pageText = $_POST['pageText'];

            $queryUpdate = $conn->newQuery("UPDATE pageDetails SET pageDetailsTitle = :TITLE, pageDetailsText = :TXT WHERE pageDetailId = :ID");
            $queryUpdate->bindParam(':ID', $pageId, PDO::PARAM_INT);
            $queryUpdate->bindParam(':TITLE', $pageTitle, PDO::PARAM_STR);
            $queryUpdate->bindParam(':TXT', $pageText, PDO::PARAM_STR);

            if($queryUpdate->execute()){
                $success = true;
                $successErr = false;
                $successTitle = 'Side tekst rettet';
                $successMsg = 'Side teksten er nu blevet rettet.';
                unset($pageTitle, $pageText);
            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i SQL';
                $successMsg = 'Prøv igen.';
            }
        }else{
            $success = true;
            $successErr = true;
            $successTitle = 'Fejl i indtastning';
            $successMsg = 'Alle felter skal udfyldes, og være i korrekt format.';
        }
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
                            <i class="fa fa-home"></i>  <a href="./index.php?p=PageTexts">Side tekster</a>
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
                                    <form action="index.php?p=PageTexts&option=Edit&id=<?=$pageDetail['pageDetailId']?>" method="post">
                                        <div class="input-group has-feedback">
                                            <span class="input-group-addon" id="sizing-addon1">Titel</span>
                                            <input type="text" class="form-control" placeholder="titel" name="title" id="title" value="<?=$pageDetail['pageDetailsTitle']?>" aria-describedby="sizing-addon1" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="errMsg alert-warning"><?=@$errTitle?></span>
                                        </div><br>
                                        <div class="input-group has-feedback">
                                        <label>Side tekst</label><br>
                                        <textarea name="pageText" cols="100" rows="15"><?=$pageDetail['pageDetailsText']?>
                                        </textarea>
                                        </div><br>
                                        <button type="submit" name="btnEdit" class="btn btn-success btn-md pull-right">Opdatér</button>
                                    </form>
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