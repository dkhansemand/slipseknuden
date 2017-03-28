<?php
header('Content-Type: application/json');
ini_set('html_errors', false);
require_once '../../assets/lib/class.mysql.php';

if($_POST){
    ##print_r($_POST);
    ##print_r($_FILES);
    if(!empty($_POST["pictureTitle"]) ){
            if(preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $_FILES[0]["name"])){
                if($_FILES[0]["size"] < 1536000 && $_FILES[0]["error"] == 0){
                    $filename = date("dmyHisu") . $_FILES[0]["name"];

                    $title = filter_var($_POST['pictureTitle'], FILTER_SANITIZE_STRING);
                    if($_POST['pictureAssign'] == 1){
                        $uploadDir = '../../assets/media/products/';
                        $picType = 'products';
                    }elseif($_POST['pictureAssign'] == 2){
                        $uploadDir = '../../assets/media/employees/';
                        $picType = 'employees';
                    }elseif($_POST['pictureAssign'] == 3){
                        $uploadDir = '../../assets/media/pages/';
                        $picType = 'pages';
                    }else{
                        $uploadDir = '../../assets/media/';
                    }
                    
                    $conn = new dbconnector();
                    $queryPicture = $conn->newQuery("INSERT INTO pictures (pictureFilename, pictureTitle, pictureTypeId)VALUES(:PICTUREFILE, :PICTURETITLE, (SELECT pictureTypeId FROM pictureType WHERE pictureTypeName = :PICTYPE));");
                    $queryPicture->bindParam(':PICTUREFILE', $filename, PDO::PARAM_STR);
                    $queryPicture->bindParam(':PICTURETITLE', $_POST['pictureTitle'], PDO::PARAM_STR);
                    $queryPicture->bindParam(':PICTYPE', $picType, PDO::PARAM_INT);

                    $queryPictureLast = $conn->newQuery("SELECT pictureId, pictureFilename, pictureTitle, pictureType.pictureTypeId FROM pictures 
                    INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                    WHERE pictureFilename = :PICTUREFILE;");
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
