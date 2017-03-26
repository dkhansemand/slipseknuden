-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: slipseknuden
-- ------------------------------------------------------
-- Server version	5.6.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(15) NOT NULL,
  `categoryIsActive` tinyint(1) NOT NULL DEFAULT '0',
  `categoryPosition` varchar(45) DEFAULT NULL,
  `categoriesCreated` int(11) NOT NULL,
  `categoriesLastEdited` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryId`),
  KEY `fk_categoryCreated_idx` (`categoriesCreated`),
  KEY `fk_categoryLastEdited_idx` (`categoriesLastEdited`),
  CONSTRAINT `fk_categoryCreated` FOREIGN KEY (`categoriesCreated`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_categoryLastEdited` FOREIGN KEY (`categoriesLastEdited`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactmessages`
--

DROP TABLE IF EXISTS `contactmessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactmessages` (
  `msgId` int(11) NOT NULL AUTO_INCREMENT,
  `contactName` varchar(45) NOT NULL,
  `contactEmail` varchar(65) NOT NULL,
  `contactMessage` text NOT NULL,
  `contactDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contactIsRead` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msgId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactmessages`
--

LOCK TABLES `contactmessages` WRITE;
/*!40000 ALTER TABLE `contactmessages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactmessages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `logCode` int(11) NOT NULL,
  `logMessage` varchar(45) DEFAULT NULL,
  `logDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logIp` varchar(20) NOT NULL,
  `logUser` int(11) NOT NULL,
  PRIMARY KEY (`logId`),
  KEY `fk_logUser_idx` (`logUser`),
  CONSTRAINT `fk_logUser` FOREIGN KEY (`logUser`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `newsId` int(11) NOT NULL AUTO_INCREMENT,
  `newsTitle` varchar(25) NOT NULL,
  `newsContent` text NOT NULL,
  `newsDateCreated` int(11) DEFAULT NULL,
  `newsPictureId` int(11) DEFAULT NULL,
  `newsLastEdited` int(11) DEFAULT NULL,
  PRIMARY KEY (`newsId`),
  KEY `fk_dateCreated_idx` (`newsDateCreated`),
  KEY `fk_pictureId_idx` (`newsPictureId`),
  KEY `fk_lastedited_idx` (`newsLastEdited`),
  CONSTRAINT `fk_newsDateCreated` FOREIGN KEY (`newsDateCreated`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_newsastedited` FOREIGN KEY (`newsLastEdited`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_newspictureId` FOREIGN KEY (`newsPictureId`) REFERENCES `pictures` (`pictureId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagedetails`
--

DROP TABLE IF EXISTS `pagedetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagedetails` (
  `pageDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `pageDetailsText` text NOT NULL,
  `pageDetailsPicture` int(11) NOT NULL,
  `pageDetailsCreated` int(11) NOT NULL,
  `pageDetailsLastEdited` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageDetailId`),
  KEY `fk_pagedetailsCreated_idx` (`pageDetailsCreated`),
  KEY `fk_pagedetailsPicutre_idx` (`pageDetailsPicture`),
  KEY `fk_pagedatilsedited_idx` (`pageDetailsLastEdited`),
  CONSTRAINT `fk_pagedatilsedited` FOREIGN KEY (`pageDetailsLastEdited`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagedetailsCreated` FOREIGN KEY (`pageDetailsCreated`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagedetailsPicutre` FOREIGN KEY (`pageDetailsPicture`) REFERENCES `pictures` (`pictureId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagedetails`
--

LOCK TABLES `pagedetails` WRITE;
/*!40000 ALTER TABLE `pagedetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagedetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(15) NOT NULL,
  `pageTxtId` int(11) NOT NULL,
  `pagePosition` int(11) DEFAULT NULL,
  `pageCreated` int(11) NOT NULL,
  `pageLastEdited` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageId`),
  KEY `fk_pagedetails_idx` (`pageTxtId`),
  KEY `fk_pagecreated_idx` (`pageCreated`),
  KEY `fk_pageedited_idx` (`pageLastEdited`),
  CONSTRAINT `fk_pagecreated` FOREIGN KEY (`pageCreated`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagedetails` FOREIGN KEY (`pageTxtId`) REFERENCES `pagedetails` (`pageDetailId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pageedited` FOREIGN KEY (`pageLastEdited`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pictures` (
  `pictureId` int(11) NOT NULL AUTO_INCREMENT,
  `pictureFilename` varchar(255) NOT NULL,
  `pictuewTitle` varchar(45) NOT NULL,
  `pictureAdded` int(11) NOT NULL,
  `pictureTypeId` int(11) NOT NULL,
  PRIMARY KEY (`pictureId`),
  KEY `fk_pictureType_idx` (`pictureTypeId`),
  KEY `fk_pictureAdd_idx` (`pictureAdded`),
  CONSTRAINT `fk_pictureAdd` FOREIGN KEY (`pictureAdded`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pictureType` FOREIGN KEY (`pictureTypeId`) REFERENCES `picturetype` (`pictureTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pictures`
--

LOCK TABLES `pictures` WRITE;
/*!40000 ALTER TABLE `pictures` DISABLE KEYS */;
/*!40000 ALTER TABLE `pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `picturetype`
--

DROP TABLE IF EXISTS `picturetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `picturetype` (
  `pictureTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `pictureTypeName` varchar(15) NOT NULL,
  `pictureTypeFolderPath` varchar(65) NOT NULL,
  PRIMARY KEY (`pictureTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picturetype`
--

LOCK TABLES `picturetype` WRITE;
/*!40000 ALTER TABLE `picturetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `picturetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(15) NOT NULL,
  `productDescription` text NOT NULL,
  `productPrice` decimal(9,2) NOT NULL,
  `productAdded` int(11) NOT NULL,
  `productCategoryId` int(11) NOT NULL,
  `productPictureId` int(11) NOT NULL,
  `productOnSale` tinyint(1) NOT NULL DEFAULT '0',
  `productSaleDiscount` int(11) DEFAULT NULL,
  `productLastEdited` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `fk_dateAdded_idx` (`productAdded`),
  KEY `fk_categoryId_idx` (`productCategoryId`),
  KEY `fk_pictureId_idx` (`productPictureId`),
  KEY `fk_lastedited_idx` (`productLastEdited`),
  CONSTRAINT `fk_categoryId` FOREIGN KEY (`productCategoryId`) REFERENCES `categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dateAdded` FOREIGN KEY (`productAdded`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lastedited` FOREIGN KEY (`productLastEdited`) REFERENCES `log` (`logId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pictureId` FOREIGN KEY (`productPictureId`) REFERENCES `pictures` (`pictureId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsettings`
--

DROP TABLE IF EXISTS `shopsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopsettings` (
  `settingsId` int(11) NOT NULL AUTO_INCREMENT,
  `shopTitle` varchar(45) NOT NULL DEFAULT 'Velkommen til Slipseknuden',
  `shopBase` varchar(55) DEFAULT NULL,
  `shopForceSSL` tinyint(1) NOT NULL DEFAULT '0',
  `shopAdress` varchar(25) NOT NULL,
  `shopCity` varchar(15) NOT NULL,
  `shopZipcode` int(11) NOT NULL,
  `shopTelephone` varchar(15) NOT NULL,
  `shopEmail` varchar(45) NOT NULL,
  `shopSettingFacebook` varchar(65) NOT NULL,
  `shopSettingsTwitter` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`settingsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsettings`
--

LOCK TABLES `shopsettings` WRITE;
/*!40000 ALTER TABLE `shopsettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userroles`
--

DROP TABLE IF EXISTS `userroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userroles` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `userRoleName` varchar(10) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userroles`
--

LOCK TABLES `userroles` WRITE;
/*!40000 ALTER TABLE `userroles` DISABLE KEYS */;
/*!40000 ALTER TABLE `userroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(15) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userEmail` varchar(65) NOT NULL,
  `userFirstname` varchar(15) NOT NULL,
  `userLastname` varchar(15) NOT NULL,
  `userTitle` varchar(15) NOT NULL,
  `userPictureId` int(11) NOT NULL,
  `userRole` int(11) NOT NULL DEFAULT '0',
  `UserCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`),
  KEY `fk_profilepicture_idx` (`userPictureId`),
  KEY `fk_userRole_idx` (`userRole`),
  CONSTRAINT `fk_profilepicture` FOREIGN KEY (`userPictureId`) REFERENCES `pictures` (`pictureId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userRole` FOREIGN KEY (`userRole`) REFERENCES `userroles` (`roleId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-22 15:54:28
