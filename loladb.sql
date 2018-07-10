-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2015 at 11:54 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'loladb'
--

-- --------------------------------------------------------

--
-- Table structure for table 'kylastus'
--

DROP TABLE IF EXISTS kylastus;
CREATE TABLE IF NOT EXISTS cm_kylastus (
  id int(7) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  kylastaja_id int(11) NOT NULL,
  kylastatu_id int(11) NOT NULL,
  hinnang char(1) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  PRIMARY KEY (id),
  KEY kylastaja_id (kylastaja_id,kylastatu_id,hinnang)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_estonian_ci AUTO_INCREMENT=72 ;



-- --------------------------------------------------------

--
-- Table structure for table 'user'
--

DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS `cm_user` (
  id int(7) NOT NULL AUTO_INCREMENT,
  username varchar(15) COLLATE utf16_estonian_ci NOT NULL,
  password varchar(30) COLLATE utf16_estonian_ci NOT NULL,
  firstname varchar(70) COLLATE utf16_estonian_ci DEFAULT NULL,
  lastname varchar(70) COLLATE utf16_estonian_ci DEFAULT NULL,
  email varchar(50) COLLATE utf16_estonian_ci NOT NULL,
  gender char(1) CHARACTER SET utf8 COLLATE utf8_esperanto_ci DEFAULT NULL,
  pilt longblob,
  welcome text COLLATE utf16_estonian_ci,
  PRIMARY KEY (id),
  UNIQUE KEY kasutajanimi (kasutajanimi),
  UNIQUE KEY email (email),
  KEY eesnimi (eesnimi,perekonnanimi,email),
  KEY sugu (sugu)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_estonian_ci COMMENT='Sisaldab andmeid sotsiaalse võrgustiku kasutajatest.' AUTO_INCREMENT=19 ;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
