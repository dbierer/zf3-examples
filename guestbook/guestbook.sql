-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: guestbook
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `attendee`
--

DROP TABLE IF EXISTS `attendee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `name_on_ticket` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendee`
--

LOCK TABLES `attendee` WRITE;
/*!40000 ALTER TABLE `attendee` DISABLE KEYS */;
INSERT INTO `attendee` VALUES (1,1,'Clark Senior'),(2,1,'Clark Junior'),(3,2,'Matthew'),(4,2,'Ralph'),(5,2,'Enrico'),(6,2,'Slavey'),(7,3,'Doug'),(8,3,'Siri'),(9,6,'Lada'),(10,6,'Tongsoi'),(11,6,'Saleen'),(12,7,'Milo'),(13,7,'Tami');
/*!40000 ALTER TABLE `attendee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `max_attendees` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'Event A',25,'2013-10-01 00:00:00'),(2,'Event B',150,'2013-12-12 00:00:00');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `avatar` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guestbook`
--

LOCK TABLES `guestbook` WRITE;
/*!40000 ALTER TABLE `guestbook` DISABLE KEYS */;
INSERT INTO `guestbook` VALUES (1,'Doug','doug@unlikelysource.com','http://www.unlikelysource.com/','Test test test',NULL),(2,'Fred','fred@unlikelysource.com','http://flintstones.com/','Test Test Test',NULL),(3,'Fred','fred@unlikelysource.com','http://flintstones.com/','Test Test Test',NULL),(4,'Fred','fred@unlikelysource.com','http://flintstones.com/','Test','avatar_59898262628821_64720025.png');
/*!40000 ALTER TABLE `guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `message` varchar(254) NOT NULL,
  `to_email` varchar(254) NOT NULL DEFAULT '',
  `from_email` varchar(254) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (9,'9S8ql/mlLzlf+rIM+2ipzP6H1XI6tdIPL/d8I3hxBT5tHzPzJevauh4fsTEsMIPigJoVZ6YjCyj7y04h','daryl@zend.com','doug@unlikelysource.com'),(10,'3Hp7qhmyqj7N8vApCjFwilL+/CFW/7YDobxVTH/R26Cd9ufj1AMlyIUGV8Q=','doug@unlikelysource.com','daryl@zend.com'),(11,'Gc+q3lRB+MWc8ikaNoLoYtYY1lLLjObdMaFDd39/JN9e8QnGx4jtZZk8Drfv5ynCukVJYTC3CZmi48ai','doug@unlikelysource.com','daryl@zend.com'),(12,'rqDUiGZA3ot4aoeG9Uo70UNiTcuzQeT0hffo+DI0U72cKi+i1DYgNEREcCLXMstIEa2Ud+LCtPquU5mJ','doug@unlikelysource.com','daryl@zend.com'),(13,'XDo7ic0n6LkbkvjuSK+RvetC6kM8z7lkskchb0IqgT3K3HrUgcY+oovxUZOnNUa2xYViAp11YSZ6/1kBj0ZzeC2NvkFCYYXGUzxXJW1M0N91vxLZ3dwuDT6YGeseRiM6P80Wd76Mr25y2krel4XmR0rP7JBqIIYrxP73cPj4rLmWD33OMI6LhWhfJnk=','daryl@zend.com','doug@unlikelysource.com');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `registration_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES (1,1,'Clark','Everetts','2013-06-06 13:51:10'),(2,2,'Matthew','Weir O\'Phinney','2013-06-06 13:52:03'),(3,1,'Doug','Bierer','2015-09-02 18:03:55'),(4,1,'Doug','Bierer','2017-08-10 10:16:40'),(5,1,'Doug','Bierer','2017-08-10 10:18:31'),(6,1,'Doug','Bierer','2017-08-10 10:19:42'),(7,2,'Siri','Jamikorn','2017-08-10 10:23:44');
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(254) NOT NULL,
  `security_question` varchar(254) DEFAULT NULL,
  `security_answer` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'md5@zend.com','md5','5f4dcc3b5aa765d61d8327deb882cf99','What is the name of your number one dog?','Lada'),(2,'bcrypt@zend.com','bcrypt','$2y$10$zMGB5TT9fp38hJUhTF5dTeygKG4Z7QENGioJdujX/O9wzNF8GPwIm','What is the name of your number two dog?','Tongsoi'),(3,'doug@unlikelysource.com','doug','$2y$10$eFpYKtvtbe8wqSCk5mDLke.5n7jr2tQ1ILV48VaWbHxULxwYsal7e','How many dogs do you have?','5'),(4,'daryl@zend.com','daryl','$2y$10$Gy8fTpy1K.0Hy1iCf4S6ee5z0Hi6GUARoDHwnAf8EKIRA.XrRLIma','What is your favorite sport?','Kayaking');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'zff_ii'
--

--
-- Dumping routines for database 'zff_ii'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-21 10:44:47
