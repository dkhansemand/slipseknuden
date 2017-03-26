<?php
    ## Require needed libaries
    require_once '../../lib/class.mysql.php';
    $infoArr = array();

    ## Open connection to Database
    $conn = new dbconnector();
    $queryCat = $conn->newQuery("SELECT catid, categoryName FROM hifi_category;");
    $queryPic = $conn->newQuery("SELECT pictureid, picturefilename FROM hifi_pictures;");    
    $queryMan = $conn->newQuery("SELECT bid, brandName FROM hifi_brands;");
    if($queryCat->execute()){
        $infoArr['Cat'] = $queryCat->fetchAll(PDO::FETCH_ASSOC);
    }
    if($queryPic->execute()){
        $infoArr['Pic'] = $queryPic->fetchAll(PDO::FETCH_ASSOC);
        
    }
    if($queryMan->execute()){
        $infoArr['Man'] = $queryMan->fetchAll(PDO::FETCH_ASSOC);
        
    }

    if(isset($_POST)){
        if(!empty($_POST['productName']) && !empty($_POST['productPrice'])){
            $queryInsert = $conn->newQuery("INSERT INTO hifi_products (productTitle, productDetails, productprice, manufacturerId, productPicture, categoryId)
                                            VALUES(:TITLE, :DETAILS, :PRICE, :MANUID, :PICTUREID, :CATID)");
            $queryInsert->bindParam(':TITLE', $_POST['productName'], PDO::PARAM_STR);   
            $queryInsert->bindParam(':DETAILS', $_POST['productDetails'], PDO::PARAM_STR);      
            $queryInsert->bindParam(':PRICE', $_POST['productPrice'], PDO::PARAM_STR);     
            $queryInsert->bindParam(':MANUID', $_POST['manufacturer'], PDO::PARAM_INT);   
            $queryInsert->bindParam(':PICTUREID', $_POST['productPicture'], PDO::PARAM_INT);       
            $queryInsert->bindParam(':CATID', $_POST['productCategory'], PDO::PARAM_INT);  

            if($queryInsert->execute()){
                ?>
                <div class="panel panel-default">
                        <div class="panel-heading">Produkt tilføjet</div>
                            <div class="panel-body">
                                <div class="alert alert-success" role="alert">
                                    Produktet er nu tilføjet til databasen!
                                </div>
                            </div>
                        </div>  
                    </div>   
                 <?php
            }                          
        }
    }

?>

<html>

<head>
    <meta charset="utf-8">
    <title>HIFI - BACKEND</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mystyle.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
<header>
	<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="./" class="navbar-brand">HIFI - BACKEND</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <nav class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">Forside</a></li>
            <li><a href="addProduct.php">Tilføj produkt</a></li>
        </nav>
      </div>
    </div>
</header>

<main class="container">
    <br>
    <h2 class="page-header">Tilføj produkt</h2>
<form method="post" action="">
    
    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2">-</span>
        <input type="text" class="form-control" placeholder="Produkt navn" name="productName" aria-describedby="sizing-addon2">
    </div>
     <div class="input-group">
        <label for="">Produkt beskrivelse</label>
        <textarea name="productDetails" class="form-control" col="15" rows="10">bh etue tisi blandiatue dolum dolessim ea feummy nostrud delendi pissequ ametum in etuerit etue tatiscipit nos ex el init lore tatet do conullum diamet venim dolore facidunt dit doluptat
        </textarea>
    </div>
    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon5">DKK kr.</span>
        <input type="text" class="form-control" placeholder="Produkt pris" name="productPrice" value="9999,75" aria-describedby="sizing-addon5">
    </div>
     <div class="input-group">
        <label for="basic-url">Kategori</label>
        <select name="productCategory">
            <?php
                foreach($infoArr['Cat'] as $Category){
            ?>
                <option value="<?=$Category['id']?>"><?=utf8_encode($Category['categoryName'])?></option>

                <?php
                }
                ?>
        </select>
    </div>
    <div class="input-group">
        <label for="basic-url">Mærke</label>
        <select name="manufacturer">
            <?php
                foreach($infoArr['Man'] as $Manuf){
            ?>
                <option value="<?=$Manuf['id']?>"><?=utf8_encode($Manuf['brandName'])?></option>

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
                <option value="<?=$Picture['id']?>"><?=utf8_encode($Picture['picturefilename'])?></option>

                <?php
                }
                ?>
        </select><br>
        <script>
            $(document).ready(()=>{
                var picture = $('#productPic option:selected').text();
                    $("#showPic").attr("src","../../prod_image/" + picture);
                $('#productPic').on('change', function() {
                    var picture = $('#productPic option:selected').text();
                    $("#showPic").attr("src","../../prod_image/" + picture);
                });
            });
            </script>
        <img id="showPic" src="">
        <span id="showPic"></span>
    </div>
    <button type="submit" class="btn btn-success">Tilføj</button>
</form>

</main>

</body>
</html>
<?php

$conn = null;
