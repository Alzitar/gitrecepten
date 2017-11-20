

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


CREATE DATABASE IF NOT EXISTS `yourdatabase_receptendb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `yourdatabase_receptendb`;


CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(50) NOT NULL,
  `achternaam` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `wachtwoord` varchar(60) NOT NULL,
  `rechten` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table yourdatabase_receptendb.ingredienten
CREATE TABLE IF NOT EXISTS `ingredienten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `naam` (`naam`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table yourdatabase_receptendb.keukengerei
CREATE TABLE IF NOT EXISTS `keukengerei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keukengerei_naam` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keukengerei_naam` (`keukengerei_naam`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `maten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maat` varchar(100) NOT NULL DEFAULT '0',
  `meervoud` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `maat` (`maat`),
  UNIQUE KEY `meervoud` (`meervoud`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `recepten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL DEFAULT '0',
  `omschrijving` text,
  `instructie` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `naam` (`naam`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `recept_ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recept_id` int(11) NOT NULL DEFAULT '0',
  `ingredient_id` int(11) NOT NULL DEFAULT '0',
  `hoeveelheid` float NOT NULL DEFAULT '0',
  `maat_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique ingredient` (`recept_id`,`ingredient_id`),
  KEY `id` (`id`),
  KEY `FK_recept_ingredient_ingredienten` (`ingredient_id`),
  KEY `FK_recept_ingredient_maten` (`maat_id`),
  CONSTRAINT `FK_recept_ingredient_ingredienten` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredienten` (`id`),
  CONSTRAINT `FK_recept_ingredient_maten` FOREIGN KEY (`maat_id`) REFERENCES `maten` (`id`),
  CONSTRAINT `FK_recept_ingredient_recepten` FOREIGN KEY (`recept_id`) REFERENCES `recepten` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `recept_keukengerei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recept_id` int(11) NOT NULL DEFAULT '0',
  `keukengerei_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique keukengerei` (`recept_id`,`keukengerei_id`),
  KEY `id` (`id`),
  KEY `FK_recept_keukengerei_keukengerei` (`keukengerei_id`),
  CONSTRAINT `FK_recept_keukengerei_keukengerei` FOREIGN KEY (`keukengerei_id`) REFERENCES `keukengerei` (`id`),
  CONSTRAINT `FK_recept_keukengerei_recepten` FOREIGN KEY (`recept_id`) REFERENCES `recepten` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
