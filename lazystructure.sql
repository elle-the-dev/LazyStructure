-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: lazystructure
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.8

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
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `heading` varchar(100) DEFAULT NULL,
  `content` longtext,
  `editable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Home','Welcome','    <p class=\"info\">Welcome to the <strong>LazyStructure</strong> system.<br></p>\r\n<p style=\"margin-left:40px;\"><em>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis suscipit tellus. Cras ligula mi, gravida ac consectetur eget, venenatis sed turpis. Pellentesque id massa ut ipsum eleifend dignissim non ac massa. Duis nec nibh velit. Aliquam erat volutpat. In id turpis at sapien viverra pellentesque non in odio. Nulla aliquam fermentum congue. Nulla facilisi. Suspendisse porta pellentesque eros. Cras in risus nisi. Nam fermentum neque aliquam ante varius vitae tincidunt neque tempor. Sed vulputate, nunc non lacinia consequat, nisi eros condimentum risus, vitae porta magna arcu quis tellus. Donec ac diam at magna ullamcorper facilisis nec vel elit. Quisque sapien enim, blandit id vestibulum non, luctus rutrum nulla. Donec lorem elit, ultrices eget placerat et, iaculis in magna. Proin id nunc diam, at dignissim dolor. Maecenas eu sapien eget dolor tempor volutpat a et elit. Etiam vel ipsum erat, ut fermentum tellus. Quisque sollicitudin pretium massa id sagittis.</font></span></em></p>\r\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam dolor sapien, faucibus ut tempor quis, dapibus a risus. Nam fermentum sapien quis nunc semper vulputate pharetra in purus. Maecenas accumsan iaculis dolor, quis ultrices erat viverra quis. Pellentesque sollicitudin posuere semper. Duis tincidunt eros non nunc euismod consequat. Cras cursus ante eu odio congue sollicitudin. Vivamus at ipsum eu lacus gravida auctor sit amet suscipit elit. Quisque luctus semper felis in euismod. Quisque dolor odio, interdum vel placerat lacinia, pellentesque quis nulla. Curabitur volutpat pellentesque nisi, eget consequat ligula tempus in. Sed nunc urna, gravida et pellentesque ut, sollicitudin non lectus. Aliquam erat volutpat. Nullam eleifend auctor metus, eget dignissim tellus varius nec. Etiam urna ipsum, mattis vitae ultrices vel, molestie quis neque. Morbi nulla nisl, tincidunt a aliquam eu, sodales sed neque. Sed quis felis nec enim sodales tempor.</p>\r\n<p>Duis dui orci, ullamcorper in fermentum sit amet, imperdiet eu odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur leo nunc, semper eget consequat ac, eleifend egestas ligula. Sed adipiscing, est ut egestas cursus, mauris est bibendum nunc, sit amet interdum velit justo eget dui. Integer ornare, neque non commodo hendrerit, purus est pulvinar orci, sit amet euismod leo leo eget velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam leo lectus, fermentum eget euismod sit amet, tempor non tortor. Nullam vestibulum lobortis convallis. Nulla facilisi. Phasellus pellentesque leo posuere ante rutrum quis imperdiet neque volutpat. Fusce posuere, sapien ac tempor fermentum, felis orci volutpat metus, eu fringilla ipsum leo vel velit. Suspendisse augue quam, auctor eu ultrices sit amet, molestie et nisi. Suspendisse potenti.</p>\r\n<p>Proin ut elit ac massa imperdiet congue. Maecenas bibendum quam sit amet lorem aliquam elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce metus nunc, pellentesque ut luctus quis, elementum quis metus. Vivamus luctus nisl aliquam sapien porta vestibulum. Nullam fringilla sagittis elit ac varius. Quisque ut sem libero. Donec tristique purus vitae purus semper nec sodales lacus vestibulum. Sed sit amet lorem sapien. Etiam adipiscing ultrices purus consequat hendrerit. Fusce vehicula posuere vestibulum. Maecenas placerat massa massa, eget commodo tortor. Nullam tortor nibh, lacinia quis ultrices quis, cursus sit amet lectus. Vivamus sodales elit in ligula rutrum aliquam. Sed mattis pellentesque leo non imperdiet. Mauris gravida risus id dolor vestibulum lobortis. Donec velit tortor, porttitor in dictum ut, euismod non eros. Quisque sagittis, libero sit amet venenatis pulvinar, dui purus blandit massa, at placerat enim lorem ut eros. Morbi accumsan lacinia blandit. Proin in lorem at dolor sollicitudin auctor.</p>\r\n',1),(2,'Alpha','Alpha','<p>\r\nCum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam dolor sapien, faucibus ut tempor quis, dapibus a risus. Nam fermentum sapien quis nunc semper vulputate pharetra in purus. Maecenas accumsan iaculis dolor, quis ultrices erat viverra quis. Pellentesque sollicitudin posuere semper. Duis tincidunt eros non nunc euismod consequat. Cras cursus ante eu odio congue sollicitudin. Vivamus at ipsum eu lacus gravida auctor sit amet suscipit elit. Quisque luctus semper felis in euismod. Quisque dolor odio, interdum vel placerat lacinia, pellentesque quis nulla. Curabitur volutpat pellentesque nisi, eget consequat ligula tempus in. Sed nunc urna, gravida et pellentesque ut, sollicitudin non lectus. Aliquam erat volutpat. Nullam eleifend auctor metus, eget dignissim tellus varius nec. Etiam urna ipsum, mattis vitae ultrices vel, molestie quis neque. Morbi nulla nisl, tincidunt a aliquam eu, sodales sed neque. Sed quis felis nec enim sodales tempor. \r\n</p>\r\n\r\n<p>\r\nDuis dui orci, ullamcorper in fermentum sit amet, imperdiet eu odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur leo nunc, semper eget consequat ac, eleifend egestas ligula. Sed adipiscing, est ut egestas cursus, mauris est bibendum nunc, sit amet interdum velit justo eget dui. Integer ornare, neque non commodo hendrerit, purus est pulvinar orci, sit amet euismod leo leo eget velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam leo lectus, fermentum eget euismod sit amet, tempor non tortor. Nullam vestibulum lobortis convallis. Nulla facilisi. Phasellus pellentesque leo posuere ante rutrum quis imperdiet neque volutpat. Fusce posuere, sapien ac tempor fermentum, felis orci volutpat metus, eu fringilla ipsum leo vel velit. Suspendisse augue quam, auctor eu ultrices sit amet, molestie et nisi. Suspendisse potenti. \r\n</p>\r\n\r\n<p>\r\nProin ut elit ac massa imperdiet congue. Maecenas bibendum quam sit amet lorem aliquam elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce metus nunc, pellentesque ut luctus quis, elementum quis metus. Vivamus luctus nisl aliquam sapien porta vestibulum. Nullam fringilla sagittis elit ac varius. Quisque ut sem libero. Donec tristique purus vitae purus semper nec sodales lacus vestibulum. Sed sit amet lorem sapien. Etiam adipiscing ultrices purus consequat hendrerit. Fusce vehicula posuere vestibulum. Maecenas placerat massa massa, eget commodo tortor. Nullam tortor nibh, lacinia quis ultrices quis, cursus sit amet lectus. Vivamus sodales elit in ligula rutrum aliquam. Sed mattis pellentesque leo non imperdiet. Mauris gravida risus id dolor vestibulum lobortis. Donec velit tortor, porttitor in dictum ut, euismod non eros. Quisque sagittis, libero sit amet venenatis pulvinar, dui purus blandit massa, at placerat enim lorem ut eros. Morbi accumsan lacinia blandit. Proin in lorem at dolor sollicitudin auctor.\r\n</p>',0),(3,'Join','Join','<form action=\"do/doJoin.php\" method=\"post\" onsubmit=\"return formSubmit(this);\">\r\n    <table id=\"join\">\r\n        <tr>\r\n\r\n            <td>Username:</td>\r\n            <td>\r\n                <input type=\"text\" name=\"username\" id=\"username\" maxlength=\"20\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>Password:</td>\r\n            <td>\r\n\r\n                <input type=\"password\" name=\"password\" id=\"password\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>Confirm Password:</td>\r\n            <td>\r\n                <input type=\"password\" name=\"passwordConfirm\" id=\"passwordConfirm\" />\r\n            </td>\r\n\r\n        </tr>\r\n        <tr>\r\n            <td>Email:</td>\r\n            <td>\r\n                <input type=\"text\" name=\"email\" id=\"email\" maxlength=\"100\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n\r\n            <td>Name:</td>\r\n            <td>\r\n                <input type=\"text\" name=\"name\" id=\"name\" maxlength=\"30\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>Surname:</td>\r\n            <td>\r\n\r\n                <input type=\"text\" name=\"surname\" id=\"surname\" maxlength=\"30\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>Phone:</td>\r\n            <td>\r\n                <input type=\"text\" name=\"phone\" id=\"phone\" />\r\n            </td>\r\n\r\n        </tr>\r\n        <tr>\r\n            <td rowspan=\"2\">Address:</td>\r\n            <td>\r\n                <input type=\"text\" name=\"address1\" maxlength=\"100\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n\r\n            <td>\r\n                <input type=\"text\" name=\"address2\" maxlength=\"100\" />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\">\r\n                <input type=\"submit\" value=\"Submit\" />\r\n            </td>\r\n        </tr>\r\n\r\n    </table>\r\n</form>',0),(4,'Login','Login','    <form action=\"do/doLogin.php\" method=\"post\" onsubmit=\"return formSubmit(this);\">\r\n        <table>\r\n            <tr>\r\n\r\n                <td>Username</td>\r\n                <td>\r\n                    <input type=\"text\" id=\"username\" name=\"username\" value=\"\" />\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>Password</td>\r\n                <td>\r\n\r\n                    <input type=\"password\" id=\"password\" name=\"password\" value=\"\" />\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td>Remember Me</td>\r\n                <td>\r\n                    <input type=\"checkbox\" id=\"remember\" name=\"remember\" checked=\"checked\" />\r\n                </td>\r\n\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\">\r\n                    <input type=\"submit\" value=\"Log In\" />\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>',0);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` char(144) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `loginToken` char(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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

-- Dump completed on 2011-01-07  9:59:09
