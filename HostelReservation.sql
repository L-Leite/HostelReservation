-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: HostelManagement
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Current Database: `HostelManagement`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `Hostel_Reservation` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `Hostel_Reservation`;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `adress` varchar(45) NOT NULL,
  `phone_number` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel`
--

DROP TABLE IF EXISTS `hostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel` (
  `hostel_id` int(11) NOT NULL AUTO_INCREMENT,
  `hostelsize_size_id` int(11) NOT NULL,
  `hostelgrade_grade_id` int(11) NOT NULL,
  `address` varchar(60) NOT NULL,
  PRIMARY KEY (`hostel_id`),
  KEY `fk_hostel_hostelsize1_idx` (`hostelsize_size_id`),
  KEY `fk_hostel_hostelgrade1_idx` (`hostelgrade_grade_id`),
  CONSTRAINT `fk_hostel_hostelgrade1` FOREIGN KEY (`hostelgrade_grade_id`) REFERENCES `hostelgrade` (`grade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hostel_hostelsize1` FOREIGN KEY (`hostelsize_size_id`) REFERENCES `hostelsize` (`size_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel`
--

LOCK TABLES `hostel` WRITE;
/*!40000 ALTER TABLE `hostel` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_reserve`
--

DROP TABLE IF EXISTS `hostel_reserve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_reserve` (
  `room_reserve_id` int(11) NOT NULL AUTO_INCREMENT,
  `reserved_date` datetime NOT NULL,
  `hostel_hostel_id` int(11) NOT NULL,
  `reserve_reserve_id` int(11) NOT NULL,
  PRIMARY KEY (`room_reserve_id`),
  KEY `fk_hostel_reserve_hostel1_idx` (`hostel_hostel_id`),
  KEY `fk_hostel_reserve_reserve1_idx` (`reserve_reserve_id`),
  CONSTRAINT `fk_hostel_reserve_hostel1` FOREIGN KEY (`hostel_hostel_id`) REFERENCES `hostel` (`hostel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hostel_reserve_reserve1` FOREIGN KEY (`reserve_reserve_id`) REFERENCES `reserve` (`reserve_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_reserve`
--

LOCK TABLES `hostel_reserve` WRITE;
/*!40000 ALTER TABLE `hostel_reserve` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostel_reserve` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostelgrade`
--

DROP TABLE IF EXISTS `hostelgrade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostelgrade` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostelgrade`
--

LOCK TABLES `hostelgrade` WRITE;
/*!40000 ALTER TABLE `hostelgrade` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostelgrade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostelprice`
--

DROP TABLE IF EXISTS `hostelprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostelprice` (
  `hostelprice_id` int(11) NOT NULL,
  `weekdaysprice` float NOT NULL,
  `weekendprice` float NOT NULL,
  `arrivedate` date NOT NULL,
  `leavedate` date NOT NULL,
  `hostelsize_size_id` int(11) NOT NULL,
  `hostelgrade_grade_id` int(11) NOT NULL,
  PRIMARY KEY (`hostelprice_id`),
  KEY `fk_hostelprice_hostelsize_idx` (`hostelsize_size_id`),
  KEY `fk_hostelprice_hostelgrade1_idx` (`hostelgrade_grade_id`),
  CONSTRAINT `fk_hostelprice_hostelgrade1` FOREIGN KEY (`hostelgrade_grade_id`) REFERENCES `hostelgrade` (`grade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hostelprice_hostelsize` FOREIGN KEY (`hostelsize_size_id`) REFERENCES `hostelsize` (`size_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostelprice`
--

LOCK TABLES `hostelprice` WRITE;
/*!40000 ALTER TABLE `hostelprice` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostelprice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostelsize`
--

DROP TABLE IF EXISTS `hostelsize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostelsize` (
  `size_id` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `interior` varchar(150) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostelsize`
--

LOCK TABLES `hostelsize` WRITE;
/*!40000 ALTER TABLE `hostelsize` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostelsize` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserve`
--

DROP TABLE IF EXISTS `reserve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserve` (
  `reserve_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_reserved` datetime NOT NULL,
  `cancel` datetime DEFAULT NULL,
  `discount` varchar(45) DEFAULT NULL,
  `checked_in` datetime NOT NULL,
  `checked_out` datetime NOT NULL,
  `client_client_id` int(11) NOT NULL,
  PRIMARY KEY (`reserve_id`),
  KEY `fk_reserve_client1_idx` (`client_client_id`),
  CONSTRAINT `fk_reserve_client1` FOREIGN KEY (`client_client_id`) REFERENCES `client` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserve`
--

LOCK TABLES `reserve` WRITE;
/*!40000 ALTER TABLE `reserve` DISABLE KEYS */;
/*!40000 ALTER TABLE `reserve` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-18  8:58:32
