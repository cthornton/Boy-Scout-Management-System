
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bsademos`
--
-- (You might need to change this...)
--
USE `bsademo`;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_PATROL` int(16) NOT NULL default '0',
  `ID_POSTED` int(16) NOT NULL,
  `ID_EDITED` int(16) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time_posted` int(64) NOT NULL,
  `time_edited` int(64) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` VALUES(1, 0, 3, 0, 'Test', 'This is a test', 1247113270, 0);

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `ID` int(16) NOT NULL auto_increment,
  `month` smallint(3) NOT NULL,
  `day` smallint(3) NOT NULL,
  `year` smallint(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `recuring` smallint(1) NOT NULL default '0',
  `recuring_type` smallint(2) NOT NULL,
  `recuring_length` int(5) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` VALUES(1, 7, 9, 2009, 'First Event', 'This is the first event', 1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `calendar_recuring`
--

CREATE TABLE `calendar_recuring` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_CAL` int(16) NOT NULL,
  `month` smallint(3) NOT NULL,
  `day` smallint(2) NOT NULL,
  `year` smallint(5) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `calendar_recuring`
--

INSERT INTO `calendar_recuring` VALUES(1, 1, 7, 16, 2009);
INSERT INTO `calendar_recuring` VALUES(2, 1, 7, 23, 2009);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_TYPE` int(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_CAT` int(16) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `mime` varchar(255) NOT NULL,
  `size` int(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `downloads`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `ID` int(16) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `special` tinyint(1) NOT NULL default '0',
  `is_interactive` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` VALUES(1, 'Administrator', 'The administrator has complete control over the Web site. Don''t mess with him.', 1, 0);
INSERT INTO `groups` VALUES(2, 'Webmaster', 'Has control of the website. He can change the content of any non-special pages and can change user information. The webmaster has the most control of the website, except the administrator.', 1, 0);
INSERT INTO `groups` VALUES(3, 'Scoutmaster', 'The scoutmaster has similar functionality to that of the webmaster, but with fewer privileges.', 1, 0);
INSERT INTO `groups` VALUES(4, 'SPL', 'The Senior Patrol Leader has the ability to post site announcements and view patrol information.', 1, 0);
INSERT INTO `groups` VALUES(5, 'ASPL', 'The Assistant Senior Patrol Leader has similar permissions to that of the SPL', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups_interactive`
--

CREATE TABLE `groups_interactive` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_GROUP` int(16) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `groups_interactive`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_pages`
--

CREATE TABLE `groups_pages` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_GROUP` int(16) NOT NULL,
  `small_title` varchar(255) NOT NULL,
  `long_title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `time_edited` varchar(255) NOT NULL,
  `is_home` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `groups_pages`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups_permission`
--

CREATE TABLE `groups_permission` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_GROUP` int(16) NOT NULL,
  `ID_PERMISSION` int(16) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `groups_permission`
--

INSERT INTO `groups_permission` VALUES(1, 1, 1);
INSERT INTO `groups_permission` VALUES(2, 1, 2);
INSERT INTO `groups_permission` VALUES(3, 1, 11);
INSERT INTO `groups_permission` VALUES(86, 3, 10);
INSERT INTO `groups_permission` VALUES(94, 2, 10);
INSERT INTO `groups_permission` VALUES(93, 2, 7);
INSERT INTO `groups_permission` VALUES(92, 2, 6);
INSERT INTO `groups_permission` VALUES(85, 3, 8);
INSERT INTO `groups_permission` VALUES(84, 3, 7);
INSERT INTO `groups_permission` VALUES(68, 4, 6);
INSERT INTO `groups_permission` VALUES(91, 2, 5);
INSERT INTO `groups_permission` VALUES(90, 2, 3);
INSERT INTO `groups_permission` VALUES(89, 2, 2);
INSERT INTO `groups_permission` VALUES(83, 3, 6);
INSERT INTO `groups_permission` VALUES(82, 3, 5);
INSERT INTO `groups_permission` VALUES(81, 3, 3);
INSERT INTO `groups_permission` VALUES(80, 3, 2);
INSERT INTO `groups_permission` VALUES(67, 4, 5);
INSERT INTO `groups_permission` VALUES(66, 4, 2);
INSERT INTO `groups_permission` VALUES(71, 5, 5);
INSERT INTO `groups_permission` VALUES(70, 5, 2);
INSERT INTO `groups_permission` VALUES(88, 2, 1);
INSERT INTO `groups_permission` VALUES(79, 3, 1);
INSERT INTO `groups_permission` VALUES(69, 4, 10);
INSERT INTO `groups_permission` VALUES(72, 5, 10);
INSERT INTO `groups_permission` VALUES(95, 2, 11);
INSERT INTO `groups_permission` VALUES(87, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `ID` bigint(128) NOT NULL auto_increment,
  `ID_USER` int(16) NOT NULL default '0',
  `ID_TYPE` int(16) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `description` tinytext NOT NULL,
  `time` int(64) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `ID` int(16) NOT NULL auto_increment,
  `SUB_ID` int(16) NOT NULL,
  `position` int(16) NOT NULL,
  `small_title` varchar(255) NOT NULL,
  `large_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time_edited` int(64) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL default '0',
  `is_protected` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` VALUES(1, 0, 0, 'Home', 'Home', '<p>Edit this page under the admin section</p><p>Testing some features</p><ul><li>bullet</li></ul><ol><li>number</li></ol><p><strong>bold</strong></p><p><em>italics</em></p>', 1247113406, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patrols`
--

CREATE TABLE `patrols` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_PL` int(16) NOT NULL,
  `special` tinyint(1) NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `patrols`
--

INSERT INTO `patrols` VALUES(1, 10, 1, 'Adults', 'Adults may join this special patrol that cannot be deleted');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `ID` int(16) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` VALUES(1, 'Edit Users', 'Can this group edit other users');
INSERT INTO `permissions` VALUES(2, 'Create / edit pages', 'Sets whether the group can create or edit pages');
INSERT INTO `permissions` VALUES(3, 'Modify Groups', 'Does the group have premission to modify other groups');
INSERT INTO `permissions` VALUES(4, 'Modify Group Permissions', 'Does the group have premission to modify other group permissions');
INSERT INTO `permissions` VALUES(5, 'Create / Modify Announcements', 'Allows the group to create and modify announcements. Seprate from the Patrol Leader and Patrol announcements');
INSERT INTO `permissions` VALUES(6, 'Create / Modify Patrols', 'Determines whether this group can create or edit patrols.');
INSERT INTO `permissions` VALUES(7, 'Modify User Group', 'Can this group modify the group of another person');
INSERT INTO `permissions` VALUES(8, 'Delete Users', 'Can this group delete a user');
INSERT INTO `permissions` VALUES(10, 'Create / Edit Calendar Events', 'Name says it all');
INSERT INTO `permissions` VALUES(11, 'Create / Edit downloads', 'Name says it all');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(16) NOT NULL auto_increment,
  `ID_PATROL` int(16) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `date_reg` int(64) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(3, 1, 'admin', 'efacc4001e857f7eba4ae781c2932dedf843865e', 'admin@example.com', 'Admin', 'Account', '1234567890', '1234 fake st.', ' ', 'City', 1228944246);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `ID_GROUP` int(16) NOT NULL,
  `ID_USER` varchar(16) NOT NULL,
  `ID` int(16) NOT NULL auto_increment,
  `IS_LEADER` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` VALUES(1, '3', 78, 0);
