<?php
header('Content-Type: application/json');
ini_set('html_errors', false);
require_once '../../lib/class.mysql.php';

if($_POST){
    ##print_r($_POST);
    ##print_r($_FILES);
    if(!empty($_POST["pictureTitle"]) ){
            if(preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $_FILES[0]["name"])){
                if($_FILES[0]["size"] < 1536000 && $_FILES[0]["error"] == 0){
                    $filename = date("dmyHisu") . $_FILES[0]["name"];

                    $title = filter_var($_POST['pictureTitle'], FILTER_SANITIZE_STRING);
                    if($_POST['pictureAssign'] == 1){
                        $uploadDir = '../../prod_image/';
                        (int)$isProduct = 1;
                    }else{
                        $uploadDir = '../../img/';
                        (int)$isProduct = 0;
                    }
                    
                    $conn = new dbconnector();
                    $queryPicture = $conn->newQuery("INSERT INTO hifi_pictures (pictureFilename, pictureTitle, pictureIsProduct)VALUES(:PICTUREFILE, :PICTURETITLE, :ISPRODUCT);");
                    $queryPicture->bindParam(':PICTUREFILE', $filename, PDO::PARAM_STR);
                    $queryPicture->bindParam(':PICTURETITLE', $_POST['pictureTitle'], PDO::PARAM_STR);
                    $queryPicture->bindParam(':ISPRODUCT', $isProduct, PDO::PARAM_INT);

                    $queryPictureLast = $conn->newQuery("SELECT pictureId, pictureFilename, pictureTitle, pictureIsProduct FROM hifi_pictures WHERE pictureFilename = :PICTUREFILE;");
                    $queryPictureLast->bindParam(':PICTUREFILE', $filename, PDO::PARAM_STR);

                    if($queryPicture->execute() && $queryPictureLast->execute()){
                        $result['queryResponse'] = $queryPictureLast->fetch(PDO::FETCH_ASSOC);
                        if (move_uploaded_file($_FILES[0]['tmp_name'], $uploadDir . $filename)) {
                            $result['msg'] = 'Billedet er nu uploadet og tilføjet til databasen!';
                            $result['errState'] = 0;
                            
                        } else {
                            $result['msg'] = 'Billedet blev ikke uploadet!';
                            $result['errState'] = 1;
                            
                        }
                    }else{
                        $result['msg'] = 'Billedet blev ikke tilføjet til databasen!';
                        $result['errState'] = 1;
                        
                    }
                    
                }else{
                    $result['msg'] = 'Fejl i upload! -> Billedet er for stort MAX 1.5MB';
                    $result['errState'] = 1;
                    
                }
            }else{
                $result['msg'] = 'Fejl fil format ikke godkendt!';
                $result['errState'] = 1;
                
            }
    }else{
        $result['msg'].= 'Fejl alle felter skal udfyldes og fil valgt!';
        $result['errState'] = 1;
       
    }
    echo json_encode($result, JSON_FORCE_OBJECT);
    unset($conn);
}
