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
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `projName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '项目名称',
  `projNo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '项目编号',
  `note` varchar(1000) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `oringinPrice` double NOT NULL COMMENT '首笔买入价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT '投资项目表';

/*Data for the table `proj` */

/*Table structure for table `trace` */

DROP TABLE IF EXISTS `trace`;

CREATE TABLE `trace` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `projId` int(10) NOT NULL COMMENT '外键，指向投资项目表某id',
  `time` date NOT NULL COMMENT '跟踪日期',
  `price` double NOT NULL COMMENT '跟踪日当天价格',
  PRIMARY KEY (`id`),
  KEY `projID` (`projId`),
  CONSTRAINT  FOREIGN KEY (`projId`) REFERENCES `proj` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT '投资项目跟踪表';

/*Data for the table `trace` */

/*Table structure for table `trans` */

DROP TABLE IF EXISTS `trans`;

CREATE TABLE `trans` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `projId` int(10) NOT NULL COMMENT '外键，指向投资项目表某id',
  `time` date NOT NULL COMMENT '交易日期',
  `orient` BIT NOT NULL COMMENT '交易方向：卖出 或 买入，0表示 卖出，1表示买入',
  `price` double NOT NULL COMMENT '交易当日价格',  
  `volume` int(11) NOT NULL COMMENT '实际交易量，单位：份额',
  `amount` int(11) NOT NULL COMMENT '实际交易总金额，单位：元',
  `appVol` int(11) NOT NULL COMMENT '申请交易量，单位：份额',
  `appAmount` int(11) NOT NULL COMMENT '申请交易总金额，单位：元',
  `fee` double NOT NULL COMMENT '交易手续费，申请交易量*交易价格 - 交易价格*实际交易量 = 手续费，由程序自动计算',
  `feeRatio` double NOT NULL COMMENT '交易手续费费率，手续费 / 实际交易总金额 = 手续费率，由程序自动计算',
  PRIMARY KEY (`id`),
  KEY `projId` (`projId`),
  CONSTRAINT `trans_ibfk_1` FOREIGN KEY (`projId`) REFERENCES `proj` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT '交易表';

/*Data for the table `trans` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
