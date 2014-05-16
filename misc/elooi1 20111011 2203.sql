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
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `badges`
--

/*!40000 ALTER TABLE `badges` DISABLE KEYS */;
INSERT INTO `badges` (`ID`,`badgeName`,`badgeText`,`languageID`,`badgeValue`,`badgeID`) VALUES 
 (1,'Commentator','Replied to 50 people',2,2,1),
 (2,'Announcer','250 listens to an Elooi you echoed',2,1,2),
 (3,'Archaeologist','Replied to 10 Eloois that were inactive for 6 months',2,2,3),
 (4,'Citizen Patrol','First flagged post',2,1,4),
 (5,'Civic Duty','Flagged 100 or more posts',2,2,5),
 (6,'Booster','Echoed an Elooi that was listedened by 300 unique IP addresses in 4 days',2,2,6),
 (7,'Excavator','Echoed an Elooi that is 6 months old',2,1,7),
 (8,'Organizer','First retag',2,1,8),
 (9,'Editor','Retagged 100 Eloois',2,2,9),
 (10,'Copy Editor','Retagged 500 Eloois',2,3,10),
 (11,'Enthusiast','Visited the site each day for 30 consecutive days',2,1,11),
 (12,'Fanatic','Visited the site each day for 100 consecutive days',2,2,12),
 (13,'Yearling','Active member for a year, earning at least 10000 reputation',2,3,13),
 (15,'Epic','Earned 200 daily reputation 50 times',2,2,14),
 (16,'Legendary','Earned 200 daily soical reputation 50 times',2,2,15),
 (17,'Beta','Actively participated in the beta',2,2,16),
 (18,'Autobiographer','Completed all user profile fields',2,1,17),
 (19,'Cleanup','First delete',2,1,18),
 (20,'Taxonomist','Created a tag used by 50 Eloois',2,2,19),
 (21,'Favorite Elooi','Elooi favorited by 25 users',2,2,20),
 (22,'Stellar Elooi','Elooi favorited by 100 users',2,3,21),
 (23,'Popular Elooi','Posted first Elooi with 1,000 listens',2,1,22),
 (25,'Notable Elooi','Haven an Elooi that has been listened to 2,500 times',2,2,23),
 (26,'Famous Elooi','Spoke an Elooi that was listened to 10,000',2,3,24),
 (28,'First Speaker','First Elooi Recorded that is 15 seconds or longer',2,1,25),
 (32,'Spokesperson','Have posted 25 Eloois',2,1,26),
 (33,'Orator','Given on the aniversariy of your 200th Elooi',2,3,27),
 (34,'Visualist','10 Eloois with pictures posted',2,1,28),
 (121,'Directory','Posted over 250 Eloois with links',2,3,31),
 (120,'Link up','Have 10 Eloois with links',2,1,30),
 (119,'Slideshow','100 Eloois with pictures posted',2,2,29),
 (126,'Broadcaster','Over 250 listeners',2,3,36),
 (125,'Public Speaker','When you have 50 listeners',2,2,35),
 (124,'Local Radio','When you get your 5th listener',2,1,34),
 (123,'All Ears','Listening to 500 peole',2,2,33),
 (122,'Monitor','After you start listening to 10 people',2,1,32);
/*!40000 ALTER TABLE `badges` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
