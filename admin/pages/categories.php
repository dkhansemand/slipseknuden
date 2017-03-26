<?php

    if(!empty($_POST)){
        if(!empty($_GET['option']) && $_GET['option'] === 'Add'){
            if(!empty($_POST['categoryName'])){
                $errCount = 0;
                $categoryName = $_POST['categoryName'];

                if(!preg_match('/\w+$/', $categoryName)){
                    ++$errCount;
                    $errBrandName = 'Feltet må kun indholde bogstaver og tal.';
                }

                if($_POST['categoryActive'] === 'on'){
                    $isActive = 1;
                }else{
                    $isActive = 0;
                }

                if($errCount === 0){
                    $queryAddCat = $conn->newQuery("INSERT INTO hifi_category (categoryName, categoryActive)VALUES(:NAME, :ACTIVE)");
                    $queryAddCat->bindParam(':NAME', $categoryName, PDO::PARAM_STR);
                    $queryAddCat->bindParam(':ACTIVE', $isActive, PDO::PARAM_INT);
                    if($queryAddCat->execute()){
                        $success = true;
                        $successErr = false;
                        $successTitle = 'Kategori tilføjet';
                        $successMsg = 'Kategori "' . $categoryName . '" er nu tilføjet til databasen';
                        unset($categoryName, $isActive);
                    }
                }else{
                    $success = true;
                    $successErr = true;
                    $successTitle = 'Fejl i indtastning!';
                    $successMsg = 'Kategori navn må ikke have specialtegn og ';
                }
            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Kategori navn skal udfyldes og må ikke have specialtegn.';
            }
        }
         if(!empty($_POST['categoryName']) && $_GET['option'] === 'Edit' && !empty($_GET['id'])){
            $errCount = 0;
            $catId = (int)$_GET['id'];
            $categoryName = $_POST['categoryName'];

            if(!preg_match('/\w+$/', $categoryName)){
                ++$errCount;
                $errCategoryName = 'Feltet må kun indholde bogstaver og tal.';
            }

            if($_POST['categoryActive'] === 'on'){
                $isActive = 1;
            }else{
                $isActive = 0;
            }

            if($errCount === 0){
                $queryUpdateCategory = $conn->newQuery("UPDATE hifi_category SET categoryName = :NAME, categoryActive = :ACTIVE WHERE catId = :ID");
                $queryUpdateCategory->bindParam(':NAME', $categoryName, PDO::PARAM_STR);
                $queryUpdateCategory->bindParam(':ACTIVE', $isActive, PDO::PARAM_INT);
                $queryUpdateCategory->bindParam(':ID', $catId, PDO::PARAM_INT);
                if($queryUpdateCategory->execute()){
                    $success = true;
                    $successErr = false;
                    $successTitle = 'Kategori Opdateret';
                    $successMsg = 'Kategori "' . $categoryName . '" er nu opdateret i databasen';
                    unset($categoryName, $isActive);
                }
            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Kategori navn skal udfyldes og må ikke have specialtegn.';
            }
         }
    }

    if(!empty($_GET['option']) && $_GET['option'] === 'Delete' && !empty($_GET['id'])){
            
            $catId = (int)$_GET['id'];
            $queryDeleteCat = $conn->newQuery("DELETE FROM hifi_category WHERE catId = :ID");
            $queryDeleteCat->bindParam(':ID', $catId, PDO::PARAM_INT);
            if($queryDeleteCat->execute()){
                ?>
            <script type="text/javascript">
                $(window).load(function(){
                    $('#modalSuccess').modal('show');
                });
            </script>
            <div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Kategori slettet</h4>
                    </div>
                    <div class="modal-body">
                        <p>Kategori er nu blevet slettet i databasen!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="./index.php?p=Categories" class="btn btn-success">OK</a>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php
            }
         }
    

    $queryGetCat = $conn->newQuery("SELECT catId, categoryName, categoryActive FROM hifi_category ORDER BY categoryName ASC");
    $queryGetCat->execute();
    $categories = $queryGetCat->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
var validateBrand = {
        brandname: (inputField) => {
            "use strict";

            var nameVal = $(inputField).val(),
                nameRegex = /\w+$/;
            
            if(nameVal.length !== 0 && nameRegex.test(nameVal)){
                $(inputField).parent('div')
                                .removeClass("has-error")
                                .addClass("has-success");
                $(inputField).next()
                                .removeClass("glyphicon-remove")
                                .addClass("glyphicon-ok")
                                .next('.errMsg').html('');
                
            }else{
                $(inputField).parent('div')
                                .removeClass("has-success")
                                .addClass("has-error");
                
                $(inputField).next()
                                .removeClass("glyphicon-ok")
                                .addClass("glyphicon-remove")
                                .next('.errMsg').html('Mærke navn skal udfyldes, og må ikke have specialtegn');
                
            }
        }
}

$(document).ready( () => {

    // Validate input when user types and releases the key
     $("#categoryForm").keyup( (objForm) => {
        "use strict";
         if(objForm.target.name === "categoryName"){
            validateBrand.brandname("#categoryName");
        }
    });

    $("#categorydFormUpdate").keyup( (objForm) => {
        "use strict";
         if(objForm.target.name === "categoryName"){
            validateBrand.brandname("#categoryNameU");
        }
    });
    var catid;
     $('#modalDeleteCategory').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var categoryName = button.data('categoryname'); 
        catid = button.data('catid');
        var modal = $(this);
        $('#catDelLbl').html(categoryName);
    });
     
        $('#btnDeleteCategory').on('click', ()=>{
            window.location = './index.php?p=Categories&option=Delete&id=' + catid;
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
                    <small> - Kategorier</small>
                </h1>
                <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-list-alt"></i> <a href="./index.php?p=Categories">Kategorier</a>
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
                            <?=print_r($_GET) . PHP_EOL?>
                            Defined base : <?=BASE?><br>
                            <?php print_r($_POST)?>
                          </pre>
                      </div>
                    </div>
                  </div>
                </div>
        <div class="row">
                  <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-8">
                                    <i class="fa fa-tasks fa-2x"></i>
                                     - Tilføj kategori
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                           <form action="./index.php?p=Categories&option=Add" method="post" id="categoryForm">
                               <div class="input-group has-feedback">
                                <span class="input-group-addon" id="sizing-addon2">Kategori navn</span>
                                <input type="text" class="form-control" placeholder="Kategori navn" name="categoryName" id="categoryName" value="<?=@$categoryName?>" aria-describedby="sizing-addon2" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errCategoryName?></span>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon3">Aktiveret</span>
                                <input type="checkbox" name="categoryActive" aria-describedby="sizing-addon3">
                            </div><br>
                            <button type="submit" class="btn btn-lg btn-success">Tilføj</button>
                           </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <h2>Kategorier</h2>
                    
                    <table class="table table-striped table-hover">
                        <thead>    
                            <th>Kategori navn</th>
                            <th>Aktivt</th>
                            <th>Ret</th>
                            <th>Slet</th>                    
                        </thead>
                        <tbody>
                            <?php
                                foreach($categories as $category){
                            ?>
                            <tr>
                                <td>
                                    <?=utf8_encode($category['categoryName'])?>
                                    <div class="collapse" id="categoryCollapseId<?=$category['catId']?>">
                                        <div class="well">
                                            <script>
                                                $(document).ready( () => {
                                                 $("#categoryFormUpdate<?=$category['catId']?>").keyup( (objForm) => {
                                                    "use strict";
                                                    if(objForm.target.name === "categoryName"){
                                                        validateBrand.brandname("#categoryNameU<?=$category['catId']?>");
                                                    }
                                                });
                                                });
                                            </script>
                                           <form action="./index.php?p=Categories&option=Edit&id=<?=$category['catId']?>" method="post" id="categoryFormUpdate<?=$category['catId']?>">
                                            <div class="input-group has-feedback">
                                                <span class="input-group-addon" id="sizing-addon2">Kategori navn</span>
                                                <input type="text" class="form-control" placeholder="Kategori navn" name="categoryName" id="categoryNameU<?=$category['catId']?>" value="<?=utf8_encode($category['categoryName'])?>" aria-describedby="sizing-addon2" required>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <span class="errMsg alert-warning"><?=@$errCategoryName?></span>
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="sizing-addon3">Aktiveret</span>
                                                <input type="checkbox" name="categoryActive"  <?=$category['categoryActive'] == 1 ? 'checked' : ''?> aria-describedby="sizing-addon3">
                                            </div><br>
                                            <button type="submit" name="btnEdit" class="btn btn-lg btn-info">Ret</button>
                                        </form>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?=$category['categoryActive'] == 1 ? 'Aktiveret' : 'Deaktiveret'?>
                                </td>
                                <td>
                                    
                                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#categoryCollapseId<?=$category['catId']?>" aria-expanded="false" aria-controls="categoryCollapseId<?=$category['catId']?>">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </td>
                                <td>
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteCategory" data-categoryName="<?=$category['categoryName']?>" data-catId="<?=$category['catId']?>"><i class="fa fa-remove"></i></button>
                                </td>
                            </tr>

                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalDeleteCategory" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModalLabel">Slet mærke?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Er du sikker på at, du vil slette kategorien "<span id="catDelLbl"></span>"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Anullér</button>
                            <button type="button" id="btnDeleteCategory" class="btn btn-danger">Slet</button>
                        </div>
                        </div>
                    </div>
                    </div>


    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->