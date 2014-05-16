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
-- Definition of table `badges`
--

DROP TABLE IF EXISTS `badges`;
CREATE TABLE `badges` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `badgeName` varchar(145) default NULL,
  `badgeText` varchar(245) default NULL,
  `languageID` int(10) unsigned NOT NULL default '1',
  `badgeValue` int(10) unsigned NOT NULL default '1',
  `badgeID` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `badges`
--

/*!40000 ALTER TABLE `badges` DISABLE KEYS */;
INSERT INTO `badges` (`ID`,`badgeName`,`badgeText`,`languageID`,`badgeValue`,`badgeID`) VALUES 
 (1,'Altruist','First reply to another person\'s Elooi',1,1,1),
 (2,'Announcer','Echoed an Elooi that was listedened by 25 unique IP addresses in 3 days',1,1,2),
 (3,'Archaeologist','Replied to 100 Eloois that were inactive for 6 months',1,2,3),
 (4,'Autobiographer','Completed all user profile fields',1,1,4),
 (5,'Benefactor','First reply to your own Elooi',1,1,5),
 (6,'Beta','Actively participated in the beta',1,2,6),
 (7,'Booster','Echoed an Elooi that was listedened by 300 unique IP addresses in 4 days',1,2,7),
 (8,'Citizen Patrol','First flagged post',1,1,8),
 (9,'Civic Duty','Voted 300 or more times on flagged posts',1,2,9),
 (10,'Cleanup','First delete',1,1,10),
 (11,'Commentator','Left 10 replies',1,1,11),
 (12,'Copy Editor','Retagged 500 Eloois',1,3,12),
 (13,'Deputy','Achieved a flag weight of 500 by <a href=\"/review\">reviewing</a> and flagging appropriately',1,2,13),
 (15,'Editor','Retagged 100 Eloois',1,2,14),
 (16,'Enthusiast','Visited the site each day for 30 consecutive days',1,2,15),
 (17,'Epic','Earned 200 daily reputation 50 times',1,2,16),
 (18,'Excavator','Retagged an Elooi that is 6 months old',1,1,17),
 (19,'Famous Elooi','Spoke an Elooi that was listened to 10,000',1,3,18),
 (20,'Fanatic','Visited the site each day for 100 consecutive days',1,3,19),
 (21,'Favorite Elooi','Elooi favorited by 25 users',1,2,20),
 (22,'Legendary','Earned 200 daily reputation 150 times',1,3,21),
 (23,'Marshal','Achieved a flag weight of 749 by <a href=\"/review\">reviewing</a> and flagging appropriately',1,3,22),
 (25,'Notable Elooi','Haven an Elooi that has been listened to 2,500 times',1,2,23),
 (26,'Organizer','First retag',1,1,24),
 (28,'Popular Elooi','Posted first Elooi with 1,000 listens',1,1,25),
 (32,'Stellar Elooi','Elooi favorited by 100 users',1,3,26),
 (33,'Taxonomist','Created a tag used by 50 Eloois',1,3,27),
 (34,'Yearling','Active member for a year, earning at least 200 reputation',1,3,28);
/*!40000 ALTER TABLE `badges` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
