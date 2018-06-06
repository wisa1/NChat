CREATE SCHEMA IF NOT EXISTS `fh_2018_scm4_s1610307026` DEFAULT CHARACTER SET latin1 ;
USE `fh_2018_scm4_s1610307026` ;

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
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `lastActivity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels`
--

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` VALUES (1,'Technisches','Technisches zu NChat',0),(2,'Allgemeins','Allgemeines zu NChat',0);
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channels_users`
--

DROP TABLE IF EXISTS `channels_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels_users` (
  `id_channel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_channel`,`id_user`),
  KEY `fk_users_idx` (`id_user`),
  CONSTRAINT `fk_channels` FOREIGN KEY (`id_channel`) REFERENCES `channels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels_users`
--

LOCK TABLES `channels_users` WRITE;
/*!40000 ALTER TABLE `channels_users` DISABLE KEYS */;
INSERT INTO `channels_users` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `channels_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_channel` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idposts_UNIQUE` (`id`),
  KEY `fk_users_idx` (`id_user`),
  KEY `fk_channels_idx` (`id_channel`),
  CONSTRAINT `posts_fk_channels` FOREIGN KEY (`id_channel`) REFERENCES `channels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `posts_fk_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,1,'Titel des ersten Posts','Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',0),(2,1,1,'Titel des 2. Posts','Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.',1),(3,1,1,'test','test',1),(4,1,1,'aaa','dsdds',1),(7,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(8,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(9,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(10,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(11,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(12,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(13,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(14,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(15,1,1,'Wahnsinn, es scheint zu funktionieren','bitte funktioniert jetzt auch das einfügen',1),(16,1,1,'ok - einfügen ! ','gogogogog',1),(17,1,1,'ok -- numoi','auf gehts ',1),(18,1,1,'Editier-Test','Hallo, dieser Text soll bearbeitet werden! haaaaaa xdxdcd \n&lt;button&gt; ha&ouml;ldkfja&ouml;lsdkfj &lt;/button&gt; ',0),(19,1,1,'Editier-Test','najao daun schauma moi &lt;button&gt; a&ouml;sdlkfj&ouml; &lt;/button&gt;',1),(20,1,1,'L&ouml;schen-Test','Text der gleich wieder gel&ouml;scht wird',1),(21,1,1,'Edit-Text','text, der gleich editiert wird , super geil',1);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_users`
--

DROP TABLE IF EXISTS `posts_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_users` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `important` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_post`,`id_user`),
  KEY `posts_users_fk_users_idx` (`id_user`),
  CONSTRAINT `posts_users_fk_posts` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `posts_users_fk_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_users`
--

LOCK TABLES `posts_users` WRITE;
/*!40000 ALTER TABLE `posts_users` DISABLE KEYS */;
INSERT INTO `posts_users` VALUES (1,1,1);
/*!40000 ALTER TABLE `posts_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(45) CHARACTER SET latin1 NOT NULL,
  `passwordHash` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `countryId` int(11) DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `userName_UNIQUE` (`userName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Wisa','02c08649ca46c1b051378194f72b9172a5aa7d87',NULL,'11111');
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

-- Dump completed on 2018-06-04 19:54:01
