<?php
    if(isset($_GET['option'])){
        $getParamOpt = $_GET['option'];

        if($getParamOpt === 'Add' || $getParamOpt === 'View'){
            $infoArr = array();

            ## Select nessecary information to form from DB
            $queryCat = $conn->newQuery("SELECT categoryId, categoryName FROM categories;");
            $queryPic = $conn->newQuery("SELECT pictureid, picturefilename, pictureTypeFolderPath FROM pictures
            INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId;");    
            
            if($queryCat->execute()){
                $infoArr['Cat'] = $queryCat->fetchAll(PDO::FETCH_ASSOC);
            }
            if($queryPic->execute()){
                $infoArr['Pic'] = $queryPic->fetchAll(PDO::FETCH_ASSOC);
                
            }
            

            if(isset($_POST) && isset($_POST['btnAdd'])){
                if(!empty($_POST['productNameA']) && !empty($_POST['productPrice']) && !empty($_POST['productDetails'])){
                    $errCount = 0;
                    $productName = $_POST['productNameA'];
                    $productDetails = $_POST['productDetails'];
                    $productPrice = $_POST['productPrice'];

                    if(!preg_match('/\w+$/', $productName)){
                        ++$errCount;
                        $errProdName = 'Feltet må kun indholde bogstaver og tal.';
                    }

                    if(!preg_match('/^[a-zA-ZÆØÅæøå0-9\s._-]+$/', $productDetails)){
                        ++$errCount;
                        $errProdDetails = 'Feltet må kun indholde bogstaver og tal.';
                    }

                    if(!preg_match('/^([0-9]\d*|0)(\,[0-9]{2})?$/', $productPrice)){
                        ++$errCount;
                        $errProdPrice = 'Feltet må kun indholde tal i format 00,00.';
                    }

                    if($errCount === 0){
                        $queryInsert = $conn->newQuery("INSERT INTO products (productName, productDescription, productprice, productPictureId, productCategoryId)
                                                        VALUES(:NAME, :DETAILS, :PRICE, :PICTUREID, :CATID)");
                        $queryInsert->bindParam(':NAME', $productName, PDO::PARAM_STR);   
                        $queryInsert->bindParam(':DETAILS', $productDetails, PDO::PARAM_STR);      
                        $queryInsert->bindParam(':PRICE', $productPrice, PDO::PARAM_STR);     
                        $queryInsert->bindParam(':PICTUREID', $_POST['productPicture'], PDO::PARAM_INT);       
                        $queryInsert->bindParam(':CATID', $_POST['productCategory'], PDO::PARAM_INT);  

                        if($queryInsert->execute()){
                            $success = true;
                            $successErr = false;
                            $successTitle = 'Produkt tilføjet';
                            $successMsg = 'Produktet "' . $productName . '" er nu tilføjet til databasen';
                            unset($productName, $productDetails, $productPrice);
                        } 
                    }                         
                }else{
                    $success = true;
                    $successErr = true;
                    $successTitle = 'Fejl i indtastning!';
                    $successMsg = 'Produktnavn, produkt beskrivelse og produkt pris, skal udfyldes og være i korrekt format.';
                }
            }

            if(isset($_POST) && isset($_POST['btnUpdate'])){
                if(!empty($_POST['productName']) && !empty($_POST['productPrice'])){
                    $errCount = 0;
                    $pid = (int)$_GET['id'];
                    $productName = $_POST['productName'];
                    $productDetails = $_POST['productDetails'];
                    $productPrice = $_POST['productPrice'];

                    if(!preg_match('/\w+$/', $productName)){
                        ++$errCount;
                        $errProdName = 'Feltet må kun indholde bogstaver og tal.';
                    }

                    if(!preg_match('/^[a-zA-ZÆØÅæøå0-9\s._-]+$/', $productDetails)){
                        ++$errCount;
                        $errProdDetails = 'Feltet må kun indholde bogstaver og tal.';
                    }

                    if(!preg_match('/^([0-9]\d*|0)(\,[0-9]{2})?$/', $productPrice)){
                        ++$errCount;
                        $errProdPrice = 'Feltet må kun indholde tal i format 00,00.';
                    }

                    if($errCount === 0){
                        $queryUpdate = $conn->newQuery("UPDATE products
                                                       SET productCategoryId = :CATID, productDescription = :DETAILS,
                                                        productPictureId = :PICTUREID, productPrice = :PRICE, productName = :TITLE
                                                        WHERE productId = :ID;");
                        $queryUpdate->bindParam(':TITLE', $productName, PDO::PARAM_STR);   
                        $queryUpdate->bindParam(':DETAILS', $productDetails, PDO::PARAM_STR);      
                        $queryUpdate->bindParam(':PRICE', $productPrice, PDO::PARAM_STR);  
                        $queryUpdate->bindParam(':PICTUREID', $_POST['productPicture'], PDO::PARAM_INT);       
                        $queryUpdate->bindParam(':CATID', $_POST['productCategory'], PDO::PARAM_INT); 
                        $queryUpdate->bindParam(':ID', $pid, PDO::PARAM_INT); 

                        if($queryUpdate->execute())
                        {
                            $productUpdate = $_POST;
                            $success = true;
                            $successErr = false;
                            $successTitle = 'Produkt opdateret';
                            $successMsg = 'Produktet "' . $_POST['productName'] . '" er nu opdateret i databasen';
                        }
                    }else{
                        $success = true;
                        $successErr = true;
                        $successTitle = 'Fejl i indtastning!';
                        $successMsg = 'Produktnavn, produkt beskrivelse og produkt pris, skal udfyldes og være i korrekt format.';
                    }

                }
            }
        }

        if($getParamOpt === 'View' && !empty($_GET['id'])){
            $productId = (int)$_GET['id'];
            $queryProduct =  $conn->newQuery(" SELECT productId, productName, productDescription, productPrice,
                                            pictureTypeFolderPath,
                                            pictureFilename, pictureTitle,
                                            categoryName
                                            FROM products
                                            LEFT JOIN categories ON categoryId = productCategoryId
                                            LEFT JOIN pictures ON pictureId = productPictureId
                                            LEFT JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                                            WHERE productId = :ID
                                        ");
            $queryProduct->bindParam(':ID', $productId, PDO::PARAM_INT);
            if($queryProduct->execute()){
                $productView = $queryProduct->fetch(PDO::FETCH_ASSOC);
            }
        }


        if($getParamOpt === 'Delete' && !empty($_GET['id'])){
            $pid = (int)$_GET['id'];

            $getPicture = $conn->newQuery("SELECT pictureId, pictureFilename, pictureTypeFolderPath FROM products
                INNER JOIN pictures ON pictureId = productPictureId
                INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
             WHERE productId = :ID");
            $getPicture->bindParam(':ID', $pid, PDO::PARAM_INT);
            if($getPicture->execute()){
                $filename = $getPicture->fetch(PDO::FETCH_ASSOC);
                $pictureId = $filename['pictureId'];
                    $pictureDir = '../assets/media/'. $filename['pictureTypeFolderPath'] . '/';
                
            } 
            
            $queryDelete = $conn->newQuery("DELETE FROM products WHERE productId = :ID; DELETE FROM pictures WHERE pictureId = :PICID");
            $queryDelete->bindParam(':ID', $pid, PDO::PARAM_INT);
            $queryDelete->bindParam(':PICID', $pictureId, PDO::PARAM_INT);

            if($queryDelete->execute()){
                if(unlink($pictureDir . $filename['pictureFilename'])){
            ?>
            <script type="text/javascript">
                $(window).load(function(){
                    $('.modal').modal('show');
                });
            </script>
            <div class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Produkt slettet</h4>
                    </div>
                    <div class="modal-body">
                        <p>Produktet er nu blevet slettet i databasen!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="./index.php?p=Products" class="btn btn-success">OK</a>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php
            }else{
               ?>
            <script type="text/javascript">
                $(window).load(function(){
                    $('.modal').modal('show');
                });
            </script>
            <div class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Fejl ved sletning</h4>
                    </div>
                    <div class="modal-body">
                        <p><?=var_dump(unlink($pictureDir . $filename['pictureFilename']))?></p>
                    </div>
                    <div class="modal-footer">
                        <a href="./index.php?p=Products" class="btn btn-success">OK</a>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php
            }
            }
        }


    }else{
    
        $queryProducts = $conn->newQuery("SELECT productId, productName, productDescription, productPrice,
                                            pictureTypeFolderPath,
                                            pictureFilename, pictureTitle,
                                            categoryName
                                            FROM products
                                            LEFT JOIN categories ON categoryId = productCategoryId
                                            LEFT JOIN pictures ON pictureId = productPictureId
                                            LEFT JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
   
                                        ");
        if($queryProducts->execute()){
            $products = $queryProducts->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    


?>
<script src="./js/app.js"></script>
<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Kontrolpanel
                            <small> - Produkter</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-cubes"></i>  <a href="./index.php?p=Products">Produkter</a>
                            </li>
                            <?php
                            if(@$getParamOpt === 'Add'){
                            ?>
                                <li class="active">
                                    <a href="./index.php?p=Products&option=Add">Tilføj produkt</a>
                                </li>
                            <?php
                            }
                            if(@$getParamOpt === 'View'){
                            ?>
                                <li class="active">
                                    <a href="./index.php?p=Products&option=View&id=<?=$productId?>"><?=$productView['categoryName'] . ' - ' . $productView['productName']?></a>
                                </li>
                            <?php
                            }
                            ?>
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
                            <?=print_r($_GET)?><br> Defined base : <?=BASE?><br><?=print_r(@$productView, true)?>
                            <?=print_r(@$productUpdate, true)?>
                          </pre>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
                 <div class="row <?=$getParamOpt === 'Add' || $getParamOpt === 'View' || $getParamOpt === 'Delete' ? 'hidden': ''?>">
                  <div class="col-lg-4">
                          <a href="./index.php?p=Products&option=Add" class="btn btn-lg btn-success"><i class="fa fa-plus"></i>Tilføj Produkt</a>
                    </div>
                  </div>
                
                <!-- /.row -->
                <!-- Produkt list -->
                <?php
                    
                ?>
                <div class="row <?=$getParamOpt === 'Add' || $getParamOpt === 'View' || $getParamOpt === 'Delete' ? 'hidden': ''?>">
                  <div class="col-lg-12">
                        <h2>Produkter</h2>
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <th>Titel</th>
                                <th>Beskrivelse</th>
                                <th>Pris (DKK)</th>
                                <th>Kategori</th>
                                <th>Billede</th>
                                <th>Redigér<th>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($products)){
                                        for($productCount = 0; $productCount < count($products); $productCount++){
                                        ?>
                                        <tr>
                                            <td><?=$products[$productCount]['productName']?></td>
                                            <td><?=$products[$productCount]['productDescription']?></td>
                                            <td><?=$products[$productCount]['productPrice']?></td>
                                            <td><?=$products[$productCount]['categoryName']?></td>
                                            <td><img src="../assets/media/<?=$products[$productCount]['pictureTypeFolderPath'].'/'.$products[$productCount]['pictureFilename']?>" alt="<?=$products[$productCount]['pictureName']?>" height="85" width="auto"></td>
                                            <td>
                                                <a href="./index.php?p=Products&option=View&id=<?=$products[$productCount]['productId']?>" class="btn btn-info">Ret</a>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteProd" data-productName="<?=$products[$productCount]['productName']?>" data-pid="<?=$products[$productCount]['productId']?>">Slet</button>
                                                
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <!-- Modal -->
                        
                        <div class="modal fade" id="modalDeleteProd" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLbl">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Slet produkt?</h4>
                                </div>
                                <div class="modal-body">
                                    Er du sikker på, at du vil slette produktet "<span id="productName"></span>"?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Anullér</button>
                                    <button type="button" id="btnDeleteProd" class="btn btn-danger">Slet produkt</button>
                                    
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                
                <!-- /.row -->
                <?php
                    if(@$getParamOpt === 'Add'){
                ?>
                <script src="<?=BASE?>/js/validateProduct.js"></script>
                <div class="row">
                  <div class="col-lg-10">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <i class="fa fa-plus fa-2x"></i>
                                      Tilføj produkt
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                          <form method="post" action="" id="productAddForm">
    
                            <div class="input-group col-lg-6 has-feedback">
                                <span class="input-group-addon" id="sizing-addon2">Produkt navn</span>
                                <input type="text" class="form-control" placeholder="Produkt navn" name="productNameA" id="productNameA" value="<?=@$productName?>" aria-describedby="sizing-addon2" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errProdName?></span>
                            </div><br>
                            <div class="input-group has-feedback">
                                <label for="">Produkt beskrivelse</label>
                                <textarea name="productDetails" id="productDetails" class="form-control" col="15" rows="10" required><?=@$productDetails?></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errProdDetails?></span>
                            </div><br>  
                            <div class="input-group col-lg-4 has-feedback">
                                <span class="input-group-addon" id="sizing-addon5">kr. (00,00)</span>
                                <input type="text" class="form-control" placeholder="Produkt pris" name="productPrice" id="productPrice" value="<?=@$productPrice?>" aria-describedby="sizing-addon5" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg alert-warning"><?=@$errProdPrice?></span>
                            </div><br>
                            <div class="input-group">
                                <label for="basic-url">Kategori</label>
                                <select name="productCategory">
                                    <?php
                                        foreach($infoArr['Cat'] as $Category){
                                    ?>
                                        <option value="<?=$Category['categoryId']?>"><?=$Category['categoryName']?></option>

                                        <?php
                                        }
                                        ?>
                                </select>
                            </div><br>
                            
                            <div class="input-group">
                                <label for="basic-url">Produkt billede</label>
                                
                                <select id="productPic" name="productPicture">
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
                                        var picture = $('#productPic option:selected').text();
                                            $("#showPic").attr("src","../assets/media/products/" + picture);
                                        $('#productPic').on('change', function() {
                                            var picture = $('#productPic option:selected').text();
                                            $("#showPic").attr("src","../assets/media/products/" + picture);
                                        });
                                    });
                                    </script>
                                <img id="showPic" src="">
                                <span id="showPic"></span>
                            </div>
                            <button type="submit" name="btnAdd" class="btn btn-lg btn-success">Tilføj</button>
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
                                                        <option value="1">Produkt billede</option>
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
                
                
                
                
                <!-- /.row -->


                <?php
                    if(@$getParamOpt === 'View' && !empty($_GET['id'])){
                ?>
                <script src="<?=BASE?>/js/validateProduct.js"></script>
                <div class="row">
                  <div class="col-lg-10">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <i class="fa fa-pencil fa-2x"></i>
                                      Redigér produkt
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                          <form method="post" action="" id="productUpdateForm">
    
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">Produkt navn</span>
                                <input type="text" class="form-control" value="<?=$productView['productName']?>" name="productName" id="productNameU" aria-describedby="sizing-addon2" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg"><?=@$errProdName?></span>
                            </div>
                            <div class="input-group">
                                <label for="">Produkt beskrivelse</label>
                                <textarea name="productDetails" id="productDetails" class="form-control" col="15" rows="10" required><?=$productView['productDescription']?>
                                </textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg"><?=@$errProdDetails?></span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon5">DKK kr.</span>
                                <input type="text" class="form-control" placeholder="Produkt pris" name="productPrice" id="productPrice" value="<?=str_replace('.',',',$productView['productPrice'])?>" aria-describedby="sizing-addon5" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="errMsg"><?=@$errProdPrice?></span>
                            </div>
                            <div class="input-group">
                                <label for="basic-url">Kategori</label>
                                <select name="productCategory">
                                <?php
                                    foreach($infoArr['Cat'] as $Category){
                                ?>
                                        <option value="<?=$Category['categoryId']?>" <?= $productView['categoryName'] === $Category['categoryName'] ? 'selected':''?>><?=utf8_encode($Category['categoryName'])?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="input-group">
                                <label for="basic-url">Produkt billede</label>
                                
                                <select id="productPic" name="productPicture">
                                        <?php
                                        foreach($infoArr['Pic'] as $Picture){
                                    ?>
                                        <option value="<?=$Picture['pictureid']?>" <?= $productView['pictureFilename'] === $Picture['picturefilename'] ? 'selected':''?>><?=$Picture['picturefilename']?></option>

                                        <?php
                                        }
                                        ?>
                                </select><br>
                                <script>
                                    $(document).ready(()=>{
                                        var picture = $('#productPic option:selected').text();
                                            $("#showPic").attr("src","../assets/media/products/" + picture);
                                        $('#productPic').on('change', function() {
                                            var picture = $('#productPic option:selected').text();
                                            $("#showPic").attr("src","../assets/media/products/" + picture);
                                        });
                                    });
                                    </script>
                                <img id="showPic" src="">
                                <span id="showPic"></span>
                      
                            </div>
                            <button type="submit" name="btnUpdate" class="btn btn-lg btn-info">Redigér</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->