 <?php

    ## Check if GET have data to control options/functions
    if(!empty($_GET)){
        if(!empty($_GET['option'])){
            $getParamOpt = $_GET['option'];
            if($getParamOpt === 'Add' || $getParamOpt === 'Edit'){
                
                ## Retrive data for pictures
                $queryPic = $conn->newQuery("SELECT pictureid, picturefilename, pictureTitle FROM hifi_pictures WHERE pictureIsProduct = 0;");    
                
                if($queryPic->execute()){
                    $infoArr['Pic'] = $queryPic->fetchAll(PDO::FETCH_ASSOC);
                }
            }

             if($getParamOpt === 'Edit' && !empty($_GET['id'])){
                $nid = (int)$_GET['id'];
                $queryNews = $conn->newQuery("SELECT nid, newsTitle, newsContent, newsPictureId FROM hifi_news WHERE nid = :ID");
                $queryNews->bindParam(':ID', $nid, PDO::PARAM_INT);
                if($queryNews->execute()){
                    $newsEdit = $queryNews->fetch(PDO::FETCH_ASSOC);

                }
             }

        }
    }
    if($getParamOpt === 'Delete' && !empty($_GET['id'])){
            $nid = (int)$_GET['id'];
            
            
            $queryDelete = $conn->newQuery("DELETE FROM hifi_news WHERE nid = :ID;");
            $queryDelete->bindParam(':ID', $nid, PDO::PARAM_INT);

            if($queryDelete->execute()){
               
            ?>
            <script type="text/javascript">
                $(window).load(function(){
                    $('#newsDelete').modal('show');
                });
            </script>
            <div class="modal fade" id="newsDelete" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nyhed slettet</h4>
                    </div>
                    <div class="modal-body">
                        <p>Nyheden er nu blevet slettet i databasen!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="./index.php?p=News" class="btn btn-success">OK</a>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php
            
            }
        }

    ## Check if post have data
    if(!empty($_POST)){
         if($getParamOpt === 'Add'){
            if(!empty($_POST['newstitle']) && !empty($_POST['newscontent'])){
                $errCount = 0;
                $newstitle = $_POST['newstitle'];
                $newscontent = $_POST['newscontent'];

                if(!preg_match('/^[a-zA-ZÆØÅæøå0-9\s.]+$/', $newstitle)){
                    ++$errCount;
                    $errNewstitle = 'Feltet må kun indholde bogstaver og tal.';
                }

                if(!preg_match('/^[a-zA-ZÆØÅæøå0-9\s._-]+$/', $newscontent)){
                    ++$errCount;
                    $errNewscontent = 'Feltet må kun indholde bogstaver og tal.';
                }

                if($errCount === 0){
                    $queryInsert = $conn->newQuery("INSERT INTO hifi_news (newsTitle, newsContent, newsPictureId)VALUES(:TITLE, :CONTENT, :PICTUREID)");
                    $queryInsert->bindParam(':TITLE', $newstitle, PDO::PARAM_STR);   
                    $queryInsert->bindParam(':CONTENT', $newscontent, PDO::PARAM_STR);      
                    $queryInsert->bindParam(':PICTUREID', $_POST['newsPicture'], PDO::PARAM_INT);       
                    
                    if($queryInsert->execute()){
                        $success = true;
                        $successErr = false;
                        $successTitle = 'Nyhed tilføjet';
                        $successMsg = 'Nyheden "' . $newstitle . '" er nu tilføjet til databasen';
                        unset($newstitle, $newscontent);
                    } 
                }else{
                    $success = true;
                    $successErr = true;
                    $successTitle = 'Fejl i indtastning!';
                    $successMsg = 'Overskrift og indhold, skal udfyldes og være i korrekt format.'; 
                }      

            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Overskrift og indhold, skal udfyldes og være i korrekt format.'; 
            }
         }

        if($getParamOpt === 'Edit'){
            if(!empty($_POST['newstitle']) && !empty($_POST['newscontent'])){
                $nid = (int)$_GET['id'];
                $errCount = 0;
                $newstitle = $_POST['newstitle'];
                $newscontent = $_POST['newscontent'];

                if(!preg_match('/^[a-zA-ZÆØÅæøå0-9\s.]+$/', $newstitle)){
                    ++$errCount;
                    $errNewstitle = 'Feltet må kun indholde bogstaver og tal.';
                }

                if(!preg_match('/\w+$/', $newscontent)){
                    ++$errCount;
                    $errNewscontent = 'Feltet må kun indholde bogstaver og tal.';
                }

                if($errCount === 0){
                    $queryUpdate = $conn->newQuery("UPDATE hifi_news SET newsTItle = :TITLE, newsContent = :CONTENT, newsPictureId = :PICTUREID WHERE nid = :NID");
                    $queryUpdate->bindParam(':TITLE', $newstitle, PDO::PARAM_STR);   
                    $queryUpdate->bindParam(':CONTENT', $newscontent, PDO::PARAM_STR);      
                    $queryUpdate->bindParam(':PICTUREID', $_POST['newsPicture'], PDO::PARAM_INT);       
                    $queryUpdate->bindParam(':NID', $nid, PDO::PARAM_INT);
                    if($queryUpdate->execute()){
                        $success = true;
                        $successErr = false;
                        $successTitle = 'Nyhed redigéret';
                        $successMsg = 'Nyhed "' . $newstitle . '" er nu redigéret i databasen';
                        
                    } 
                }else{
                    $success = true;
                    $successErr = true;
                    $successTitle = 'Fejl i indtastning!';
                    $successMsg = 'Overskrift og indhold, skal udfyldes og være i korrekt format.'; 
                }      

            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Overskrift og indhold, skal udfyldes og være i korrekt format.'; 
            }
        }
    }


 ?>

 <script>
     $(document).ready( () => {
          var nid;
     $('#modalDeleteNews').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var newsHeading = button.data('newsheading'); 
        nid = button.data('nid');
        var modal = $(this);
        $('#newsDelLbl').html(newsHeading);
    });
     
        $('#btnDeleteNews').on('click', ()=>{
            window.location = './index.php?p=News&option=Delete&id=' + nid;
        });
     });
 </script>
 
 <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Kontrolpanel
                            <small>Nyheder</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                             <li class="<?=@empty($getParamOpt) ? '' : 'active'?>">
                                <i class="fa fa-newspaper-o"></i>  <a href="./index.php?p=News">Nyheder</a>
                            </li>
                            <?php
                            if(@$getParamOpt === 'Add'){
                            ?>
                                <li class="active">
                                    <a href="./index.php?p=News&option=Add">Tilføj nyhed</a>
                                </li>
                            <?php
                            }
                            if(@$getParamOpt === 'Edit'){
                            ?>
                            <li class="active">
                                <a href="./index.php?p=News&option=Edit&id=<?=$nid?>">Redigér nyhed</a>
                            </li>
                            <?php
                            }
                            ?>
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
                            <?=print_r(@$newsEdit, true)?>
                          </pre>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-newspaper-o fa-2x"></i>
                                - Tilføj nyhed
                            </div>
                            <div class="panel-body">
                                <a href="./index.php?p=News&option=Add" class="btn btn-lg btn-success"><i class="fa fa-plus"></i>Tilføj nyhed</a>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="row <?=@empty($getParamOpt) ? '' : 'hidden'?>">
                <h3>Nyheder</h3>
                <?php
                    ## Query to select 4 of the latest news
                    $queryNews = $conn->newQuery("SELECT nid, newsTitle, newsContent, DATE_FORMAT(newsAdded, '%d/%m %Y %h:%i') AS newsDate, pictureFilename, pictureTitle
                                                        FROM hifi_news 
                                                        LEFT JOIN hifi_pictures ON pictureFilename = newsPictureId
                                                        ORDER BY newsDate DESC;");
                    if($queryNews->execute()){
                        while($news = $queryNews->fetch(PDO::FETCH_ASSOC)){

                            ## CHeck if there is a picture related, if not insert a placeholder
                            if(!empty($news['pictureFlename'])){
                                $image = $news['pictureFilename'];
                            }else{
                                $image = 'http://placehold.it/500x300';
                            }
                    ?>
                    <div class="col-xs-18 col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <img src="<?=$image?>" alt="<?=$news['pictureTitle']?>">
                            <div class="caption">
                                <h4><?=$news['newsTitle']?></h4>
                                <p class="text-muted"><?=$news['newsDate']?></p>
                            
                            <p><?=$news['newsContent'];?></p>
                            <p>
                            <a href="./index.php?p=News&option=Edit&id=<?=$news['nid']?>" class="btn btn-info" role="button"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteNews" data-newsHeading="<?=$news['newsTitle']?>" data-nid="<?=$news['nid']?>"><i class="fa fa-remove"></i></button>
                            </p>
                        </div>
                    </div>
                 </div>
                <?php

                    }
                }
                ?>
                </div>

                <!-- Modal -->
                    <div class="modal fade" id="modalDeleteNews" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModalLabel">Slet nyhed?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Er du sikker på at, du vil slette nyheden "<span id="newsDelLbl"></span>"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Anullér</button>
                            <button type="button" id="btnDeleteNews" class="btn btn-danger">Slet</button>
                        </div>
                        </div>
                    </div>
                    </div>


                     <?php
                    if(@$getParamOpt === 'Add' || @$getParamOpt === 'Edit'){
                ?>
                <script src="./js/validateNews.js"></script>
                <div class="row">
                  <div class="col-lg-10">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <i class="fa fa-plus fa-2x"></i>
                                    <?php
                                        if($getParamOpt === 'Add'){
                                            echo 'Tilføj nyhed';
                                            $action = './index.php?p=News&option=Add';
                                            $btn = 'Tilføj';
                                        }elseif($getParamOpt === 'Edit'){
                                            echo 'Redigér nyhed';
                                            $action = './index.php?p=News&option=Edit&id='.$nid;
                                            $btn = 'Redigér';
                                        }
                                    ?>
                                      
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                          <form method="post" action="<?=$action?>" id="newsAddForm">
    
                            <div class="input-group col-lg-6 has-feedback">
                                <span class="input-group-addon" id="sizing-addon2">Overskrift</span>
                                <input type="text" class="form-control" placeholder="Overskrift" name="newstitle" id="newsTitle" value="<?=@$newstitle?>" aria-describedby="sizing-addon2" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errNewstitle?></span>
                            </div><br>
                            <div class="input-group has-feedback">
                                <label for="">Indhold</label>
                                <textarea name="newscontent" id="newscontent" class="form-control" col="15" rows="10" required><?=@$newscontent?></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errNewscontent?></span>
                            </div><br> 
                            <div class="input-group">
                                <label for="basic-url">Nyheds billede</label>
                                <select id="newsPic" name="newsPicture">
                                        <?php
                                        foreach($infoArr['Pic'] as $Picture){
                                    ?>
                                        <option value="<?=$Picture['pictureid']?>" <?=@$newsEdit['newsPictureId'] === $Picture['pictureid'] ? 'selected' : ''?>><?=utf8_encode($Picture['picturefilename'])?></option>

                                        <?php
                                        }
                                        ?>
                                </select>
                               
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddPicture"><i class="fa fa-plus"></i> Tilføj billede </button>
                                <br>
                                <script>
                                    $(document).ready(()=>{
                                        var picture = $('#newsPic option:selected').text();
                                        $("#showPic").attr("src","<?=IMGBASE?>/img/" + picture);
                                        $('#newsPic').on('change', function() {
                                            var picture = $('#newsPic option:selected').text();
                                            $("#showPic").attr("src","<?=IMGBASE?>/img/" + picture);
                                        });
                                    });
                                    </script>
                                <img id="showPic" height="250" width="300" src="">
                                <span id="showPic"></span>
                            </div>

                            <button type="submit" name="btnAdd" class="btn btn-lg btn-success"><?=$btn?> </button>
                        </form>
                         <div class="modal fade" id="modalAddPicture" tabindex="-1" role="dialog" aria-labelledby="ModalAddPicture">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Tilføj nyt billede</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" id="pictureProductForm" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="pictureTitle">Billede titel</label>
                                                    <input type="text" class="form-control" id="pictureTitle" name="pictureTitle" placeholder="Titel" required>
                                                </div>
                                                <div class="form-group">
                                                <label for="pictureAssign">Billede placering</label>
                                                    <select name="pictureAssign" id="pictureAssign">
                                                        <option value="0">Andre billeder</option>
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

                    <?php } ?>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->