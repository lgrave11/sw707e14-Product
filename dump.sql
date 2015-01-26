-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bicycle-db
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Dumping data for table `historyusagebicycle`
--

LOCK TABLES `historyusagebicycle` WRITE;
/*!40000 ALTER TABLE `historyusagebicycle` DISABLE KEYS */;
INSERT INTO `historyusagebicycle` VALUES (1,140,21,1386586923,13,1386590523,11),(2,96,11,213930760,16,213934360,12),(3,10,8,1147210051,9,1147213651,10),(4,39,13,1060319794,4,1060323394,10),(5,138,2,1003749569,14,1003753169,10),(6,8,4,1353718115,21,1353721715,10),(7,76,5,100089866,4,100093466,10),(8,125,7,924903378,15,924906978,10),(9,43,4,431332458,5,431336058,10),(10,52,19,309863138,9,309866738,10),(11,146,5,1277955142,7,1277958742,10),(12,124,18,1170812428,18,1170816028,10),(13,149,21,398079074,13,398082674,10),(14,70,15,1359314854,1,1359318454,10),(15,74,14,1335422668,6,1335426268,10),(16,129,12,330568356,14,330571956,10),(17,117,13,678140194,4,678143794,10),(18,31,3,1024314564,11,1024318164,10),(19,62,9,365839295,21,365842895,10),(20,21,5,925093415,14,925097015,10),(21,132,20,530974844,9,530978444,10),(22,127,1,311723269,15,311726869,10),(23,131,20,1113292258,19,1113295858,10),(24,3,6,1178678772,21,1178682372,10),(25,21,13,1005602977,19,1005606577,10),(26,101,13,1401481070,10,1401484670,10),(27,48,11,460018312,11,460021912,10),(28,105,15,88805735,7,88809335,10),(29,1,5,1002738178,18,1002741778,10),(30,45,9,136469990,3,136473590,10),(31,117,13,303862340,17,303865940,10),(32,121,12,151586414,14,151590014,10),(33,42,3,1315371504,6,1315375104,10),(34,99,17,1201124647,8,1201128247,10),(35,89,8,497478580,9,497482180,10),(36,67,3,1163802960,21,1163806560,10),(37,83,9,210844505,4,210848105,10),(38,103,17,418724273,6,418727873,10),(39,50,14,804287044,1,804290644,10),(40,49,19,714225062,2,714228662,10),(41,100,6,609872833,7,609876433,10),(42,87,11,442847355,11,442850955,10),(43,37,21,569277063,12,569280663,10),(44,147,20,228608083,13,228611683,10),(45,57,1,1176344589,20,1176348189,10),(46,139,19,156568712,17,156572312,10),(47,63,15,387059653,14,387063253,10),(48,31,2,169477454,16,169481054,10),(49,14,17,928011890,15,928015490,10),(50,139,20,1286540782,9,1286544382,10),(51,36,5,110002556,7,110006156,10),(52,48,17,968398461,9,968402061,10),(53,67,18,1244990557,20,1244994157,10),(54,9,7,935605368,10,935608968,10),(55,69,19,840393993,8,840397593,10),(56,42,2,432200281,16,432203881,10),(57,49,14,1414391017,13,1414394617,10),(58,113,14,1303629115,15,1303632715,10),(59,33,10,418046350,7,418049950,10),(60,91,11,1228438740,3,1228442340,10),(61,62,18,846266867,19,846270467,10),(62,67,11,971848404,21,971852004,10),(63,22,20,962456452,9,962460052,10),(64,86,8,505264781,9,505268381,10),(65,56,12,1055256492,21,1055260092,10),(66,56,6,492812106,8,492815706,10),(67,144,7,629227887,18,629231487,10),(68,10,18,786745828,16,786749428,10),(69,145,19,768187226,18,768190826,10),(70,22,13,736367342,3,736370942,10),(71,118,12,132262820,2,132266420,10),(72,103,10,407511754,19,407515354,10),(73,94,1,906861564,9,906865164,10),(74,25,13,1271146940,2,1271150540,10),(75,93,6,202442911,5,202446511,10),(76,60,19,272597604,11,272601204,10),(77,72,21,1072740714,3,1072744314,10),(78,144,20,1314796767,19,1314800367,10),(79,58,11,1375850602,9,1375854202,10),(80,76,21,1229522785,13,1229526385,10),(81,8,8,226556413,8,226560013,10),(82,43,4,701091421,17,701095021,10),(83,21,9,1211607412,2,1211611012,10),(84,119,10,1399560608,3,1399564208,10),(85,1,7,426208802,14,426212402,10),(86,113,1,411821584,12,411825184,10),(87,100,14,682090202,4,682093802,10),(88,57,3,370929122,5,370932722,10),(89,95,21,1121781957,13,1121785557,10),(90,113,3,400752868,7,400756468,10),(91,12,3,247975703,20,247979303,10),(92,36,16,1310836611,11,1310840211,10),(93,112,18,792611526,3,792615126,10),(94,89,21,1150521224,19,1150524824,10),(95,16,17,770038054,10,770041654,10),(96,78,4,1033935963,10,1033939563,10),(97,136,17,1075331508,18,1075335108,10),(98,6,16,85154453,15,85158053,10),(99,131,9,838478845,19,838482445,10),(100,81,7,879025384,18,879028984,10),(101,1,1,1417688175,NULL,NULL,NULL),(102,2,7,1417688178,1,1422198478,NULL),(103,3,1,1417688181,2,1422198548,NULL),(104,4,1,1417688185,NULL,NULL,NULL),(105,5,3,1417688192,1,1422198472,NULL),(106,6,13,1417688195,4,1422198583,NULL),(107,155,1,1417688199,NULL,NULL,NULL),(108,148,2,1417688208,1,1422199251,NULL),(109,133,1,1417688211,NULL,NULL,NULL),(110,152,14,1417688222,5,1417688261,NULL),(111,111,1,1417688224,1,1422198194,NULL),(112,136,1,1417688231,NULL,NULL,NULL),(113,160,1,1417688237,NULL,NULL,NULL),(114,139,1,1417688243,2,1422198480,NULL),(115,178,1,1417688248,NULL,NULL,NULL),(116,117,1,1417688255,10,1422198476,NULL),(117,127,1,1422198191,8,1422198522,NULL),(118,8,2,1422198301,NULL,NULL,NULL),(119,7,2,1422198304,NULL,NULL,NULL),(120,11,2,1422198308,1,1422198453,NULL),(121,109,2,1422198342,NULL,NULL,NULL),(122,12,2,1422198347,12,1422198427,NULL),(123,10,2,1422198353,NULL,NULL,NULL),(124,9,2,1422198386,NULL,NULL,NULL),(125,174,2,1422198393,NULL,NULL,NULL),(126,132,1,1422198435,NULL,NULL,NULL),(127,120,1,1422198440,NULL,NULL,NULL),(128,165,6,1422198446,1,1422198533,NULL),(129,152,4,1422198449,17,1422198550,NULL),(130,11,4,1422198455,15,1422198619,NULL),(131,151,1,1422198460,NULL,NULL,NULL),(132,140,1,1422198471,NULL,NULL,NULL),(133,5,1,1422198473,NULL,NULL,NULL),(134,139,1,1422198516,NULL,NULL,NULL),(135,176,2,1422198521,2,1422198578,NULL),(136,127,1,1422198524,NULL,NULL,NULL),(137,2,1,1422198528,NULL,NULL,NULL),(138,125,1,1422198540,NULL,NULL,NULL),(139,130,1,1422198544,NULL,NULL,NULL),(140,152,1,1422198552,NULL,NULL,NULL),(141,119,1,1422198560,NULL,NULL,NULL),(142,142,1,1422198600,NULL,NULL,NULL),(143,143,1,1422198603,NULL,NULL,NULL),(144,129,1,1422198606,NULL,NULL,NULL),(145,173,1,1422198609,1,1422198615,NULL),(146,167,1,1422198611,NULL,NULL,NULL),(147,6,1,1422198614,NULL,NULL,NULL),(148,11,1,1422198621,NULL,NULL,NULL),(149,165,1,1422198627,NULL,NULL,NULL),(150,113,1,1422198788,NULL,NULL,NULL),(151,117,1,1422198791,NULL,NULL,NULL),(152,141,1,1422198796,NULL,NULL,NULL),(153,173,1,1422199257,NULL,NULL,NULL),(154,3,1,1422199262,NULL,NULL,NULL),(155,164,1,1422199270,NULL,NULL,NULL);
/*!40000 ALTER TABLE `historyusagebicycle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-26  8:21:40