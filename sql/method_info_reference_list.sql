-- MySQL dump 10.13  Distrib 5.6.21, for Win64 (x86_64)
--
-- Host: localhost    Database: saswo_test
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `method_info_reference_list`
--

DROP TABLE IF EXISTS `method_info_reference_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `method_info_reference_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_infos_id` int(10) unsigned DEFAULT NULL,
  `reference_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `method_info_reference_list`
--

LOCK TABLES `method_info_reference_list` WRITE;
/*!40000 ALTER TABLE `method_info_reference_list` DISABLE KEYS */;
INSERT INTO `method_info_reference_list` VALUES (1,581,1),(2,581,2),(3,581,3),(4,581,4),(5,581,5),(6,581,6),(7,581,8),(8,581,9),(9,582,1),(10,582,2),(11,582,3),(12,582,4),(13,582,5),(14,582,6),(15,582,8),(16,582,9),(17,583,1),(18,583,2),(19,583,3),(20,583,4),(21,583,5),(22,583,6),(23,583,8),(24,583,9),(25,583,11),(26,584,1),(27,584,2),(28,584,3),(29,584,4),(30,584,5),(31,584,6),(32,584,8),(33,584,9),(34,585,1),(35,585,2),(36,585,3),(37,585,4),(38,585,5),(39,585,6),(40,585,8),(41,585,9),(42,585,11),(43,586,1),(44,586,2),(45,586,3),(46,586,4),(47,586,5),(48,586,6),(49,586,8),(50,586,9),(51,587,1),(52,587,2),(53,587,3),(54,587,4),(55,587,5),(56,587,6),(57,587,8),(58,587,9),(59,587,11),(60,588,1),(61,588,2),(62,588,3),(63,588,4),(64,588,5),(65,588,6),(66,588,8),(67,588,9),(68,589,1),(69,589,2),(70,589,3),(71,589,4),(72,589,5),(73,589,6),(74,589,8),(75,589,9),(76,590,1),(77,590,2),(78,590,3),(79,590,4),(80,590,5),(81,590,6),(82,590,8),(83,590,9),(84,591,1),(85,591,2),(86,591,3),(87,591,4),(88,591,5),(89,591,6),(90,591,8),(91,591,9),(92,591,10),(93,591,11),(94,591,12),(95,592,1),(96,592,2),(97,592,3),(98,592,4),(99,592,9),(100,593,1),(101,593,2),(102,593,3),(103,593,4),(104,593,5),(105,593,6),(106,593,8),(107,593,9),(108,593,10),(109,593,11),(110,593,12),(111,594,1),(112,594,2),(113,594,3),(114,594,4),(115,594,5),(116,594,6),(117,594,8),(118,594,9),(119,595,1),(120,595,2),(121,595,3),(122,595,4),(123,595,5),(124,595,6),(125,595,8),(126,595,9),(127,595,10),(128,595,11),(129,595,12),(130,596,1),(131,596,2),(132,596,3),(133,596,4),(134,596,5),(135,596,6),(136,596,8),(137,596,9),(138,596,13),(139,597,1),(140,597,2),(141,597,3),(142,597,4),(143,597,5),(144,597,6),(145,597,9),(146,598,1),(147,598,2),(148,598,3),(149,598,4),(150,598,5),(151,598,9),(152,598,11),(153,599,1),(154,599,2),(155,599,3),(156,599,4),(157,600,1),(158,600,2),(159,600,3),(160,600,4),(161,600,5),(162,600,6),(163,600,9),(164,601,1),(165,601,2),(166,601,3),(167,601,4),(168,601,5),(169,601,6),(170,601,9),(171,601,11),(172,602,1),(173,602,2),(174,602,3),(175,602,4),(176,602,5),(177,602,6),(178,602,9),(179,602,11);
/*!40000 ALTER TABLE `method_info_reference_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-05 13:52:22