-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.41-community-nt-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema cloudofvoice
--

CREATE DATABASE IF NOT EXISTS cloudofvoice;
USE cloudofvoice;

--
-- Definition of table `kb_categories`
--

DROP TABLE IF EXISTS `kb_categories`;
CREATE TABLE `kb_categories` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `category_name` varchar(145) default NULL,
  `parentID` int(10) unsigned NOT NULL default '0',
  `OrderNumber` int(10) unsigned NOT NULL default '0',
  `Status` int(10) unsigned NOT NULL default '0',
  `LastUpdate` datetime default NULL,
  `parent_cat_name` varchar(255) default NULL,
  `LanguageID` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`ID`),
  KEY `parentID` (`parentID`),
  KEY `OrderNumber` (`OrderNumber`),
  KEY `Status` (`Status`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kb_categories`
--

/*!40000 ALTER TABLE `kb_categories` DISABLE KEYS */;
INSERT INTO `kb_categories` (`ID`,`category_name`,`parentID`,`OrderNumber`,`Status`,`LastUpdate`,`parent_cat_name`,`LanguageID`) VALUES 
 (76,'Welcome to Elooi Support!',0,100,1,NULL,'',1),
 (3,'My profile & account settings',0,200,1,NULL,'',1),
 (72,'How to Post Links (URLs)',71,200,1,NULL,'Eloois',1),
 (7,'Profile Picture or Information',3,100,1,NULL,'My profile & account settings',1),
 (8,'About Elooi Limits',87,2000,0,NULL,'Guidelines & Best Practices',1),
 (10,'Updating Your Email',3,300,1,NULL,'My profile & account settings',1),
 (26,'Elooi Search!',71,2000,0,NULL,'Eloois',1),
 (13,'Customize Your Elooi Design',3,200,1,NULL,'My profile & account settings',1),
 (88,'Types of Eloois',71,300,1,NULL,'Eloois',1),
 (71,'Eloois',0,400,1,NULL,'',1),
 (27,'Following Rules and Best Practices',87,2000,0,NULL,'Guidelines & Best Practices',1),
 (75,'Trending Tags',71,1000,1,NULL,'Eloois',1),
 (79,'What is a Timeline?',71,600,1,NULL,'Eloois',1),
 (33,'Favorites',71,700,1,NULL,'Eloois',1),
 (73,'How to Promote Your Profile',3,2000,0,NULL,'My profile & account settings',1),
 (78,'Starting using Elooi?',76,100,1,NULL,'Welcome to Elooi Support!',1),
 (74,'What is an Echo?',71,500,1,NULL,'Eloois',1),
 (80,'The Elooi Glossary',76,300,1,NULL,'Welcome to Elooi Support!',1),
 (81,'Frequently Asked Questions',76,2000,0,NULL,'Welcome to Elooi Support!',1),
 (82,'Change Language Settings',3,500,1,NULL,'My profile & account settings',1),
 (84,'How to add Pictures to an Elooi',71,200,1,NULL,'Eloois',1),
 (87,'Guidelines & Best Practices',0,600,1,NULL,NULL,1),
 (89,'How To Post,Edit or Delete an Elooi',71,100,1,NULL,'Eloois',1),
 (91,'What Are Top Eloois?',71,2000,0,NULL,'Eloois',1),
 (92,'How To Elooi With Your Location',71,2000,0,NULL,'Eloois',1),
 (94,'How To Link Directly to an Elooi',71,800,1,NULL,'Eloois',1),
 (95,'About the Activity and @username tabs',71,2000,0,NULL,'Eloois',1),
 (96,'Rules and Best Practices',87,200,0,NULL,'Guidelines & Best Practices',1),
 (97,'The Elooi Rules',87,100,1,NULL,'Guidelines & Best Practices',1),
 (98,'How To Report Spam on Elooi',87,2000,0,NULL,'Guidelines & Best Practices',1),
 (99,'Automation Rules and Best Practices',87,2000,0,NULL,'Guidelines & Best Practices',1),
 (101,'Change or Recover Your Password',3,400,1,NULL,'My profile & account settings',1);
/*!40000 ALTER TABLE `kb_categories` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
