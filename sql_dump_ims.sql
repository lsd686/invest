/*
SQLyog Enterprise - MySQL GUI v8.14 
MySQL - 5.6.17 : Database - ims
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ims` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `ims`;

/*Table structure for table `proj` */

DROP TABLE IF EXISTS `proj`;

CREATE TABLE `proj` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `projName` varchar(20) COLLATE utf8_bin NOT NULL,
  `projNo` varchar(20) COLLATE utf8_bin NOT NULL,
  `note` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `proj` */

/*Table structure for table `trace` */

DROP TABLE IF EXISTS `trace`;

CREATE TABLE `trace` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `projId` int(10) NOT NULL,
  `time` date NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `con_abc` (`projId`),
  CONSTRAINT `con_abc` FOREIGN KEY (`projId`) REFERENCES `proj` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `trace` */

/*Table structure for table `trans` */

DROP TABLE IF EXISTS `trans`;

CREATE TABLE `trans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `projId` int(10) NOT NULL,
  `time` date NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projId` (`projId`),
  CONSTRAINT `trans_ibfk_1` FOREIGN KEY (`projId`) REFERENCES `proj` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `trans` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
