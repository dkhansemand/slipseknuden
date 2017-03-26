<?php
 ## Require needed libaries
    require_once './lib/class.mysql.php';

    ## Open connection to Database
    $conn = new dbconnector();
$scanned_directory = array_diff(scandir('./prod_image'), array('..', '.'));
echo '<pre>';

print_r($scanned_directory);

/*foreach($scanned_directory as $picture){
    $query = $conn->newQuery("INSERT INTO hifi_pictures (filename, title)VALUES(:FILE, :TITLE)");
    $query->bindParam(':FILE', $picture, PDO::PARAM_STR);
    $query->bindParam(':TITLE', $picture, PDO::PARAM_STR);
    if($query->execute()){
        echo $picture. ' - [SUCCESS]<br>';  
    }else{
        echo $picture. ' - [ERROR]<br>';
    }
}*/


$conn = null;
