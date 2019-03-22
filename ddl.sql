-- MySQL dump 10.16  Distrib 10.1.25-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: piu_3
-- ------------------------------------------------------
-- Server version	10.1.25-MariaDB

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
-- Table structure for table `access_folder`
--

DROP TABLE IF EXISTS `access_folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_folder` (
  `id_access_folder` int(11) NOT NULL AUTO_INCREMENT,
  `id_folder` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `download_permission` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_access_folder`),
  KEY `access_folder_users_fk` (`id_user`),
  KEY `access_folder_folder_id_folder_fk` (`id_folder`),
  CONSTRAINT `access_folder_folder_id_folder_fk` FOREIGN KEY (`id_folder`) REFERENCES `folder` (`id_folder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `access_folder_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_folder`
--

LOCK TABLES `access_folder` WRITE;
/*!40000 ALTER TABLE `access_folder` DISABLE KEYS */;
INSERT INTO `access_folder` VALUES (1,8,2,'0'),(2,11,2,'0');
/*!40000 ALTER TABLE `access_folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `access_logbook`
--

DROP TABLE IF EXISTS `access_logbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_logbook` (
  `id_access_lb` int(11) NOT NULL AUTO_INCREMENT,
  `id_logbook` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_access_lb`),
  KEY `access_logbook_users_fk` (`id_user`),
  KEY `access_logbook_logbook_fk` (`id_logbook`),
  CONSTRAINT `access_logbook_logbook_fk` FOREIGN KEY (`id_logbook`) REFERENCES `logbook` (`id_logbook`) ON UPDATE CASCADE,
  CONSTRAINT `access_logbook_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_logbook`
--

LOCK TABLES `access_logbook` WRITE;
/*!40000 ALTER TABLE `access_logbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_logbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment` (
  `id_attach` int(11) NOT NULL AUTO_INCREMENT,
  `attach_name` int(11) NOT NULL,
  `id_logbook` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_attach`),
  KEY `attachment_logbook_fk` (`id_logbook`),
  CONSTRAINT `attachment_logbook_fk` FOREIGN KEY (`id_logbook`) REFERENCES `logbook` (`id_logbook`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachment`
--

LOCK TABLES `attachment` WRITE;
/*!40000 ALTER TABLE `attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_kegiatan`
--

DROP TABLE IF EXISTS `detail_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_kegiatan` (
  `id_detail_kegiatan` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `detail_kegiatan_name` varchar(191) NOT NULL,
  `plan_start` datetime NOT NULL,
  `plan_finish` datetime NOT NULL,
  `actual_start` datetime NOT NULL,
  `actual_finish` datetime NOT NULL,
  `status` varchar(191) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(10) unsigned NOT NULL,
  `id_subkegiatan` int(10) unsigned NOT NULL,
  `id_jenis_lelang` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_detail_kegiatan`),
  KEY `detail_kegiatan_users_fk` (`id_user`),
  KEY `detail_kegiatan_subkegiatan_fk` (`id_subkegiatan`),
  KEY `detail_kegiatan_jenis_lelang_fk` (`id_jenis_lelang`),
  CONSTRAINT `detail_kegiatan_jenis_lelang_fk` FOREIGN KEY (`id_jenis_lelang`) REFERENCES `jenis_lelang` (`id_jenis_lelang`) ON UPDATE CASCADE,
  CONSTRAINT `detail_kegiatan_subkegiatan_fk` FOREIGN KEY (`id_subkegiatan`) REFERENCES `subkegiatan` (`id_subkegiatan`) ON UPDATE CASCADE,
  CONSTRAINT `detail_kegiatan_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_kegiatan`
--

LOCK TABLES `detail_kegiatan` WRITE;
/*!40000 ALTER TABLE `detail_kegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id_doc` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doc_name` varchar(191) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_folder` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `id_subkegiatan` int(10) unsigned DEFAULT NULL,
  `extension` varchar(15) NOT NULL,
  PRIMARY KEY (`id_doc`),
  KEY `documents_users_fk` (`id_user`),
  KEY `documents_subkegiatan_fk` (`id_subkegiatan`),
  KEY `documents_folder_fk` (`id_folder`),
  CONSTRAINT `documents_folder_fk` FOREIGN KEY (`id_folder`) REFERENCES `folder` (`id_folder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `documents_subkegiatan_fk` FOREIGN KEY (`id_subkegiatan`) REFERENCES `subkegiatan` (`id_subkegiatan`) ON UPDATE CASCADE,
  CONSTRAINT `documents_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (41,'0401927001248342481_contoh.pdf','2018-12-27 09:27:04',5,1,NULL,'.pdf'),(42,'UU 19 Tahun 2016.pdf','2018-12-27 09:27:04',5,1,NULL,'.pdf');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `id_folder` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(191) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `parent` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_folder`),
  KEY `folder_users_fk` (`id_user`),
  KEY `folder_folder_id_folder_fk` (`parent`),
  CONSTRAINT `folder_folder_id_folder_fk` FOREIGN KEY (`parent`) REFERENCES `folder` (`id_folder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `folder_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder`
--

LOCK TABLES `folder` WRITE;
/*!40000 ALTER TABLE `folder` DISABLE KEYS */;
INSERT INTO `folder` VALUES (0,'root','2018-12-21 10:38:52',0,1,'2018-12-21 03:38:50'),(1,'dokumentasi','2018-12-22 08:22:43',0,1,NULL),(5,'sub1','2018-12-21 10:37:47',0,1,NULL),(6,'Keuangan','2018-12-21 08:42:58',0,1,NULL),(8,'lorem ipsum 2','2018-12-21 10:37:49',0,1,NULL),(9,'lorem ipsum 2','2018-12-22 07:55:07',8,1,NULL),(10,'lorem ipsum 2','2018-12-22 07:55:14',8,1,NULL),(11,'lorem ipsum','2018-12-27 07:55:01',5,1,NULL),(12,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin in blandit justo. Fusce pharetra,','2018-12-27 08:07:24',5,1,NULL);
/*!40000 ALTER TABLE `folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_lelang`
--

DROP TABLE IF EXISTS `jenis_lelang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_lelang` (
  `id_jenis_lelang` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jenis_lelang_name` varchar(191) NOT NULL,
  PRIMARY KEY (`id_jenis_lelang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_lelang`
--

LOCK TABLES `jenis_lelang` WRITE;
/*!40000 ALTER TABLE `jenis_lelang` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_lelang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kegiatan` (
  `id_kegiatan` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kegiatan_name` varchar(191) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_kegiatan`),
  KEY `kegiatan_users_fk` (`id_user`),
  CONSTRAINT `kegiatan_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `new` text,
  `id_user` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_users_fk` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (153,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(154,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(155,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(156,'::1','TRY LOGIN','FAILED','{\"id\":\"administar\",\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(157,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(158,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(159,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(160,'::1','TRY LOGIN','FAILED','{\"id\":\"administrator1\",\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(161,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(162,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(163,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(164,'::1','TRY LOGIN','FAILED','{\"id\":\"admin2\",\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(165,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(166,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(167,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(168,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(169,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(170,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(171,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(172,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(173,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(174,'::1','TRY LOGIN','FAILED','{\"id\":\"keuangan1@keuangan.com\",\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(175,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(176,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":\"Username atau password salah\"}}',0),(177,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(178,'::1','TRY LOGIN','SUCCESS','{\"id\":\"keuangan1@keuangan.com\",\"password\":\"password\"}',2),(179,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(180,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(181,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(182,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(183,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(184,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(185,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(186,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(187,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(188,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(189,'::1','ACCESS LOGIN PAGE',NULL,NULL,1),(190,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',1),(191,'::1','ACCESS LOGIN PAGE',NULL,NULL,1),(192,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(193,'::1','ACCESS LOGIN PAGE',NULL,NULL,1),(194,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',1),(195,'::1','ACCESS LOGIN PAGE',NULL,NULL,1),(196,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',1),(197,'::1','ACCESS LOGIN PAGE',NULL,NULL,1),(198,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(199,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(200,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(201,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(202,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(203,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(204,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(205,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(206,'::1','TRY LOGIN','SUCCESS','{\"id\":\"keuangan1@keuangan.com\",\"password\":\"password\"}',2),(207,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(208,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(209,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(210,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1),(211,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(212,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(213,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(214,'::1','TRY LOGIN','FAILED','{\"id\":null,\"password\":\"password\",\"0\":{\"message\":null}}',0),(215,'::1','ACCESS LOGIN PAGE',NULL,NULL,0),(216,'::1','TRY LOGIN','SUCCESS','{\"id\":\"admin@admin.com\",\"password\":\"password\"}',1);
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logbook`
--

DROP TABLE IF EXISTS `logbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logbook` (
  `id_logbook` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logbook_name` varchar(191) NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `access_date` datetime NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_logbook`),
  KEY `logbook_users_fk` (`id_user`),
  CONSTRAINT `logbook_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logbook`
--

LOCK TABLES `logbook` WRITE;
/*!40000 ALTER TABLE `logbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `logbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subkegiatan`
--

DROP TABLE IF EXISTS `subkegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subkegiatan` (
  `id_subkegiatan` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subkegiatan_name` varchar(191) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(191) NOT NULL,
  PRIMARY KEY (`id_subkegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subkegiatan`
--

LOCK TABLES `subkegiatan` WRITE;
/*!40000 ALTER TABLE `subkegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `subkegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sumber_dana`
--

DROP TABLE IF EXISTS `sumber_dana`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sumber_dana` (
  `id_dana` int(11) NOT NULL AUTO_INCREMENT,
  `dana_name` varchar(191) NOT NULL,
  PRIMARY KEY (`id_dana`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sumber_dana`
--

LOCK TABLES `sumber_dana` WRITE;
/*!40000 ALTER TABLE `sumber_dana` DISABLE KEYS */;
/*!40000 ALTER TABLE `sumber_dana` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `type` varchar(191) CHARACTER SET latin1 NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','admin','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,NULL,NULL,1268889823,1545907344,1,'Admin','istrator','ADMIN','0',NULL),(2,'','non admin','keuangan1','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',NULL,'keuangan1@keuangan.com',NULL,NULL,NULL,NULL,0,1545896460,1,'Agus','Susilo',NULL,NULL,NULL),(3,'','non admin','keuangan2','',NULL,'keuangan2@keuangan.com',NULL,NULL,NULL,NULL,0,NULL,NULL,'Adi','Subagyo',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `v_folder_documents`
--

DROP TABLE IF EXISTS `v_folder_documents`;
/*!50001 DROP VIEW IF EXISTS `v_folder_documents`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_folder_documents` (
  `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `create_date` tinyint NOT NULL,
  `parent` tinyint NOT NULL,
  `id_user` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `deleted_at` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `v_folder_documents`
--

/*!50001 DROP TABLE IF EXISTS `v_folder_documents`*/;
/*!50001 DROP VIEW IF EXISTS `v_folder_documents`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_folder_documents` AS select `folder`.`id_folder` AS `id`,`folder`.`folder_name` AS `name`,`folder`.`create_date` AS `create_date`,`folder`.`parent` AS `parent`,`folder`.`id_user` AS `id_user`,'folder' AS `type`,`folder`.`deleted_at` AS `deleted_at` from `folder` union select `documents`.`id_doc` AS `id`,`documents`.`doc_name` AS `name`,`documents`.`upload_date` AS `create_date`,`documents`.`id_folder` AS `parent`,`documents`.`id_user` AS `id_user`,'document' AS `type`,NULL AS `deleted_at` from `documents` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-02 10:33:01
