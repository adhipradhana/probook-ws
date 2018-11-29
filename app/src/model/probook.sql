-- MySQL dump 10.13  Distrib 5.7.20, for osx10.13 (x86_64)
--
-- Host: localhost    Database: probook
-- ------------------------------------------------------
-- Server version	5.7.20

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
-- Table structure for table `ActiveTokens`
--

DROP TABLE IF EXISTS `ActiveTokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ActiveTokens` (
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(300) DEFAULT NULL,
  `user_agent` varchar(300) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `expiration_timestamp` bigint(20) DEFAULT NULL,
  `google_login` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ActiveTokens`
--

LOCK TABLES `ActiveTokens` WRITE;
/*!40000 ALTER TABLE `ActiveTokens` DISABLE KEYS */;
INSERT INTO `ActiveTokens` VALUES (4,'782ed21562eb251a88d8db03c75d2e9b','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543536344,0),(4,'89e0cd93562f317ab4d4d99a63dcdc05','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543536384,0),(11,'0d7b7da5adaf3b7ba6135e72238f37e3','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543536508,1),(11,'3caea51376ca4ebc9ac30356182ecc70','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544634,1),(11,'87e56c49ca0f4e749ac87f70271caebc','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544654,0),(11,'0c4f4d8750dc7eb20b45b7faf80f83ac','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544665,0),(11,'c614d85513c0859586bb31c520ca2d97','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544670,1),(12,'ee1c7ed3c621c3c5939ab6f810707355','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544741,1),(12,'a8963c8b1d088e22d6cc4547bd350aea','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544894,1),(12,'c584bb81e644e532f44f686a9b134aea','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544899,1),(12,'071061e8ced6aaa9c243117a8eb404cc','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544904,1),(12,'97bf10766e2057c38b96f2e8884cd7ef','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544908,1),(12,'3f8d086477dbaaad2cd385f80e261083','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544913,1),(12,'3e40bd1a1ea45897a5766e9d6fa37039','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543544919,1),(13,'d5a0482bf070610d2170d0bba31e9055','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543547285,1),(13,'de12e6a71e630e0122407266bc884b3f','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549165,1),(13,'5cfd9b1ed75f895ff79f19f3269bbce0','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549237,1),(13,'2431cfd27df54b7142e343d4e05d9935','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549446,1),(13,'1791088ffc9a46568cfc881608c88e8d','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549452,1),(13,'6c20d7bf17afdce70ef91e415c8f799d','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549473,1),(13,'8e0fd9c93bcaa1434c416a0e1d2914bd','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549491,1),(13,'6e59304dfc39b1db8a56e4660057f7bf','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549728,1),(13,'23811f01006a64752cbfe4e18bac9894','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543549737,1),(4,'a9d89b31fd0809658afe92385efb0208','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36','::1',1543554965,0);
/*!40000 ALTER TABLE `ActiveTokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Books`
--

DROP TABLE IF EXISTS `Books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `author` varchar(300) DEFAULT NULL,
  `synopsis` varchar(300) DEFAULT NULL,
  `rating` float DEFAULT '0',
  `vote` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Books`
--

LOCK TABLES `Books` WRITE;
/*!40000 ALTER TABLE `Books` DISABLE KEYS */;
INSERT INTO `Books` VALUES (1,'The Communist Manifesto','Karl Marx','The Communist Manifesto is divided into a preamble and four sections, the last of these a short conclusion.',0,0),(2,'The Cold War: A New History','John Lewis Gaddis','The dean of Cold War historians (The New York Times) now presents the definitive account of the global confrontation that dominated the last half of the twentieth century.',0,0),(3,'Cebong vs Onta : Cebong','Goksjer Zali','This books is recommended for you who does not have a choice yet for Indonesia President and want to know more about Mr. Joko Widodo',0,0),(4,'Cebong vs Onta : Onta','Goksjer Zali','This books is recommended for you who does not have a choice yet for Indonesia President and want to know more about Mr. Prabowo Subianto',0,0),(5,'What Makes Indonesia Left Behind','Setya Novanto','A story from the criminal point of view Mr. Setya Novanto, who want to share about the reason why Indonesia left behind from other developed countries such as malaysia, saudi arabia, etc.',0,0),(6,'How I Steal People\'s Money On Indonesia','Setya Novanto','A story from the criminal point of view Mr. Setya Novanto, who want to share about how he become a rich man by stealing Indonesia Money using his power as the head of Indonesia Parlement.',0,0),(7,'How I Create The Biggest Hoax in Indonesia','Ratna Sarumpaaet','This is a story from Ratna Sarumpaet, who got kicked from Prabowo Subianto team because of her biggest hoax in Indonesia.',0,0),(8,'Why I Destroy WTC Tower','Osama Bin Laden','A book about the story of Osama Bin Laden on his way to become the most notorius terrorist in the world by hijacking three american airplane and crash it to the WTC Tower and Pentagon.',0,0),(9,'Guide To Assassinate Arab Journalist','Kingdom of Saudi Arabia','This is a book about assassination plan developed by the Kingdom of Saudi Arabia. They had assassinate their opposition journalist effectively on October 2018.',0,0),(10,'Pretending to Know About Stuff','The Practical Dev','The Practical Dev will tell you about how to pretend to know about stuff to your job interviewer so you can be the king of con-man and tackle your job interview.',0,0),(11,'The Ideological Origins Of Nazi Imperialism','Woodruff D. Smith','This is the end of liberalism era!!. This book will tell you how Nazi Imperialism ideology on 1900s has almost win the World War and How to implement it on this era.',5,1),(12,'Googling the Error Message','The Practical Dev','The Practical Dev will tell you about how to googling your error message,',0,0);
/*!40000 ALTER TABLE `Books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `is_review` tinyint(1) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `order_timestamp` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Orders`
--

LOCK TABLES `Orders` WRITE;
/*!40000 ALTER TABLE `Orders` DISABLE KEYS */;
INSERT INTO `Orders` VALUES (1,1,0,1,4,1540460068),(2,1,1,11,3,1540460087);
/*!40000 ALTER TABLE `Orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reviews`
--

DROP TABLE IF EXISTS `Reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` float DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `username` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reviews`
--

LOCK TABLES `Reviews` WRITE;
/*!40000 ALTER TABLE `Reviews` DISABLE KEYS */;
INSERT INTO `Reviews` VALUES (1,5,'This book has open my mind!! World Governments need to change their country\'s ideology to Nazi Imperialism!! HEIL HITLER!! Aufa Fuhrer!! Leben von Aufa, Make Aufa ist ein Vorbild, Aufa ist Konig',11,'misterjoko',1);
/*!40000 ALTER TABLE `Reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(255) DEFAULT NULL,
  `cardnumber` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Koko Widodo','misterjoko','2019tetapjokowi@indonesia.com','adbf245ec953b6ba5a29d600a12e4e3c','Rumah Kaesang, Istana Presiden, Jakarta','08169696969','4716717075371688'),(2,'Rachel Park','kimmiso','kimmiso@seoulentertainment.com','e7750d4a7fd4c70f46c6da28900df35e','DG Enterprise 105, Seoul, South Korea','081395954095','4485012043330381'),(4,'Aldo Azaloss','aldoazaloss','aldoloss@skip.com','794edcec3964982758a23fa88adac396','Jalan jalan','098123098123','4126795473513873'),(13,'Faza Fahleraz','ffahleraz','ffahleraz@gmail.com','6a204bd89f3c8348afd5c77c717a097a','Somewhere','123123123123','4485012043330381');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-29 19:37:33
