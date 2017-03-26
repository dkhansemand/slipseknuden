<?php

    if(!empty($_POST)){
        if(!empty($_POST['brandName']) && $_GET['option'] === 'Add'){
            $errCount = 0;
            $brandName = $_POST['brandName'];
            if(!preg_match('/\w+$/', $brandName)){
                ++$errCount;
                $errBrandName = 'Feltet må kun indholde bogstaver og tal.';
            }

            if($errCount === 0){
                $queryInsertBrand = $conn->newQuery("INSERT INTO hifi_brands (brandName)VALUES(:BRAND)");
                $queryInsertBrand->bindParam(':BRAND', $brandName, PDO::PARAM_STR);
                if($queryInsertBrand->execute()){
                    $success = true;
                    $successErr = false;
                    $successTitle = 'Brand tilføjet';
                    $successMsg = 'Brand "' . $brandName . '" er nu tilføjet til databasen';
                    unset($brandName);
                }
            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Brand navn skal udfyldes og må ikke have specialtegn.';
            }
        }

         if(!empty($_POST['brandName']) && $_GET['option'] === 'Edit' && !empty($_GET['id'])){
            $errCount = 0;
            $bid = (int)$_GET['id'];
            $brandName = $_POST['brandName'];
            if(!preg_match('/\w+$/', $brandName)){
                ++$errCount;
                $errBrandName = 'Feltet må kun indholde bogstaver og tal.';
            }

            if($errCount === 0){
                $queryUpdateBrand = $conn->newQuery("UPDATE hifi_brands SET brandName = :NAME WHERE bid = :ID");
                $queryUpdateBrand->bindParam(':NAME', $brandName, PDO::PARAM_STR);
                $queryUpdateBrand->bindParam(':ID', $bid, PDO::PARAM_INT);
                if($queryUpdateBrand->execute()){
                    $success = true;
                    $successErr = false;
                    $successTitle = 'Brand Opdateret';
                    $successMsg = 'Brand "' . $brandName . '" er nu opdateret i databasen';
                    unset($brandName);
                }
            }else{
                $success = true;
                $successErr = true;
                $successTitle = 'Fejl i indtastning!';
                $successMsg = 'Brand navn skal udfyldes og må ikke have specialtegn.';
            }

         }


    }
         if(!empty($_GET['option']) && $_GET['option'] === 'Delete' && !empty($_GET['id'])){
            
            $bid = (int)$_GET['id'];
            $queryDeleteBrand = $conn->newQuery("DELETE FROM hifi_brands WHERE bid = :BID");
            $queryDeleteBrand->bindParam(':BID', $bid, PDO::PARAM_INT);
            if($queryDeleteBrand->execute()){
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
                        <h4 class="modal-title">Brand slettet</h4>
                    </div>
                    <div class="modal-body">
                        <p>Brand er nu blevet slettet i databasen!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="./index.php?p=Brands" class="btn btn-success">OK</a>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php
            }
         }

    $queryGetBrands = $conn->newQuery("SELECT bid, brandName FROM hifi_brands ORDER BY brandName ASC");
    $queryGetBrands->execute();
    $brands = $queryGetBrands->fetchAll(PDO::FETCH_ASSOC);
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
     $("#brandForm").keyup( (objForm) => {
        "use strict";
         if(objForm.target.name === "brandName"){
            validateBrand.brandname("#brandName");
        }
    });

    $("#brandFormUpdate").keyup( (objForm) => {
        "use strict";
         if(objForm.target.name === "brandName"){
            validateBrand.brandname("#brandNameU");
        }
    });
    var bid;
     $('#modalDeleteBrand').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var brandName = button.data('brandname'); 
        bid = button.data('bid');
        var modal = $(this);
        $('#brandDelLbl').html(brandName);
    });
     
        $('#btnDeleteBrand').on('click', ()=>{
            window.location = './index.php?p=Brands&option=Delete&id=' + bid;
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
                    <small> - Brands</small>
                </h1>
                <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-tags"></i> <a href="./index.php?p=Brands"> Brands </a>
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
                            <?php print_r($brands)?>
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
                                     - Tilføj brand
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                           <form action="./index.php?p=Brands&option=Add" method="post" id="brandForm">
                               <div class="input-group has-feedback">
                                <span class="input-group-addon" id="sizing-addon2">Brand navn</span>
                                <input type="text" class="form-control" placeholder="Brand navn" name="brandName" id="brandName" value="<?=@$brandName?>" aria-describedby="sizing-addon2" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errBrandName?></span>
                            </div><br>
                            <button type="submit" name="btnAdd" class="btn btn-lg btn-success">Tilføj</button>
                           </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <h2>Brands</h2>
                    
                    <table class="table table-striped table-hover">
                        <thead>    
                            <th>Brand navn</th>
                            <th>Ret</th>
                            <th>Slet</th>                    
                        </thead>
                        <tbody>
                            <?php
                                foreach($brands as $brand){
                            ?>
                            <tr>
                                <td>
                                    <?=$brand['brandName']?>
                                    <div class="collapse" id="brandCollapseId<?=$brand['bid']?>">
                                        <div class="well">
                                            <script>
                                                $(document).ready( () => {
                                                 $("#brandFormUpdate<?=$brand['bid']?>").keyup( (objForm) => {
                                                    "use strict";
                                                    if(objForm.target.name === "brandName"){
                                                        validateBrand.brandname("#brandNameU<?=$brand['bid']?>");
                                                    }
                                                });
                                                });
                                            </script>
                                           <form action="./index.php?p=Brands&option=Edit&id=<?=$brand['bid']?>" method="post" id="brandFormUpdate<?=$brand['bid']?>">
                                            <div class="input-group has-feedback">
                                                <span class="input-group-addon" id="sizing-addon2">Brand navn</span>
                                                <input type="text" class="form-control" placeholder="Brand navn" name="brandName" id="brandNameU<?=$brand['bid']?>" value="<?=$brand['brandName']?>" aria-describedby="sizing-addon2" required>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <span class="errMsg alert-warning"><?=@$errBrandName?></span>
                                            </div><br>
                                            <button type="submit" name="btnEdit" class="btn btn-lg btn-info">Ret</button>
                                        </form>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    
                                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#brandCollapseId<?=$brand['bid']?>" aria-expanded="false" aria-controls="brandCollapseId<?=$brand['bid']?>">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </td>
                                <td>
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteBrand" data-brandName="<?=$brand['brandName']?>" data-bid="<?=$brand['bid']?>"><i class="fa fa-remove"></i></button>
                                </td>
                            </tr>

                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalDeleteBrand" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="ModalLabel">Slet brand?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Er du sikker på at, du vil slette brandet "<span id="brandDelLbl"></span>"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Anullér</button>
                            <button type="button" id="btnDeleteBrand" class="btn btn-danger">Slet</button>
                        </div>
                        </div>
                    </div>
                    </div>


    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->