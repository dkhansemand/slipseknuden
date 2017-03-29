<?php
    require_once 'class.mysql.php';
    class getData extends dbconnector{

        public function categories(){
            try{
                $conn = $this->newQuery("SELECT categoryId, categoryName FROM categories WHERE categoryActive = 1 ORDER BY categoryPosition ASC");
                if($conn->execute()){
                    $returnData = $conn->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[Categories]SQL error.';
                }
                
                unset($conn);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PSOException $err){
                $conn = null;
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Categories]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function pageTexts($page){
            try{
                $queryPage = $this->newQuery("SELECT pageDetailsTitle, pageDetailsText from pages 
                INNER JOIN pageDetails ON pageTxtId = pageDetailId
                WHERE pageName = :PAGE");
                $queryPage->bindParam(':PAGE', $page, PDO::PARAM_STR);
                if($queryPage->execute()){
                    $returnData = $queryPage->fetch(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[Page]SQL error.';
                }
                
                unset($conn);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Page]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function products($categoryId){

            try{
                if($categoryId === 0){
                    $queryProducts = $this->newQuery("SELECT productId, productName, productDescription, productPrice, categoryName, pictureTypeFolderPath, pictureFilename
                                                FROM products
                                                INNER JOIN categories ON productCategoryId = categoryId
                                                INNER JOIN pictures ON productPictureId = pictureId
                                                INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                                                ORDER BY productName ASC");
                }else{
                    $queryProducts = $this->newQuery("SELECT productId, productName, productDescription, productPrice, categoryName, pictureTypeFolderPath, pictureFilename
                                                FROM products
                                                INNER JOIN categories ON productCategoryId = categoryId
                                                INNER JOIN pictures ON productPictureId = pictureId
                                                INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                                                WHERE productCategoryId = :ID
                                                ORDER BY productName ASC");
                    $queryProducts->bindParam(':ID', $categoryId, PDO::PARAM_INT); 
                }

                if($queryProducts->execute()){
                    $returnData = $queryProducts->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[Home]SQL error.';
                }
                unset($queryProducts);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Home]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function product($productId){

            try{
                $queryProduct = $this->newQuery("SELECT productId, productName, productDescription, productPrice, categoryName, pictureTypeFolderPath, pictureFilename
                                                FROM products
                                                INNER JOIN categories ON productCategoryId = categoryId
                                                INNER JOIN pictures ON productPictureId = pictureId
                                                INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                                                WHERE productId = :ID");
                $queryProduct->bindParam(':ID', $productId, PDO::PARAM_INT);
                if($queryProduct->execute()){
                    $returnData = $queryProduct->fetch(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[Product]SQL error.';
                }
                unset($queryProduct);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            
            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Product]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function search($searchValue){
            try{
                $searchStr = '%' . $searchValue . '%';
                $querySearch = $this->newQuery("SELECT productId, productName, productDescription, productPrice, categoryName, pictureTypeFolderPath, pictureFilename
                                                FROM products
                                                INNER JOIN categories ON productCategoryId = categoryId
                                                INNER JOIN pictures ON productPictureId = pictureId
                                                INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                                                WHERE productName LIKE :VALUE");
                $querySearch->bindParam(':VALUE', $searchStr, PDO::PARAM_STR);
                if($querySearch->execute()){
                    $returnData = $querySearch->fetchAll(PDO::FETCH_ASSOC);
                }
                unset($querySearch);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Search]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function shopInfo(){
            try{
                $queryShopInfo = $this->newQuery("SELECT shopTitle, shopBase, shopAddress, shopZipcode, shopCity, shopTelephone, shopEmail FROM shopsettings WHERE settingsId = 1");
                if($queryShopInfo->execute()){
                    $returnData = $queryShopInfo->fetch(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[ShopInfo]SQL error.';
                }   
                unset($queryShopInfo);
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[ShopInfo]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function getRandomProducts($limit = 2){
            try{
                $queryRandom = $this->newQuery("SELECT productId, productName, productDescription, productPrice, categoryName, pictureTypeFolderPath, pictureFilename
                                                FROM products
                                                INNER JOIN categories ON productCategoryId = categoryId
                                                INNER JOIN pictures ON productPictureId = pictureId
                                                INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId
                                                ORDER BY RAND() LIMIT :NUM");
                $queryRandom->bindParam(':NUM', $limit, PDO::PARAM_INT);
                if($queryRandom->execute()){
                    $returnData = $queryRandom->fetchAll(PDO::FETCH_ASSOC);

                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[random]SQL error.';
                }   
                unset($queryRandom);
                return json_encode($returnData, JSON_FORCE_OBJECT);

            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[RandomProducts]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function latestNews($limit = 2){
            try{
                $queryNewsNewest = $this->newQuery("SELECT newsId, newsTitle, newsContent, DATE_FORMAT(newsDateCreated, '%d/%m %Y %H:%i') AS newsDate
                                                        FROM news 
                                                        ORDER BY newsDate DESC LIMIT :NUM;");
                $queryNewsNewest->bindParam(':NUM', $limit, PDO::PARAM_INT);
                if($queryNewsNewest->execute()){
                    $returnData = $queryNewsNewest->fetchAll(PDO::FETCH_ASSOC);

                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[randomNews]SQL error.';
                }   
                unset($queryNewsNewest);
                return json_encode($returnData, JSON_FORCE_OBJECT);

            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[NewsNewst]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }

        public function getEmployees(){
            try{
                $queryEmployees = $this->newQuery("SELECT userEmail, userFirstname, userLastname, 
                                            userRoleName, pictureFilename, pictureTypeFolderPath
                                            FROM users
                                            INNER JOIN userRoles ON roleId = userRole
                                            INNER JOIN pictures ON userPictureId = pictureId
                                            INNER JOIN pictureType ON pictures.pictureTypeId = pictureType.pictureTypeId AND pictureType.pictureTypeId = 2
                                            ORDER BY roleId ASC;");
                if($queryEmployees->execute()){
                    $returnData = $queryEmployees->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $returnData['error'] = true;
                    $returnData['errMsg'] = '[employees]SQL error.';
                }   
                unset($queryEmployees);
                return json_encode($returnData, JSON_FORCE_OBJECT);

            }catch(PDOException $err){
                $returnData['error'] = true;
                $returnData['errMsg'] = '[Employees]Connection failed: ' . $err->getMessage();
                return json_encode($returnData, JSON_FORCE_OBJECT);
            }
        }
    }
