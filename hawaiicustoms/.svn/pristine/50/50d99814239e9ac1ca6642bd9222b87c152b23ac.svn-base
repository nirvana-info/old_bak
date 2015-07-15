-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 27, 2007 at 04:00 PM
-- Server version: 5.0.32
-- PHP Version: 4.4.4-8+etch4
--
-- Database: `storesuite`
--

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%accountingref`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%accountingref` (
  `accountingrefid` int(11) NOT NULL auto_increment,
  `accountingrefmoduleid` varchar(100) NOT NULL default '',
  `accountingrefnodeid` int(11) NOT NULL DEFAULT 0,
  `accountingreftype` enum('customer','customergroup','product','order','salestaxcode','account','inventorylevel','orderlineitem') NOT NULL,
  `accountingrefvalue` TEXT,
  PRIMARY KEY  (`accountingrefid`),
  KEY `i_accountingref_accountingrefmoduleid` (`accountingrefmoduleid`),
  KEY `i_accountingref_accountingrefnodeid` (`accountingrefnodeid`),
  KEY `i_accountingref_accountingreftype` (`accountingreftype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%accountingspool`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%accountingspool` (
 `accountingspoolid` int(10) unsigned NOT NULL auto_increment,
 `accountingspoolparentid` int(10) unsigned NOT NULL default '0',
 `accountingspoolmoduleid` varchar(100) NOT NULL default '',
 `accountingspoolnodeid` int(10) unsigned NOT NULL default '0',
 `accountingspoolserial` text,
 `accountingspooltype` enum('customer','customergroup','product','order','salestaxcode','account','inventorylevel') NOT NULL,
 `accountingspoolservice` enum('add','edit','query') NOT NULL,
 `accountingspoollock` char(36) NOT NULL default '',
 `accountingspoolstatus` tinyint(1) default '0',
 `accountingspooldisabled` tinyint(1) NOT NULL default '0',
 `accountingspoolerrmsg` tinytext,
 `accountingspoolerrno` int(10) unsigned NOT NULL default '0',
 `accountingspoolreturn` text,
 PRIMARY KEY  (`accountingspoolid`),
 KEY `i_accountingspool_accountingspoolparentid` (`accountingspoolparentid`),
 KEY `i_accountingspool_accountingspoolmoduleid` (`accountingspoolmoduleid`),
 KEY `i_accountingspool_accountingspoolnodeid` (`accountingspoolnodeid`),
 KEY `i_accountingspool_accountingspooltype` (`accountingspooltype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%administrator_log`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%administrator_log` (
  `logid` int(11) NOT NULL auto_increment,
  `loguserid` int(11) NOT NULL default '0',
  `logip` varchar(30) NOT NULL default '',
  `logdate` int(11) NOT NULL default '0',
  `logtodo` varchar(100) NOT NULL default '',
  `logdata` text,
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%banners`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%banners` (
  `bannerid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `content` longtext,
  `page` enum('home_page','category_page','brand_page','search_page') NOT NULL default 'home_page',
  `catorbrandid` int(11) NOT NULL default '0',
  `location` enum('top','bottom') NOT NULL default 'top',
  `datecreated` int(11) NOT NULL default '0',
  `datetype` enum('always','custom') NOT NULL default 'always',
  `datefrom` int(11) NOT NULL default '0',
  `dateto` int(11) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`bannerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%brands`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%brands` (
  `brandid` int(11) NOT NULL auto_increment,
  `brandname` varchar(255) NOT NULL default '',
  `brandpagetitle` varchar(250) NOT NULL default '',
  `brandmetakeywords` text,
  `brandmetadesc` text,
  `brandimagefile` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`brandid`),
  UNIQUE KEY `u_brands_brandname` (`brandname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%categories`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `catparentid` int(11) default '0',
  `catname` varchar(50) NOT NULL default '',
  `catdesc` text NOT NULL,
  `catviews` int(11) NOT NULL default	 '0',
  `catsort` int(11) NOT NULL default '0',
  `catpagetitle` varchar(250) NOT NULL default '',
  `catmetakeywords` text,
  `catmetadesc` text,
  `catlayoutfile` varchar(50) NOT NULL default '',
  `catparentlist` text,
  `catimagefile` varchar(255) NOT NULL default '',
  `catvisible` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY  (`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%categoryassociations`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%categoryassociations` (
  `associationid` int(11) NOT NULL auto_increment,
  `productid` int(11) default '0',
  `categoryid` int(11) default '0',
  PRIMARY KEY  (`associationid`),
  KEY `i_categoryassociations_prodcat` (`productid`, `categoryid`),
  KEY `i_categoryassociations_catprod` (`categoryid`, `productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%config`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%config` (
  `database_version` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%country_regions`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%country_regions` (
  `couregid` int(11) NOT NULL auto_increment,
  `couregname` varchar(255) NOT NULL default '',
  `couregiso2` char(2) NOT NULL default '',
  `couregiso3` char(3) NOT NULL default '',
  PRIMARY KEY  (`couregid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Data for table `%%PREFIX%%countries`
--

TRUNCATE `%%PREFIX%%country_regions`;

INSERT INTO `%%PREFIX%%country_regions` (`couregid`, `couregname`, `couregiso2`, `couregiso3`) VALUES (1, 'European Union', 'EU', 'EUR');

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%countries`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%countries` (
  `countryid` int(11) NOT NULL auto_increment,
  `countrycouregid` int(11),
  `countryname` varchar(255) NOT NULL default '',
  `countryiso2` char(2) NOT NULL default '',
  `countryiso3` char(3) NOT NULL default '',
  PRIMARY KEY  (`countryid`),
  KEY `i_regions_countrycouregid` (`countrycouregid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Data for table `%%PREFIX%%countries`
--

TRUNCATE `%%PREFIX%%countries`;

INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (1, NULL, 'Afghanistan', 'AF', 'AFG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (2, NULL, 'Albania', 'AL', 'ALB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (3, NULL, 'Algeria', 'DZ', 'DZA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (4, NULL, 'American Samoa', 'AS', 'ASM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (5, NULL, 'Andorra', 'AD', 'AND');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (6, NULL, 'Angola', 'AO', 'AGO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (7, NULL, 'Anguilla', 'AI', 'AIA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (8, NULL, 'Antarctica', 'AQ', '\r');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (9, NULL, 'Antigua and Barbuda', 'AG', 'ATG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (10, NULL, 'Argentina', 'AR', 'ARG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (11, NULL, 'Armenia', 'AM', 'ARM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (12, NULL, 'Aruba', 'AW', 'ABW');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (13, NULL, 'Australia', 'AU', 'AUS');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (14, 1, 'Austria', 'AT', 'AUT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (15, NULL, 'Azerbaijan', 'AZ', 'AZE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (16, NULL, 'Bahamas', 'BS', 'BHS');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (17, NULL, 'Bahrain', 'BH', 'BHR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (18, NULL, 'Bangladesh', 'BD', 'BGD');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (19, NULL, 'Barbados', 'BB', 'BRB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (20, NULL, 'Belarus', 'BY', 'BLR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (21, 1, 'Belgium', 'BE', 'BEL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (22, NULL, 'Belize', 'BZ', 'BLZ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (23, NULL, 'Benin', 'BJ', 'BEN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (24, NULL, 'Bermuda', 'BM', 'BMU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (25, NULL, 'Bhutan', 'BT', 'BTN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (26, NULL, 'Bolivia', 'BO', 'BOL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (27, NULL, 'Bosnia and Herzegovina', 'BA', 'BIH');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (28, NULL, 'Botswana', 'BW', 'BWA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (29, NULL, 'Bouvet Island', 'BV', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (30, NULL, 'Brazil', 'BR', 'BRA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (31, NULL, 'British Indian Ocean Territory', 'IO', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (32, NULL, 'Brunei Darussalam', 'BN', 'BRN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (33, 1, 'Bulgaria', 'BG', 'BGR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (34, NULL, 'Burkina Faso', 'BF', 'BFA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (35, NULL, 'Burundi', 'BI', 'BDI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (36, NULL, 'Cambodia', 'KH', 'KHM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (37, NULL, 'Cameroon', 'CM', 'CMR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (38, NULL, 'Canada', 'CA', 'CAN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (39, NULL, 'Cape Verde', 'CV', 'CPV');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (40, NULL, 'Cayman Islands', 'KY', 'CYM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (41, NULL, 'Central African Republic', 'CF', 'CAF');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (42, NULL, 'Chad', 'TD', 'TCD');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (43, NULL, 'Chile', 'CL', 'CHL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (44, NULL, 'China', 'CN', 'CHN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (45, NULL, 'Christmas Island', 'CX', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (46, NULL, 'Cocos (Keeling) Islands', 'CC', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (47, NULL, 'Colombia', 'CO', 'COL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (48, NULL, 'Comoros', 'KM', 'COM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (49, NULL, 'Congo', 'CG', 'COG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (50, NULL, 'Congo, the Democratic Republic of the', 'CD', 'COD');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (51, NULL, 'Cook Islands', 'CK', 'COK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (52, NULL, 'Costa Rica', 'CR', 'CRI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (54, NULL, 'Croatia', 'HR', 'HRV');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (55, NULL, 'Cuba', 'CU', 'CUB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (56, NULL, 'Cyprus', 'CY', 'CYP');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (57, NULL, 'Czech Republic', 'CZ', 'CZE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (58, NULL, 'Denmark', 'DK', 'DNK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (59, NULL, 'Djibouti', 'DJ', 'DJI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (60, NULL, 'Dominica', 'DM', 'DMA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (61, NULL, 'Dominican Republic', 'DO', 'DOM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (62, NULL, 'Ecuador', 'EC', 'ECU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (63, NULL, 'Egypt', 'EG', 'EGY');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (64, NULL, 'El Salvador', 'SV', 'SLV');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (65, NULL, 'Equatorial Guinea', 'GQ', 'GNQ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (66, NULL, 'Eritrea', 'ER', 'ERI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (67, NULL, 'Estonia', 'EE', 'EST');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (68, NULL, 'Ethiopia', 'ET', 'ETH');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (69, NULL, 'Falkland Islands (Malvinas)', 'FK', 'FLK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (70, NULL, 'Faroe Islands', 'FO', 'FRO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (71, NULL, 'Fiji', 'FJ', 'FJI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (72, 1, 'Finland', 'FI', 'FIN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (73, 1, 'France', 'FR', 'FRA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (74, NULL, 'French Guiana', 'GF', 'GUF');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (75, NULL, 'French Polynesia', 'PF', 'PYF');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (76, NULL, 'French Southern Territories', 'TF', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (77, NULL, 'Gabon', 'GA', 'GAB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (78, NULL, 'Gambia', 'GM', 'GMB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (79, NULL, 'Georgia', 'GE', 'GEO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (80, 1, 'Germany', 'DE', 'DEU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (81, NULL, 'Ghana', 'GH', 'GHA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (82, NULL, 'Gibraltar', 'GI', 'GIB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (83, 1, 'Greece', 'GR', 'GRC');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (84, NULL, 'Greenland', 'GL', 'GRL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (85, NULL, 'Grenada', 'GD', 'GRD');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (86, NULL, 'Guadeloupe', 'GP', 'GLP');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (87, NULL, 'Guam', 'GU', 'GUM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (88, NULL, 'Guatemala', 'GT', 'GTM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (89, NULL, 'Guinea', 'GN', 'GIN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (90, NULL, 'Guinea-Bissau', 'GW', 'GNB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (91, NULL, 'Guyana', 'GY', 'GUY');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (92, NULL, 'Haiti', 'HT', 'HTI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (93, NULL, 'Heard Island and Mcdonald Islands', 'HM', '\r');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (94, NULL, 'Holy See (Vatican City State)', 'VA', 'VAT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (95, NULL, 'Honduras', 'HN', 'HND');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (96, NULL, 'Hong Kong', 'HK', 'HKG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (97, NULL, 'Hungary', 'HU', 'HUN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (98, NULL, 'Iceland', 'IS', 'ISL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (99, NULL, 'India', 'IN', 'IND');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (100, NULL, 'Indonesia', 'ID', 'IDN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (101, NULL, 'Iran, Islamic Republic of', 'IR', 'IRN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (102, NULL, 'Iraq', 'IQ', 'IRQ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (103, 1, 'Ireland', 'IE', 'IRL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (104, NULL, 'Israel', 'IL', 'ISR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (105, 1, 'Italy', 'IT', 'ITA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (106, NULL, 'Jamaica', 'JM', 'JAM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (107, NULL, 'Japan', 'JP', 'JPN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (108, NULL, 'Jordan', 'JO', 'JOR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (109, NULL, 'Kazakhstan', 'KZ', 'KAZ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (110, NULL, 'Kenya', 'KE', 'KEN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (111, NULL, 'Kiribati', 'KI', 'KIR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (113, NULL, 'Korea, Republic of', 'KR', 'KOR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (114, NULL, 'Kuwait', 'KW', 'KWT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (115, NULL, 'Kyrgyzstan', 'KG', 'KGZ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (117, NULL, 'Latvia', 'LV', 'LVA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (118, NULL, 'Lebanon', 'LB', 'LBN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (119, NULL, 'Lesotho', 'LS', 'LSO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (120, NULL, 'Liberia', 'LR', 'LBR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (121, NULL, 'Libyan Arab Jamahiriya', 'LY', 'LBY');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (122, NULL, 'Liechtenstein', 'LI', 'LIE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (123, NULL, 'Lithuania', 'LT', 'LTU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (124, 1, 'Luxembourg', 'LU', 'LUX');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (125, NULL, 'Macao', 'MO', 'MAC');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (126, NULL, 'Macedonia, the Former Yugoslav Republic of', 'MK', 'MKD');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (127, NULL, 'Madagascar', 'MG', 'MDG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (128, NULL, 'Malawi', 'MW', 'MWI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (129, NULL, 'Malaysia', 'MY', 'MYS');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (130, NULL, 'Maldives', 'MV', 'MDV');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (131, NULL, 'Mali', 'ML', 'MLI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (132, NULL, 'Malta', 'MT', 'MLT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (133, NULL, 'Marshall Islands', 'MH', 'MHL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (134, NULL, 'Martinique', 'MQ', 'MTQ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (135, NULL, 'Mauritania', 'MR', 'MRT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (136, NULL, 'Mauritius', 'MU', 'MUS');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (137, NULL, 'Mayotte', 'YT', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (138, NULL, 'Mexico', 'MX', 'MEX');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (139, NULL, 'Micronesia, Federated States of', 'FM', 'FSM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (140, NULL, 'Moldova, Republic of', 'MD', 'MDA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (141, NULL, 'Monaco', 'MC', 'MCO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (142, NULL, 'Mongolia', 'MN', 'MNG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (143, NULL, 'Montserrat', 'MS', 'MSR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (144, NULL, 'Morocco', 'MA', 'MAR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (145, NULL, 'Mozambique', 'MZ', 'MOZ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (146, NULL, 'Myanmar', 'MM', 'MMR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (147, NULL, 'Namibia', 'NA', 'NAM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (148, NULL, 'Nauru', 'NR', 'NRU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (149, NULL, 'Nepal', 'NP', 'NPL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (150, 1, 'Netherlands', 'NL', 'NLD');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (151, NULL, 'Netherlands Antilles', 'AN', 'ANT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (152, NULL, 'New Caledonia', 'NC', 'NCL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (153, NULL, 'New Zealand', 'NZ', 'NZL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (154, NULL, 'Nicaragua', 'NI', 'NIC');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (155, NULL, 'Niger', 'NE', 'NER');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (156, NULL, 'Nigeria', 'NG', 'NGA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (157, NULL, 'Niue', 'NU', 'NIU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (158, NULL, 'Norfolk Island', 'NF', 'NFK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (159, NULL, 'Northern Mariana Islands', 'MP', 'MNP');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (160, NULL, 'Norway', 'NO', 'NOR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (161, NULL, 'Oman', 'OM', 'OMN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (162, NULL, 'Pakistan', 'PK', 'PAK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (163, NULL, 'Palau', 'PW', 'PLW');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (164, NULL, 'Palestinian Territory, Occupied', 'PS', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (165, NULL, 'Panama', 'PA', 'PAN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (166, NULL, 'Papua New Guinea', 'PG', 'PNG');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (167, NULL, 'Paraguay', 'PY', 'PRY');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (168, NULL, 'Peru', 'PE', 'PER');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (169, NULL, 'Philippines', 'PH', 'PHL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (170, NULL, 'Pitcairn', 'PN', 'PCN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (171, NULL, 'Poland', 'PL', 'POL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (172, 1, 'Portugal', 'PT', 'PRT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (173, NULL, 'Puerto Rico', 'PR', 'PRI');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (174, NULL, 'Qatar', 'QA', 'QAT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (175, NULL, 'Reunion', 'RE', 'REU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (176, NULL, 'Romania', 'RO', 'ROM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (177, NULL, 'Russian Federation', 'RU', 'RUS');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (178, NULL, 'Rwanda', 'RW', 'RWA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (179, NULL, 'Saint Helena', 'SH', 'SHN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (180, NULL, 'Saint Kitts and Nevis', 'KN', 'KNA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (181, NULL, 'Saint Lucia', 'LC', 'LCA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (182, NULL, 'Saint Pierre and Miquelon', 'PM', 'SPM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (183, NULL, 'Saint Vincent and the Grenadines', 'VC', 'VCT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (184, NULL, 'Samoa', 'WS', 'WSM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (185, NULL, 'San Marino', 'SM', 'SMR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (186, NULL, 'Sao Tome and Principe', 'ST', 'STP');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (187, NULL, 'Saudi Arabia', 'SA', 'SAU');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (188, NULL, 'Senegal', 'SN', 'SEN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (189, NULL, 'Serbia and Montenegro', 'CS', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (190, NULL, 'Seychelles', 'SC', 'SYC');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (191, NULL, 'Sierra Leone', 'SL', 'SLE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (192, NULL, 'Singapore', 'SG', 'SGP');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (193, NULL, 'Slovakia', 'SK', 'SVK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (194, NULL, 'Slovenia', 'SI', 'SVN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (195, NULL, 'Solomon Islands', 'SB', 'SLB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (196, NULL, 'Somalia', 'SO', 'SOM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (197, NULL, 'South Africa', 'ZA', 'ZAF');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (198, NULL, 'South Georgia and the South Sandwich Islands', 'GS', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (199, 1, 'Spain', 'ES', 'ESP');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (200, NULL, 'Sri Lanka', 'LK', 'LKA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (201, NULL, 'Sudan', 'SD', 'SDN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (202, NULL, 'Suriname', 'SR', 'SUR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (203, NULL, 'Svalbard and Jan Mayen', 'SJ', 'SJM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (204, NULL, 'Swaziland', 'SZ', 'SWZ');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (205, NULL, 'Sweden', 'SE', 'SWE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (206, NULL, 'Switzerland', 'CH', 'CHE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (207, NULL, 'Syrian Arab Republic', 'SY', 'SYR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (208, NULL, 'Taiwan, Province of China', 'TW', 'TWN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (209, NULL, 'Tajikistan', 'TJ', 'TJK');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (210, NULL, 'Tanzania, United Republic of', 'TZ', 'TZA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (211, NULL, 'Thailand', 'TH', 'THA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (212, NULL, 'Timor-Leste', 'TL', 'NUL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (213, NULL, 'Togo', 'TG', 'TGO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (214, NULL, 'Tokelau', 'TK', 'TKL');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (215, NULL, 'Tonga', 'TO', 'TON');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (216, NULL, 'Trinidad and Tobago', 'TT', 'TTO');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (217, NULL, 'Tunisia', 'TN', 'TUN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (218, NULL, 'Turkey', 'TR', 'TUR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (219, NULL, 'Turkmenistan', 'TM', 'TKM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (220, NULL, 'Turks and Caicos Islands', 'TC', 'TCA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (221, NULL, 'Tuvalu', 'TV', 'TUV');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (222, NULL, 'Uganda', 'UG', 'UGA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (223, NULL, 'Ukraine', 'UA', 'UKR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (224, NULL, 'United Arab Emirates', 'AE', 'ARE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (225, NULL, 'United Kingdom', 'GB', 'GBR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (226, NULL, 'United States', 'US', 'USA');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (227, NULL, 'United States Minor Outlying Islands', 'UM', '\r');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (228, NULL, 'Uruguay', 'UY', 'URY');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (229, NULL, 'Uzbekistan', 'UZ', 'UZB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (230, NULL, 'Vanuatu', 'VU', 'VUT');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (231, NULL, 'Venezuela', 'VE', 'VEN');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (232, NULL, 'Viet Nam', 'VN', 'VNM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (233, NULL, 'Virgin Islands, British', 'VG', 'VGB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (234, NULL, 'Virgin Islands, U.s.', 'VI', 'VIR');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (235, NULL, 'Wallis and Futuna', 'WF', 'WLF');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (236, NULL, 'Western Sahara', 'EH', 'ESH');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (237, NULL, 'Yemen', 'YE', 'YEM');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (238, NULL, 'Zambia', 'ZM', 'ZMB');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (239, NULL, 'Zimbabwe', 'ZW', 'ZWE');
INSERT INTO `%%PREFIX%%countries` (`countryid`, `countrycouregid`, `countryname`, `countryiso2`, `countryiso3`) VALUES (240, NULL, 'Isle of Man', 'IM', 'IMN');

--
-- Table structure for table `%%PREFIX%%country_states`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%country_states` (
  `stateid` int(11) NOT NULL auto_increment,
  `statename` varchar(255) NOT NULL default '',
  `statecountry` int(11) NOT NULL default '0',
  `stateabbrv` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`stateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data for table `%%PREFIX%%country_states`
--

TRUNCATE `%%PREFIX%%country_states`;

INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Alabama', 226, 'AL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Alaska', 226, 'AK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('American Samoa', 226, 'AS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Arizona', 226, 'AZ');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Arkansas', 226, 'AR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armed Forces Africa', 226, 'AF');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armed Forces Americas', 226, 'AA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armed Forces Canada', 226, 'AC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armed Forces Europe', 226, 'AE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armed Forces Middle East', 226, 'AM');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armed Forces Pacific', 226, 'AP');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('California', 226, 'CA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Colorado', 226, 'CO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Connecticut', 226, 'CT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Delaware', 226, 'DE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('District of Columbia', 226, 'DC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Federated States Of Micronesia', 226, 'FM');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Florida', 226, 'FL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Georgia', 226, 'GA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Guam', 226, 'GU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Hawaii', 226, 'HI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Idaho', 226, 'ID');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Illinois', 226, 'IL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Indiana', 226, 'IN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Iowa', 226, 'IA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kansas', 226, 'KS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kentucky', 226, 'KY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Louisiana', 226, 'LA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Maine', 226, 'ME');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Marshall Islands', 226, 'MH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Maryland', 226, 'MD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Massachusetts', 226, 'MA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Michigan', 226, 'MI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Minnesota', 226, 'MN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Mississippi', 226, 'MS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Missouri', 226, 'MO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Montana', 226, 'MT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nebraska', 226, 'NE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nevada', 226, 'NV');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('New Hampshire', 226, 'NH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('New Jersey', 226, 'NJ');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('New Mexico', 226, 'NM');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('New York', 226, 'NY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('North Carolina', 226, 'NC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('North Dakota', 226, 'ND');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Northern Mariana Islands', 226, 'MP');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ohio', 226, 'OH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Oklahoma', 226, 'OK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Oregon', 226, 'OR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Palau', 226, 'PW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Pennsylvania', 226, 'PA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Puerto Rico', 226, 'PR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Rhode Island', 226, 'RI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('South Carolina', 226, 'SC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('South Dakota', 226, 'SD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tennessee', 226, 'TN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Texas', 226, 'TX');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Utah', 226, 'UT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Vermont', 226, 'VT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Virgin Islands', 226, 'VI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Virginia', 226, 'VA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Washington', 226, 'WA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Virginia', 226, 'WV');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wisconsin', 226, 'WI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wyoming', 226, 'WY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Alberta', 38, 'AB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('British Columbia', 38, 'BC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Manitoba', 38, 'MB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Newfoundland', 38, 'NF');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('New Brunswick', 38, 'NB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nova Scotia', 38, 'NS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Northwest Territories', 38, 'NT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nunavut', 38, 'NU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ontario', 38, 'ON');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Prince Edward Island', 38, 'PE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Quebec', 38, 'QC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Saskatchewan', 38, 'SK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Yukon Territory', 38, 'YT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Niedersachsen', 80, 'NDS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Baden-Württemberg', 80, 'BAW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bayern', 80, 'BAY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Berlin', 80, 'BER');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Brandenburg', 80, 'BRG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bremen', 80, 'BRE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Hamburg', 80, 'HAM');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Hessen', 80, 'HES');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Mecklenburg-Vorpommern', 80, 'MEC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nordrhein-Westfalen', 80, 'NRW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Rheinland-Pfalz', 80, 'RHE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Saarland', 80, 'SAR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sachsen', 80, 'SAS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sachsen-Anhalt', 80, 'SAC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Schleswig-Holstein', 80, 'SCN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Thüringen', 80, 'THE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wien', 14, 'WIE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Niederösterreich', 14, 'NO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Oberösterreich', 14, 'OO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Salzburg', 14, 'SB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kärnten', 14, 'KN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Steiermark', 14, 'ST');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tirol', 14, 'TI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Burgenland', 14, 'BL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Voralberg', 14, 'VB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Aargau', 206, 'AG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Appenzell Innerrhoden', 206, 'AI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Appenzell Ausserrhoden', 206, 'APP');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bern', 206, 'BE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Basel-Landschaft', 206, 'BLA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Basel-Stadt', 206, 'BS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Freiburg', 206, 'FR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Genf', 206, 'GE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Glarus', 206, 'GL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Graubünden', 206, 'JUB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jura', 206, 'JU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Luzern', 206, 'LU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Neuenburg', 206, 'NEU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nidwalden', 206, 'NW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Obwalden', 206, 'OW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('St. Gallen', 206, 'SG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Schaffhausen', 206, 'SH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Solothurn', 206, 'SO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Schwyz', 206, 'SZ');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Thurgau', 206, 'TG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tessin', 206, 'TE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Uri', 206, 'UR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Waadt', 206, 'VD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wallis', 206, 'VS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Zug', 206, 'ZG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Zürich', 206, 'ZH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('A Coruña', 199, 'ACOR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Alava', 199, 'ALAV');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Albacete', 199, 'ALBA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Alicante', 199, 'ALIC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Almeria', 199, 'ALME');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Asturias', 199, 'ASTU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Avila', 199, 'AVIL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Badajoz', 199, 'BADA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Baleares', 199, 'BALE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Barcelona', 199, 'BARC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Burgos', 199, 'BURG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Caceres', 199, 'CACE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cadiz', 199, 'CADI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cantabria', 199, 'CANT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Castellon', 199, 'CAST');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ceuta', 199, 'CEUT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ciudad Real', 199, 'CIUD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cordoba', 199, 'CORD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cuenca', 199, 'CUEN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Girona', 199, 'GIRO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Granada', 199, 'GRAN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Guadalajara', 199, 'GUAD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Guipuzcoa', 199, 'GUIP');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Huelva', 199, 'HUEL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Huesca', 199, 'HUES');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jaen', 199, 'JAEN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('La Rioja', 199, 'LAR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Las Palmas', 199, 'LAS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Leon', 199, 'LEON');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Lleida', 199, 'LLEI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Lugo', 199, 'LUGO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Madrid', 199, 'MADR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Malaga', 199, 'MALA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Melilla', 199, 'MELI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Murcia', 199, 'MURC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Navarra', 199, 'NAVA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ourense', 199, 'OURE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Palencia', 199, 'PALE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Pontevedra', 199, 'PONT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Salamanca', 199, 'SALA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Santa Cruz de Tenerife', 199, 'SANT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Segovia', 199, 'SEGO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sevilla', 199, 'SEVI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Soria', 199, 'SORI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tarragona', 199, 'TARR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Teruel', 199, 'TERU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Toledo', 199, 'TOLE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Valencia', 199, 'VALE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Valladolid', 199, 'VALL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Vizcaya', 199, 'VIZC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Zamora', 199, 'ZAMO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Zaragoza', 199, 'ZARA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Carlow', 103, 'CW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cavan', 103, 'CN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Clare', 103, 'CE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cork', 103, 'C');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Donegal', 103, 'DL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Dublin', 103, 'D');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Galway', 103, 'G');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kerry', 103, 'KY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kildare', 103, 'KE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kilkenny', 103, 'KK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Laoighis', 103, 'LS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Leitrim', 103, 'LM');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Limerick', 103, 'LK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Longford', 103, 'LD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Louth', 103, 'LH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Mayo', 103, 'MO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Meath', 103, 'MH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Monaghan', 103, 'MN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Offaly', 103, 'OY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Roscommon', 103, 'RN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sligo', 103, 'SO');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tipperary', 103, 'TA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Waterford', 103, 'WD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Westmeath', 103, 'WH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wexford', 103, 'WX');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wicklow', 103, 'WW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Australian Capital Territory', 13, 'ACT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('New South Wales', 13, 'NSW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Northern Territory', 13, 'NT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Queensland', 13, 'QLD');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('South Australia', 13, 'SA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tasmania', 13, 'TAS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Victoria', 13, 'VIC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Western Australia', 13, 'WA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Johor', 129, 'JHR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kedah', 129, 'KDH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kelantan', 129, 'KTN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Melaka', 129, 'MLK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Negeri Sembilan', 129, 'NSN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Pahang', 129, 'PHG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Pulau Pinang', 129, 'PNG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Perak', 129, 'PRK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Perlis', 129, 'PLS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Selangor', 129, 'SGR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Terengganu', 129, 'TRG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sabah', 129, 'SBH');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sarawak', 129, 'SRW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kuala Lumpur', 129, 'KUL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Labuan', 129, 'LBN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Putrajaya', 129, 'PJY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Labuan', 129, 'JHR');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Eastern Cape', 197, 'EC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Free State', 197, 'FS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Gauteng', 197, 'GT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('KwaZulu-Natal', 197, 'NL');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Limpopo', 197, 'LP');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Mpumalanga', 197, 'MP');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Northern Cape', 197, 'NC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('North-West', 197, 'NW');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Western Cape', 197, 'WC');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bali', 100, 'BA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bangka Belitung', 100, 'BB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Banten', 100, 'BT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bengkulu', 100, 'BE');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Daista Aceh', 100, 'DA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jakarta', 100, 'JK');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sumatera Utara', 100, 'SU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sumatera Barat', 100, 'SB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Riau', 100, 'SI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jambi', 100, 'JA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sumatera Selatan', 100, 'SS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Lampung', 100, 'LA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jawa Barat', 100, 'JB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jawa Tengah', 100, 'JT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Daista Yogyakarta', 100, 'DY');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Jawa Timur', 100, 'JT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kalimantan Barat', 100, 'KB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kalimantan Tengah', 100, 'KT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kalimantan Timur', 100, 'KI');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kalimantan Selatan', 100, 'KS');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nusa Tenggara Barat', 100, 'NB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nusa Tenggara Timur', 100, 'NT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sulawesi Selatan', 100, 'SN');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sulawesi Tengah', 100, 'ST');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sulawesi Utara', 100, 'SA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sulawesi Tenggara', 100, 'SG');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Maluku', 100, 'MA');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Maluku Utara', 100, 'MU');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Irian Jaya Timur', 100, 'IJ');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Irian Jaya Tengah', 100, 'IT');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Irian Jawa Barat', 100, 'IB');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Gorontalo', 100, 'GO');

INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bedfordshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Berkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Buckinghamshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cambridgeshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cheshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cornwall', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cumberland', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cumbria', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Derbyshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Devon', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Dorset', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Durham', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('East Suffolk', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('East Sussex', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Essex', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Gloucestershire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Greater London', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Greater Manchester', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Hampshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Herefordshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Hertfordshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Isle of Wight', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kent', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Lancashire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Leicestershire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Lincolnshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('London', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Merseyside', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Middlesex', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Norfolk', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Northamptonshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Northumberland', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('North Humberside', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('North Yorkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nottinghamshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Oxfordshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Rutland', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Shropshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Somerset', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('South Humberside', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('South Yorkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Staffordshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Suffolk', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Surrey', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sussex', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tyne and Wear', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Warwickshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Midlands', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Westmorland', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Suffolk', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Sussex', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Yorkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wiltshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Worcestershire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Yorkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Yorkshire, East Riding', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Yorkshire, North Riding', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Yorkshire, West Riding', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Antrim', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Armagh', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('City of Belfast', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Down', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Fermanagh', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Londonderry', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('City of Londonderry', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Tyrone', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('City of Aberdeen', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Aberdeenshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Angus', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Argyll', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ayrshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Banffshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Berwickshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Bute', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Caithness', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Clackmannanshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cromartyshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Dumfriesshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Dunbartonshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('City of Dundee', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('East Lothian', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('City of Edinburgh', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Fife', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('City of Glasgow', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Inverness-shire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kincardineshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kinross-shire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Kirkcudbrightshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Lanarkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Midlothian', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Moray', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Nairnshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Orkney', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Peeblesshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Perthshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Renfrewshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ross and Cromarty', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Ross-shire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Roxburghshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Selkirkshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Shetland', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Stirlingshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Sutherland', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Lothian', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Wigtownshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Anglesey', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Brecknockshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Caernarfonshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Cardiganshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Carmarthenshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Clwyd', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Denbighshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Dyfed', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Flintshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Glamorgan', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Gwent', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Gwynedd', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Merionethshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Mid Glamorgan', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Monmouthshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Montgomeryshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Pembrokeshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Powys', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('Radnorshire', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('South Glamorgan', 225, '');
INSERT INTO `%%PREFIX%%country_states` (`statename`, `statecountry`, `stateabbrv`) VALUES ('West Glamorgan', 225, '');

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%coupons`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%coupons` (
  `couponid` int(11) NOT NULL auto_increment,
  `couponname` varchar(100) NOT NULL default '',
  `coupontype` tinyint(4) NOT NULL default '0',
  `couponamount` decimal(20,4) NOT NULL default '0',
  `couponminpurchase` int(11) NOT NULL default '0',
  `couponexpires` int(11) NOT NULL default '0',
  `couponenabled` tinyint(4) NOT NULL default '0',
  `couponcode` varchar(50) NOT NULL default '',
  `couponappliesto` enum('categories','products') NOT NULL default 'products',
  `couponappliestovalues` varchar(250) NOT NULL default '',
  `couponnumuses` int(11) NOT NULL default '0',
  `couponmaxuses` int(11) NOT NULL default '0',
  PRIMARY KEY  (`couponid`),
  UNIQUE KEY `u_coupons_couponcode` (`couponcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%currencies`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%currencies` (
 `currencyid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
 `currencycountryid` INT(11) UNSIGNED DEFAULT NULL,
 `currencycouregid` INT(11) UNSIGNED DEFAULT NULL,
 `currencycode` CHAR(3) NOT NULL DEFAULT '',
 `currencyconvertercode` VARCHAR(255) DEFAULT NULL,
 `currencyname` varchar(255) NOT NULL DEFAULT '',
 `currencyexchangerate` DECIMAL(20,10) NOT NULL DEFAULT 0,
 `currencystring` VARCHAR(20) NOT NULL DEFAULT '',
 `currencystringposition` CHAR(5) NOT NULL DEFAULT '',
 `currencydecimalstring` CHAR(1) NOT NULL DEFAULT '',
 `currencythousandstring` CHAR(1) NOT NULL DEFAULT '',
 `currencydecimalplace` SMALLINT UNSIGNED NOT NULL DEFAULT 2,
 `currencylastupdated` INT(11) NOT NULL DEFAULT 0,
 `currencyisdefault` SMALLINT(1) NOT NULL DEFAULT 0,
 `currencystatus` SMALLINT(1) NOT NULL DEFAULT 0,
 PRIMARY KEY (`currencyid`),
 UNIQUE KEY `u_currencies_currencycode_currencycountryid_currencycouregid` (`currencycode`,`currencycountryid`, `currencycouregid`),
 KEY `i_countries_currencycountryid`(`currencycountryid`),
 KEY `i_countries_currencycouregid`(`currencycouregid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%custom_searches`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%custom_searches` (
  `searchid` int(11) NOT NULL auto_increment,
  `searchtype` enum('orders','products','customers', 'returns', 'giftcertificates', 'shipments') NOT NULL default 'orders',
  `searchname` varchar(255) NOT NULL default '',
  `searchvars` longtext,
  PRIMARY KEY  (`searchid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `%%PREFIX%%custom_searches` (`searchtype`, `searchname`, `searchvars`) VALUES ('orders', 'Incomplete Orders', 'viewName=Incomplete+Orders&orderStatus=0');


-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%customer_credits`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%customer_credits` (
  `custcreditid` int(10) NOT NULL auto_increment,
  `customerid` int(10) NOT NULL default '0',
  `creditamount` decimal(20,4) NOT NULL default '0',
  `credittype` enum('return','gift','adjustment') NOT NULL,
  `creditdate` int(10) NOT NULL default '0',
  `creditrefid` int(10) NOT NULL default '0',
  `credituserid` int(10) NOT NULL default '0',
  `creditreason` varchar(200) NOT NULL default '0',
  PRIMARY KEY  (`custcreditid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%customers`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%customers` (
  `customerid` int(11) NOT NULL auto_increment,
  `custpassword` varchar(50) NOT NULL default '',
  `custconcompany` varchar(255) NOT NULL default '',
  `custconfirstname` varchar(100) NOT NULL default '',
  `custconlastname` varchar(100) NOT NULL default '',
  `custconemail` varchar(250) NOT NULL default '',
  `custconphone` varchar(50) NOT NULL default '',
  `customertoken` varchar(250) NOT NULL default '',
  `customerpasswordresettoken` varchar(32) NOT NULL default '',
  `customerpasswordresetemail` varchar(255) NOT NULL default '',
  `custdatejoined` int(11) NOT NULL default '0',
  `custimportpassword` varchar(100) NOT NULL default '',
  `custstorecredit` decimal(20,4) NOT NULL default '0',
  `custregipaddress` varchar(30) NOT NULL default '',
  `custgroupid` int(11) NOT NULL default '0',
  `custnotes` TEXT,
  `custformsessionid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`customerid`),
  KEY `i_customers_customertoken` (`customertoken`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%forms`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%forms` (
  `formid` int(10) unsigned NOT NULL auto_increment,
  `formname` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`formid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `%%PREFIX%%forms` VALUES (1,'Account Details');
INSERT INTO `%%PREFIX%%forms` VALUES (2,'Billing Details');
INSERT INTO `%%PREFIX%%forms` VALUES (3,'Shipping Details');

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%formfields`
--

CREATE TABLE `%%PREFIX%%formfields` (
  `formfieldid` int(10) unsigned NOT NULL auto_increment,
  `formfieldformid` int(10) unsigned NOT NULL default '0',
  `formfieldtype` varchar(50) NOT NULL default '',
  `formfieldlabel` varchar(255) NOT NULL default '',
  `formfielddefaultval` varchar(255) NOT NULL default '',
  `formfieldextrainfo` text,
  `formfieldisrequired` tinyint(1) NOT NULL default '0',
  `formfieldisimmutable` tinyint(1) default '0',
  `formfieldprivateid` varchar(255) NOT NULL default '',
  `formfieldlastmodified` int (10) unsigned NOT NULL default '0',
  `formfieldsort` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`formfieldid`),
  KEY `i_formfields_formfieldformid` (`formfieldformid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,1,'singleline','Email Address','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'EmailAddress',UNIX_TIMESTAMP(),1);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,1,'password','Password','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'Password',UNIX_TIMESTAMP(),2);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,1,'password','Confirm Password','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'ConfirmPassword',UNIX_TIMESTAMP(),3);

INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','First Name','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'FirstName',UNIX_TIMESTAMP(),1);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Last Name','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'LastName',UNIX_TIMESTAMP(),2);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Company Name','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',0,1,'CompanyName',UNIX_TIMESTAMP(),3);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Phone Number','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'Phone',UNIX_TIMESTAMP(),4);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Address Line 1','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'AddressLine1',UNIX_TIMESTAMP(),5);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Address Line 2','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',0,1,'AddressLine2',UNIX_TIMESTAMP(),6);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Suburb/City','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'City',UNIX_TIMESTAMP(),7);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleselect','Country','','a:4:{s:5:\"class\";s:8:\"Field200\";s:5:\"style\";s:0:\"\";s:12:\"chooseprefix\";s:16:\"Choose a Country\";s:7:\"options\";a:0:{}}',1,1,'Country',UNIX_TIMESTAMP(),8);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'selectortext','State/Province','','a:6:{s:5:\"class\";s:8:\"Field200\";s:5:\"style\";s:0:\"\";s:12:\"chooseprefix\";s:14:\"Choose a State\";s:7:\"options\";a:0:{}s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}',1,1,'State',UNIX_TIMESTAMP(),9);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'singleline','Zip/Postcode','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:15:\"Textbox Field45\";s:5:\"style\";s:11:\"width:40px;\";}',1,1,'Zip',UNIX_TIMESTAMP(),10);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'checkboxselect','Save This Address?','','a:3:{s:5:\"class\";s:0:\"\";s:5:\"style\";s:0:\"\";s:7:\"options\";a:1:{i:0;s:41:\"Yes, save this address to my address book\";}}',0,1,'SaveThisAddress',UNIX_TIMESTAMP(),11);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,2,'checkboxselect','Ship to This Address?','','a:3:{s:5:\"class\";s:0:\"\";s:5:\"style\";s:0:\"\";s:7:\"options\";a:1:{i:0;s:25:\"Yes, ship to this address\";}}',0,1,'ShipToAddress',UNIX_TIMESTAMP(),12);

INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','First Name','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'FirstName',UNIX_TIMESTAMP(),1);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Last Name','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'LastName',UNIX_TIMESTAMP(),2);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Company Name','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',0,1,'CompanyName',UNIX_TIMESTAMP(),3);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Phone Number','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'Phone',UNIX_TIMESTAMP(),4);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Address Line 1','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'AddressLine1',UNIX_TIMESTAMP(),5);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Address Line 2','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',0,1,'AddressLine2',UNIX_TIMESTAMP(),6);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Suburb/City','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:16:\"Textbox Field200\";s:5:\"style\";s:0:\"\";}',1,1,'City',UNIX_TIMESTAMP(),7);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleselect','Country','','a:4:{s:5:\"class\";s:8:\"Field200\";s:5:\"style\";s:0:\"\";s:12:\"chooseprefix\";s:16:\"Choose a Country\";s:7:\"options\";a:0:{}}',1,1,'Country',UNIX_TIMESTAMP(),8);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'selectortext','State/Province','','a:6:{s:5:\"class\";s:8:\"Field200\";s:5:\"style\";s:0:\"\";s:12:\"chooseprefix\";s:14:\"Choose a State\";s:7:\"options\";a:0:{}s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}',1,1,'State',UNIX_TIMESTAMP(),9);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'singleline','Zip/Postcode','','a:5:{s:12:\"defaultvalue\";s:0:\"\";s:4:\"size\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:5:\"class\";s:15:\"Textbox Field45\";s:5:\"style\";s:11:\"width:40px;\";}',1,1,'Zip',UNIX_TIMESTAMP(),10);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'checkboxselect','Save This Address?','','a:3:{s:5:\"class\";s:0:\"\";s:5:\"style\";s:0:\"\";s:7:\"options\";a:1:{i:0;s:41:\"Yes, save this address to my address book\";}}',0,1,'SaveThisAddress',UNIX_TIMESTAMP(),11);
INSERT INTO `%%PREFIX%%formfields` VALUES (NULL,3,'checkboxselect','Ship to This Address?','','a:3:{s:5:\"class\";s:0:\"\";s:5:\"style\";s:0:\"\";s:7:\"options\";a:1:{i:0;s:25:\"Yes, ship to this address\";}}',0,1,'ShipToAddress',UNIX_TIMESTAMP(),12);

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%formsessions`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%formsessions` (
  `formsessionid` int(10) unsigned NOT NULL auto_increment,
  `formsessiondate` int (10) unsigned NOT NULL default '0',
  `formsessionformidx` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`formsessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%formfieldsessions`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%formfieldsessions` (
  `formfieldsessioniformsessionid` int(10) unsigned NOT NULL default '0',
  `formfieldfieldid` int(10) unsigned NOT NULL default '0',
  `formfieldformid` int(10) unsigned NOT NULL default '0',
  `formfieldfieldtype` varchar(50) NOT NULL default '',
  `formfieldfieldlabel` varchar(255) NOT NULL default '',
  `formfieldfieldvalue` TEXT,
  PRIMARY KEY  (`formfieldsessioniformsessionid`, `formfieldfieldid`),
  KEY `i_formfieldsessions_formfieldsessioniformsessionid` (`formfieldsessioniformsessionid`),
  KEY `i_formfieldsessions_formfieldfieldid` (`formfieldfieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%gift_certificate_history`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%gift_certificate_history` (
  `historyid` int(10) NOT NULL auto_increment,
  `histgiftcertid` int(10) NOT NULL default '0',
  `historderid` int(10) NOT NULL default '0',
  `histcustomerid` int(10) NOT NULL default '0',
  `histbalanceused` decimal(20,4) NOT NULL default '0.0000',
  `histbalanceremaining` decimal(20,4) NOT NULL default '0.0000',
  `historddate` int(10) NOT NULL default '0',
  PRIMARY KEY  (`historyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%gift_certificates`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%gift_certificates` (
  `giftcertid` int(10) NOT NULL auto_increment,
  `giftcertcode` varchar(20) NOT NULL default '',
  `giftcertto` varchar(100) NOT NULL default '',
  `giftcerttoemail` varchar(100) NOT NULL default '',
  `giftcertfrom` varchar(100) NOT NULL default '',
  `giftcertfromemail` varchar(100) NOT NULL default '',
  `giftcertcustid` int(10) NOT NULL default '0',
  `giftcertamount` decimal(20,4) NOT NULL default '0',
  `giftcertbalance` decimal(20,4) NOT NULL default '0',
  `giftcertstatus` int(1) NOT NULL default '0',
  `giftcerttemplate` varchar(50) NOT NULL default '',
  `giftcertmessage` varchar(250) NOT NULL default '',
  `giftcertpurchasedate` int(10) NOT NULL default '0',
  `giftcertexpirydate` int(10) NOT NULL default '0',
  `giftcertorderid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`giftcertid`),
  UNIQUE KEY `u_gift_certificates` (`giftcertcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%module_vars`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%module_vars` (
  `variableid` int(11) NOT NULL auto_increment,
  `modulename` varchar(100) NOT NULL default '',
  `variablename` varchar(100) NOT NULL default '',
  `variableval` text,
  PRIMARY KEY  (`variableid`),
  KEY `modulename` (`modulename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%news`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%news` (
  `newsid` int(11) NOT NULL auto_increment,
  `newstitle` varchar(250) NOT NULL default '',
  `newscontent` longtext,
  `newsdate` int(11) NOT NULL default '0',
  `newsvisible` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`newsid`),
  KEY `i_news_date_vis` (`newsdate`, `newsvisible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%order_coupons`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%order_coupons` (
  `ordcoupid` int(11) NOT NULL auto_increment,
  `ordcouporderid` int(11) NOT NULL default '0',
  `ordcoupprodid` int(11) NOT NULL default '0',
  `ordcouponid` int(11) NOT NULL default '0',
  `ordcouponcode` varchar(50) NOT NULL default '',
  `ordcouponamount` varchar(50) NOT NULL default '',
  `ordcoupontype` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ordcoupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%order_downloads`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%order_downloads` (
  `orddownid` int(11) NOT NULL auto_increment,
  `orderid` int(11) NOT NULL default '0',
  `downloadid` int(11) NOT NULL default '0',
  `numdownloads` int(11) NOT NULL default '0',
  `downloadexpires` int unsigned NOT NULL default '0',
  `maxdownloads` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`orddownid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%order_messages`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%order_messages` (
  `messageid` int(11) NOT NULL auto_increment,
  `messagefrom` enum('customer','admin') NOT NULL default 'customer',
  `subject` varchar(255) NOT NULL default '',
  `message` longtext,
  `datestamp` int(11) NOT NULL default '0',
  `messageorderid` int(11) NOT NULL default '0',
  `messagestatus` enum('read','unread') NOT NULL default 'read',
  `staffuserid` int(11) NOT NULL default '0',
  `isflagged` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`messageid`),
  KEY `i_order_mesages_messageorderid` (`messageorderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%order_products`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%order_products` (
  `orderprodid` int(11) NOT NULL auto_increment,
  `ordprodsku` varchar(250) NOT NULL default '',
  `ordprodname` varchar(250) NOT NULL default '',
  `ordprodtype` enum('physical','digital','giftcertificate') NOT NULL default 'physical',
  `ordprodcost` decimal(20,4) NOT NULL default '0',
  `ordprodoriginalcost` decimal(20, 4) NOT NULL default '0',
  `ordprodweight` double NOT NULL default '0',
  `ordprodqty` smallint(6) NOT NULL default '0',
  `orderorderid` int(11) NOT NULL default '0',
  `ordprodid` int(11) NOT NULL default '0',
  `ordprodcostprice` decimal(20,4) NOT NULL default '0',
  `ordoriginalprice` decimal(20,4) NOT NULL default '0',
  `ordprodrefunded` int(10) NOT NULL default '0',
  `ordprodrefundamount` decimal(20,4) NOT NULL default '0',
  `ordprodreturnid` int(10) NOT NULL default '0',
  `ordprodoptions` text,
  `ordprodvariationid` int(11) NOT NULL default '0',
  `ordprodwrapid` int unsigned NOT NULL default '0',
  `ordprodwrapname` varchar(100) NOT NULL default '',
  `ordprodwrapcost` decimal(20, 4) NOT NULL default '0.00',
  `ordprodwrapmessage` text NULL,
  `ordprodqtyshipped` int unsigned NOT NULL default '0',
  `ordprodeventname` VARCHAR(255),
  `ordprodeventdate` INT(9),
  `ordprodistaxable` tinyint(1) NOT NULL default '1',
  `ordprodfixedshippingcost` decimal(20,4) NOT NULL default '0',
  PRIMARY KEY  (`orderprodid`),
  KEY `i_order_products_orderid_prodid` (`orderorderid`, `ordprodid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%order_status`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%order_status` (
  `statusid` int(11) NOT NULL auto_increment,
  `statusdesc` varchar(100) NOT NULL default '',
  `statusorder` int(11) NOT NULL default 0,
  PRIMARY KEY  (`statusid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Data for table `%%PREFIX%%order_status`
--

TRUNCATE `%%PREFIX%%order_status`;
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (1, 'Pending', 1);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (2, 'Shipped', 8);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (3, 'Partially Shipped', 6);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (4, 'Refunded', 11);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (5, 'Cancelled', 9);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (6, 'Declined', 10);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (7, 'Awaiting Payment', 2);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (8, 'Awaiting Pickup', 5);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (9, 'Awaiting Shipment', 4);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (10, 'Completed', 7);
INSERT INTO `%%PREFIX%%order_status` (`statusid`, `statusdesc`, `statusorder`) VALUES (11, 'Awaiting Fulfillment', 3);

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%orders`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%orders` (
  `orderid` int(11) NOT NULL auto_increment,
  `ordtoken` varchar(32) NOT NULL default '0',
  `ordcustid` int(11) NOT NULL default '0',
  `orddate` int(11) NOT NULL default '0',
  `ordsubtotal` decimal(20,4) NOT NULL default '0',
  `ordtaxtotal` decimal(20,4) NOT NULL default '0',
  `ordtaxrate` decimal(10,4) NOT NULL default '0',
  `ordtaxname` varchar(100) NOT NULL default '',
  `ordtotalincludestax` int(1) NOT NULL default '0',
  `ordshipcost` decimal(20,4) NOT NULL default '0',
  `ordshipmethod` varchar(250) NOT NULL default '0',
  `ordershipmodule` varchar(100) NOT NULL default '',
  `ordhandlingcost` decimal(20,4) NOT NULL default '0',
  `ordtotalamount` decimal(20,4) NOT NULL default '0',
  `ordstatus` smallint(6) NOT NULL default '0',
  `ordtotalqty` int unsigned NOT NULL default '0',
  `ordtotalshipped` int unsigned NOT NULL default '0',
  `orderpaymentmethod` varchar(100) NOT NULL default '',
  `orderpaymentmodule` varchar(100) NOT NULL default '',
  `ordpayproviderid` varchar(255) DEFAULT NULL,
  `ordpaymentstatus` varchar(100) NOT NULL DEFAULT '',
  `ordrefundedamount` decimal(20, 4) NOT NULL DEFAULT 0,
  `ordbillfirstname` varchar(255) NOT NULL default '',
  `ordbilllastname` varchar(255) NOT NULL default '',
  `ordbillcompany` varchar(100) NOT NULL default '',
  `ordbillstreet1` varchar(255) NOT NULL default '',
  `ordbillstreet2` varchar(255) NOT NULL default '',
  `ordbillsuburb` varchar(100) NOT NULL default '',
  `ordbillstate` varchar(50) NOT NULL default '',
  `ordbillzip` varchar(20) NOT NULL default '',
  `ordbillcountry` varchar(50) NOT NULL default '',
  `ordbillcountrycode` varchar(2) NOT NULL default '',
  `ordbillcountryid` int(11) NOT NULL default '0',
  `ordbillstateid` int(11) NOT NULL default '0',
  `ordbillphone` varchar(50) NOT NULL default '',
  `ordbillemail` varchar(250) NOT NULL default '',
  `ordshipfirstname` varchar(100) NOT NULL default '',
  `ordshiplastname` varchar(100) NOT NULL default '',
  `ordshipcompany` varchar(100) NOT NULL default '',
  `ordshipstreet1` varchar(255) NOT NULL default '',
  `ordshipstreet2` varchar(255) NOT NULL default '',
  `ordshipsuburb` varchar(100) NOT NULL default '',
  `ordshipstate` varchar(50) NOT NULL default '',
  `ordshipzip` varchar(20) NOT NULL default '',
  `ordshipcountry` varchar(50) NOT NULL default '',
  `ordshipcountrycode` varchar(2) NOT NULL default '',
  `ordshipcountryid` int(11) NOT NULL default '0',
  `ordshipstateid` int(11) NOT NULL default '0',
  `ordshipphone` varchar(50) NOT NULL default '',
  `ordshipemail` varchar(250) NOT NULL default '',
  `ordisdigital` tinyint(4) NOT NULL default '0',
  `ordtrackingno` varchar(100) NOT NULL default '',
  `orddateshipped` int(11) NOT NULL default '0',
  `ordgatewayamount` decimal(20,4) NOT NULL default '0',
  `ordstorecreditamount` decimal(20,4) NOT NULL default '0',
  `ordgiftcertificateamount` decimal(20,4) NOT NULL default '0',
  `ordinventoryupdated` int(1) NOT NULL default '0',
  `ordonlygiftcerts` tinyint(4) NOT NULL default '0',
  `extrainfo` text,
  `ordipaddress` varchar(30) NOT NULL default '',
  `ordgeoipcountry` varchar(50) NOT NULL default '',
  `ordgeoipcountrycode` varchar(2) NOT NULL default '',
  `ordcurrencyid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `orddefaultcurrencyid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `ordcurrencyexchangerate` DECIMAL(20,10) NOT NULL DEFAULT '0',
  `ordshippingzoneid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `ordshippingzone` VARCHAR(200) NOT NULL DEFAULT '',
  `ordnotes` TEXT,
  `ordcustmessage` TEXT,
  `ordvendorid` int unsigned NOT NULL default '0',
  `ordformsessionid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`orderid`),
  KEY `i_orders_ordcustid` (`ordcustid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%pages`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%pages` (
  `pageid` int(11) NOT NULL auto_increment,
  `pagetitle` varchar(250) NOT NULL default '',
  `pagelink` varchar(250) NOT NULL default '',
  `pagefeed` varchar(250) NOT NULL default '',
  `pageemail` varchar(250) NOT NULL default '',
  `pagecontent` longtext,
  `pagestatus` tinyint(4) NOT NULL default '0',
  `pageparentid` int(11) NOT NULL default '0',
  `pagesort` int(11) NOT NULL default '0',
  `pagekeywords` text,
  `pagedesc` text,
  `pagetype` tinyint(4) NOT NULL default '0',
  `pagecontactfields` varchar(100) NOT NULL,
  `pagemetakeywords` varchar(250) NOT NULL default '',
  `pagemetadesc` varchar(250) NOT NULL default '',
  `pageishomepage` tinyint(4) NOT NULL default '0',
  `pagelayoutfile` varchar(50) NOT NULL default '',
  `pageparentlist` text,
  `pagecustomersonly` tinyint(1) NOT NULL default '0',
  `pagevendorid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%permissions`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%permissions` (
  `pk_permid` int(11) NOT NULL auto_increment,
  `permuserid` int(11) NOT NULL default '0',
  `permpermissionid` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`pk_permid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_customfields`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_customfields` (
  `fieldid` int(11) NOT NULL auto_increment,
  `fieldprodid` int(11) NOT NULL default '0',
  `fieldname` varchar(250) NOT NULL default '',
  `fieldvalue` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`fieldid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_downloads`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_downloads` (
  `downloadid` int(11) NOT NULL auto_increment,
  `prodhash` varchar(32) NOT NULL default '',
  `productid` int(11) NOT NULL default '0',
  `downfile` varchar(200) NOT NULL default '',
  `downdateadded` int(11) NOT NULL default '0',
  `downmaxdownloads` int(11) NOT NULL default '0',
  `downexpiresafter` int(11) NOT NULL default '0',
  `downfilesize` int(11) NOT NULL default '0',
  `downname` varchar(200) NOT NULL default '',
  `downdescription` text,
  PRIMARY KEY  (`downloadid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_images`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_images` (
  `imageid` int(11) NOT NULL auto_increment,
  `imageprodid` int(11) NOT NULL default '0',
  `imageprodhash` varchar(32) NOT NULL default '',
  `imagefile` varchar(255) NOT NULL default '',
  `imageisthumb` tinyint(4) NOT NULL default '0',
  `imagesort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`imageid`),
  KEY `i_product_images_imageprodid` (`imageprodid`, `imageisthumb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_search`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_search` (
  `productsearchid` int(11) NOT NULL auto_increment,
  `productid` int(11) NOT NULL default '0',
  `prodname` varchar(250) NOT NULL default '',
  `prodcode` varchar(250) NOT NULL default '',
  `proddesc` longtext,
  `prodsearchkeywords` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`productsearchid`),
  FULLTEXT KEY `prodname` (`prodname`,`prodcode`,`proddesc`,`prodsearchkeywords`),
  FULLTEXT KEY `prodname2` (`prodname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_variation_combinations`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_variation_combinations` (
  `combinationid` int(11) NOT NULL auto_increment,
  `vcproductid` int(11) NOT NULL default '0',
  `vcproducthash` varchar(32) NOT NULL default '',
  `vcvariationid` int(11) NOT NULL default '0',
  `vcenabled` tinyint(4) NOT NULL default '1',
  `vcoptionids` varchar(100) NOT NULL default '',
  `vcsku` varchar(50) NOT NULL default '',
  `vcpricediff` enum('','add','subtract','fixed') NOT NULL default '',
  `vcprice` decimal(20,4) NOT NULL default '0',
  `vcweightdiff` enum('','add','subtract','fixed') NOT NULL default '',
  `vcweight` decimal(20,4) NOT NULL default '0',
  `vcimage` varchar(100) NOT NULL default '',
  `vcthumb` varchar(100) NOT NULL default '',
  `vcstock` int(11) NOT NULL default '0',
  `vclowstock` int(11) NOT NULL default '0',
  PRIMARY KEY  (`combinationid`),
  KEY `i_product_variation_combinations_vcvariationid` (`vcvariationid`),
  KEY `i_product_variation_combinations_vcproductid` (`vcproductid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_variation_options`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_variation_options` (
  `voptionid` int(11) NOT NULL auto_increment,
  `vovariationid` int(11) NOT NULL default '0',
  `voname` varchar(255) NOT NULL default '',
  `vovalue` text,
  `vooptionsort` int(11) NOT NULL default '0',
  `vovaluesort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`voptionid`),
  KEY `i_product_variation_options_vovariationid` (`vovariationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_variations`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_variations` (
  `variationid` int(11) NOT NULL auto_increment,
  `vname` varchar(100) NOT NULL default '',
  `vnumoptions` int(11) NOT NULL default '0',
  `vvendorid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`variationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_words`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_words` (
  `wordid` int(11) NOT NULL auto_increment,
  `word` varchar(255) NOT NULL default '',
  `productid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`wordid`),
  KEY `word` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%products`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%products` (
  `productid` int(11) NOT NULL auto_increment,
  `prodname` varchar(250) NOT NULL default '',
  `prodtype` smallint(6) NOT NULL default '0',
  `prodcode` varchar(250) NOT NULL default '',
  `prodfile` varchar(250) NOT NULL default '',
  `proddesc` longtext,
  `prodsearchkeywords` varchar(250) NOT NULL default '',
  `prodavailability` varchar(250) NOT NULL default '',
  `prodprice` decimal(20,4) NOT NULL default '0',
  `prodcostprice` decimal(20,4) NOT NULL default '0',
  `prodretailprice` decimal(20,4) NOT NULL default '0',
  `prodsaleprice` decimal(20,4) NOT NULL default '0',
  `prodcalculatedprice` decimal(20,4) NOT NULL default '0',
  `prodistaxable` tinyint(1) NOT NULL default '1',
  `prodsortorder` int(11) NOT NULL default '0',
  `prodvisible` tinyint(4) NOT NULL default '0',
  `prodfeatured` tinyint(4) NOT NULL default '0',
  `prodvendorfeatured` tinyint(1) NOT NULL default '0',
  `prodrelatedproducts` varchar(250) NOT NULL default '',
  `prodcurrentinv` int(11) NOT NULL default '0',
  `prodlowinv` int(11) NOT NULL default '0',
  `prodoptionsrequired` tinyint(4) NOT NULL default '0',
  `prodwarranty` text,
  `prodweight` decimal(20,4) NOT NULL default '0',
  `prodwidth` decimal(20,4) NOT NULL default '0',
  `prodheight` decimal(20,4) NOT NULL default '0',
  `proddepth` decimal(20,4) NOT NULL default '0',
  `prodfixedshippingcost` decimal(20,4) NOT NULL default '0',
  `prodfreeshipping` tinyint(4) NOT NULL default '0',
  `prodinvtrack` tinyint(4) NOT NULL default '0',
  `prodratingtotal` int(11) NOT NULL default '0',
  `prodnumratings` int(11) NOT NULL default '0',
  `prodnumsold` int(11) NOT NULL default '0',
  `proddateadded` int(11) NOT NULL default '0',
  `prodbrandid` int(11) NOT NULL default '0',
  `prodnumviews` int(11) NOT NULL default '0',
  `prodpagetitle` varchar(250) NOT NULL default '',
  `prodmetakeywords` text,
  `prodmetadesc` text,
  `prodlayoutfile` varchar(50) NOT NULL default '',
  `prodvariationid` int(11) NOT NULL default '0',
  `prodallowpurchases` int(1) NOT NULL default '1',
  `prodhideprice` int(1) NOT NULL default '0',
  `prodcallforpricinglabel` varchar(200) NOT NULL default '',
  `prodcatids` text NOT NULL,
  `prodlastmodified` int unsigned NOT NULL default '0',
  `prodvendorid` int unsigned NOT NULL default '0',
  `prodhastags` int(1) NOT NULL default '0',
  `prodwrapoptions` text NULL,
  `prodconfigfields` varchar(255) NOT NULL default '',
  `prodeventdaterequired` tinyint(4),
  `prodeventdatefieldname` varchar(255),
  `prodeventdatelimited` tinyint(4),
  `prodeventdatelimitedtype` tinyint(4),
  `prodeventdatelimitedstartdate` int(9),
  `prodeventdatelimitedenddate` int(9),
  `prodmyobasset` VARCHAR(20) NOT NULL default '',
  `prodmyobincome` VARCHAR(20) NOT NULL default '',
  `prodmyobexpense` VARCHAR(20) NOT NULL default '',
  `prodpeachtreegl` VARCHAR(20) NOT NULL default '',
  PRIMARY KEY  (`productid`),
  KEY `i_products_brand_vis` (`prodbrandid`, `prodvisible`),
  UNIQUE KEY `u_products_prodname` (`prodname`),
  KEY `i_products_prodnumsold` (`prodnumsold`),
  KEY `i_products_feature_vis` (`prodfeatured`, `prodvisible`),
  KEY `i_products_rating_vis` (`prodvisible`, `prodratingtotal`),
  KEY `i_products_added_vis` (`prodvisible`, `proddateadded`),
  KEY `i_products_hideprice_vis` (`prodhideprice`, `prodvisible`),
  KEY `i_products_sortorder_vis` (`prodvisible`, `prodsortorder`, `prodname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%returns`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%returns` (
  `returnid` int(10) NOT NULL auto_increment,
  `retorderid` int(10) NOT NULL default '0',
  `retcustomerid` int(10) NOT NULL default '0',
  `retprodid` int(10) NOT NULL default '0',
  `retprodvariationid` INT( 11 ) NOT NULL default '0',
  `retprodoptions` text,
  `retprodname` varchar(200) NOT NULL default '',
  `retprodcost` decimal(20,4) NOT NULL default '0',
  `retprodqty` int(1) NOT NULL default '1',
  `retstatus` int(1) NOT NULL default '0',
  `retreason` varchar(200) NOT NULL default '',
  `retaction` varchar(200) NOT NULL default '',
  `retdaterequested` int(10) NOT NULL default '0',
  `retcomment` text,
  `retuserid` int(10) NOT NULL default '0',
  `retreceivedcredit` int(1) NOT NULL default '0',
  `retordprodid` int(10) NOT NULL default '0',
  `retstaffnotes` text,
  `retvendorid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`returnid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%reviews`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%reviews` (
  `reviewid` int(11) NOT NULL auto_increment,
  `revproductid` int(11) NOT NULL default '0',
  `revfromname` varchar(100) NOT NULL default '',
  `revdate` int(11) NOT NULL default '0',
  `revrating` smallint(6) NOT NULL default '0',
  `revtext` text,
  `revtitle` varchar(250) NOT NULL default '',
  `revstatus` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`reviewid`),
  KEY `i_reviews_revproductid` (`revproductid`),
  FULLTEXT KEY `ft_reviews_text_title_from` (`revtext`,`revtitle`,`revfromname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%search_corrections`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%search_corrections` (
  `correctionid` int(11) NOT NULL auto_increment,
  `correctiontype` enum('correction','recommendation') NOT NULL default 'correction',
  `correction` varchar(250) NOT NULL default '',
  `numresults` int(11) NOT NULL default '0',
  `oldsearchtext` varchar(250) NOT NULL default '',
  `oldnumresults` int(11) NOT NULL default '0',
  `correctdate` int(11) NOT NULL default '0',
  PRIMARY KEY  (`correctionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%searches`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%searches` (
  `searchid` int(11) NOT NULL auto_increment,
  `searchtext` text,
  `numsearches` int(11) NOT NULL default '0',
  PRIMARY KEY  (`searchid`),
  FULLTEXT KEY `searchtext` (`searchtext`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%searches_extended`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%searches_extended` (
  `searchid` int(11) NOT NULL auto_increment,
  `searchtext` text,
  `numresults` int(11) NOT NULL default '0',
  `searchdate` int(11) NOT NULL default '0',
  `clickthru` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`searchid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%sessions`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%sessions` (
  `sessionid` int(10) unsigned NOT NULL auto_increment,
  `sessionhash` varchar(32) NOT NULL default '',
  `sessdata` longtext,
  `sesslastupdated` int(10) NOT NULL default '0',
  PRIMARY KEY  (`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%shipping_addresses`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%shipping_addresses` (
  `shipid` int(11) NOT NULL auto_increment,
  `shipcustomerid` int(11) NOT NULL default '0',
  `shipfirstname` varchar(255) NOT NULL default '',
  `shiplastname` varchar(255) NOT NULL default '',
  `shipcompany` varchar(255) NOT NULL default '',
  `shipaddress1` text,
  `shipaddress2` text,
  `shipcity` varchar(100) NOT NULL default '',
  `shipstate` varchar(100) NOT NULL default '',
  `shipzip` varchar(30) NOT NULL default '',
  `shipcountry` varchar(100) NOT NULL default '',
  `shipphone` varchar(50) NOT NULL default '',
  `shipstateid` int(11) NOT NULL default '0',
  `shipcountryid` int(11) NOT NULL default '0',
  `shipdestination` enum('residential','commercial') NOT NULL default 'residential',
  `shiplastused` int(11) NOT NULL default '0',
  `shipformsessionid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`shipid`),
  KEY `i_shipping_addresses_shipcustomerid` (`shipcustomerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%subscribers`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%subscribers` (
  `subscriberid` int(11) NOT NULL auto_increment,
  `subemail` varchar(250) NOT NULL default '',
  `subfirstname` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`subscriberid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%system_log`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%system_log` (
  `logid` int(11) NOT NULL auto_increment,
  `logtype` enum('general','php','sql','shipping','payment','notification','ssnx') default NULL,
  `logmodule` varchar(100) NOT NULL default '',
  `logseverity` int(1) NOT NULL default '4',
  `logsummary` varchar(250) NOT NULL  default '',
  `logmsg` longtext,
  `logdate` int(11) NOT NULL default '0',
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%tax_rates`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%tax_rates` (
  `taxrateid` int(11) NOT NULL auto_increment,
  `taxratename` varchar(50) NOT NULL default '',
  `taxratepercent` decimal(20,4) NOT NULL default '0',
  `taxratecountry` text,
  `taxratestates` text,
  `taxratebasedon` enum('subtotal','subtotal_and_shipping') NOT NULL default 'subtotal',
  `taxaddress` enum('billing','shipping') NOT NULL default 'billing',
  `taxratestatus` tinyint(4) NOT NULL,
  PRIMARY KEY  (`taxrateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data for table `%%PREFIX%%tax_rates`
--


-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%unique_visitors`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%unique_visitors` (
  `uniqueid` int(11) NOT NULL auto_increment,
  `datestamp` int(11) NOT NULL default '0',
  `numuniques` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uniqueid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%users`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%users` (
  `pk_userid` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `userpass` varchar(50) NOT NULL default '',
  `userfirstname` varchar(50) NOT NULL default '',
  `userlastname` varchar(50) NOT NULL default '',
  `userstatus` tinyint(1) NOT NULL default '0',
  `useremail` varchar(250) NOT NULL default '',
  `userimportpass` varchar(100) NOT NULL default '',
  `token` varchar(50) NOT NULL default '',
  `usertoken` varchar(50) NOT NULL default '',
  `userapi` tinyint(4) NOT NULL default '0',
  `uservendorid` int unsigned NOT NULL default '0',
  `userrole` varchar(20) NOT NULL default 'custom',
  PRIMARY KEY  (`pk_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%wishlists`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%wishlists` (
 `wishlistid` int(11) NOT NULL auto_increment,
  `customerid` int(11) NOT NULL,
  `wishlistname` varchar(255) NOT NULL,
  `ispublic` tinyint(4) NOT NULL,
  `wishlisttoken` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`wishlistid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `isc_wishlist_items`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%wishlist_items` (
  `wishlistitemid` int(11) NOT NULL auto_increment,
  `wishlistid` int(11) NOT NULL,
  `productid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`wishlistitemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DELETE FROM `%%PREFIX%%users` WHERE username='admin';
INSERT INTO `%%PREFIX%%users`(pk_userid, username, userpass, userstatus, token, usertoken, userapi, useremail,userrole) values(0, 'admin', '%%PASS%%', '1', '%%TOKEN%%', '', '0', '%%EMAIL%%','admin');

--
-- Create the default returns & shipping page
--

INSERT INTO `%%PREFIX%%pages` (`pagetitle`, `pagelink`, `pagefeed`, `pageemail`, `pagecontent`, `pagestatus`, `pageparentid`, `pagesort`, `pagekeywords`, `pagedesc`, `pagetype`, `pagecontactfields`, `pagemetakeywords`, `pagemetadesc`, `pageishomepage`, `pagelayoutfile`, `pageparentlist`) VALUES ('RSS Syndication','', '', '', '%%Syndicate%%',1, 0, 3, '', '', 0, '', '', '', 0, '', 0);

INSERT INTO `%%PREFIX%%pages` (`pageid`, `pagetitle`, `pagelink`, `pagefeed`, `pageemail`, `pagecontent`, `pagestatus`, `pageparentid`, `pagesort`, `pagekeywords`, `pagedesc`, `pagetype`, `pagecontactfields`, `pagemetakeywords`, `pagemetadesc`, `pageishomepage`, `pagelayoutfile`, `pageparentlist`) VALUES (0, 'Shipping & Returns', 'http://', 'http://', '', '<em>To edit this page simply login to the control panel, click the <strong style="font-weight: 400">Website Content</strong> tab and choose the </em> <strong style="font-weight: 400"><em>View Web Pages option. Click Edit next to the Shipping & Returns page and you can change this text. A sample returns policy is shown below which you can edit as needed.</em><em style="font-style: normal"><br/><br/></em></strong><em style="font-style: normal"><strong>Returns Policy</strong></em><strong style="font-weight: 400"></em></em><em style="font-style: normal"><br/><br/></em>You may return most new, unopened items within 30 days of delivery for a full refund. We''ll also pay the return shipping costs if the return is a result of our error (you received an incorrect or defective item, etc.).<br/><br/>You should expect to receive your refund within four weeks of giving your package to the return shipper, however, in many cases you will receive a refund more quickly. This time period includes the transit time for us to receive your return from the shipper (5 to 10 business days), the time it takes us to process your return once we receive it (3 to 5 business days), and the time it takes your bank to process our refund request (5 to 10 business days).<br/><br/>If you need to return an item, simply login to your account, view the order using the "Complete Orders" link under the My Account menu and click the Return Item(s) button. We''ll notify you via e-mail of your refund once we''ve received and processed the returned item.<br/><br/></strong><strong>Shipping</em></em></em></strong><strong style="font-weight: 400"><em style="font-style: normal"><br/><br/></em>We can ship to virtually any address in the world. Note that there are restrictions on some products, and some products cannot be shipped to international destinations.<br/><br/>When you place an order, we will estimate shipping and delivery dates for you based on the availability of your items and the shipping options you choose. Depending on the shipping provider you choose, shipping date estimates may appear on the shipping quotes page.<br/><br/>Please also note that the shipping rates for many items we sell are weight-based. The weight of any such item can be found on its detail page. To reflect the policies of the shipping companies we use, all weights will be rounded up to the next full pound.<br/>', 1, 0, 2, '', '', 0, '', '', '', 0, 'page.html', '0');

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%users`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%customer_groups` (
  `customergroupid` int(11) NOT NULL auto_increment,
  `groupname` varchar(255) NOT NULL,
  `discount` decimal(10,4) NOT NULL,
  `discountmethod` VARCHAR( 100 ) NOT NULL,
  `isdefault` tinyint(4) NOT NULL,
  `categoryaccesstype` enum('none','all','specific') NOT NULL,
  PRIMARY KEY  (`customergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `%%PREFIX%%customer_group_categories` (
	`customergroupid` int(11) NOT NULL,
	`categoryid` int(11) NOT NULL,
	PRIMARY KEY  (`customergroupid`,`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS %%PREFIX%%transactions (
	id int unsigned not null auto_increment PRIMARY KEY,
	orderid int unsigned default NULL,
	transactionid varchar(160) default NULL,
	providerid varchar(160),
	amount DECIMAL(20, 4) NOT NULL,
	message text not null,
	status int unsigned default 0,
	transactiondate int not null,
	extrainfo text,
	KEY `i_order_transation` (orderid, transactionid),
	KEY `i_transaction_provider` (transactionid, providerid)
) TYPE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `%%PREFIX%%customer_group_discounts`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%customer_group_discounts` (
  `groupdiscountid` INT NOT NULL AUTO_INCREMENT ,
  `customergroupid` INT NOT NULL ,
  `discounttype` ENUM( 'CATEGORY', 'PRODUCT' ) NOT NULL ,
  `catorprodid` INT NOT NULL ,
  `discountpercent` DECIMAL( 10, 4 ) NOT NULL ,
  `appliesto` ENUM( 'CATEGORY_ONLY', 'CATEGORY_AND_SUBCATS', 'NOT_APPLICABLE' ) NOT NULL ,
  `discountmethod` VARCHAR(100) NOT NULL ,
PRIMARY KEY ( `groupdiscountid` )
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%shipping_methods` (
  `methodid` int(10) unsigned NOT NULL auto_increment,
  `zoneid` int(10) unsigned NOT NULL default '0',
  `methodname` varchar(150) NOT NULL default '',
  `methodmodule` varchar(100) NOT NULL default '',
  `methodhandlingfee` decimal(20,4) NOT NULL default '0.0000',
  `methodenabled` int(1) NOT NULL default '1',
  `methodvendorid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`methodid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%shipping_vars` (
  `variableid` int(11) NOT NULL auto_increment,
  `methodid` int(10) unsigned NOT NULL default '0',
  `zoneid` int(10) unsigned NOT NULL default '0',
  `modulename` varchar(100) NOT NULL default '',
  `variablename` varchar(100) NOT NULL default '',
  `variableval` text,
  `varvendorid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`variableid`),
  KEY `modulename` (`modulename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%shipping_zones` (
  `zoneid` int(10) unsigned NOT NULL auto_increment,
  `zonename` varchar(100) NOT NULL default '',
  `zonetype` enum('country','state','zip') default 'country',
  `zonefreeshipping` int(1) NOT NULL default '0',
  `zonefreeshippingtotal` decimal(20,4) NOT NULL default '0.0000',
  `zonehandlingtype` enum('none','global','module') default 'none',
  `zonehandlingfee` decimal(20,4) NOT NULL default '0.0000',
  `zonehandlingseparate` int(1) NOT NULL default '1',
  `zoneenabled` int(1) NOT NULL default '1',
  `zonevendorid` int unsigned NOT NULL default '0',
  `zonedefault` int(1) NOT NULL default '0',
  PRIMARY KEY  (`zoneid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%shipping_zone_locations` (
  `locationid` int(10) unsigned NOT NULL auto_increment,
  `zoneid` int(10) unsigned NOT NULL default '0',
  `locationtype` enum('country','state','zip') default 'country',
  `locationvalueid` int(10) unsigned NOT NULL default '0',
  `locationvalue` varchar(100) NOT NULL default '0',
  `locationcountryid` int(10) unsigned NOT NULL default '0',
  `locationvendorid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`locationid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `%%PREFIX%%vendors` (
	`vendorid` int unsigned NOT NULL auto_increment,
	`vendorname` varchar(200) NOT NULL default '',
	`vendorfriendlyname` varchar(100) NOT NULL default '',
	`vendorphone` varchar(50) NOT NULL default '',
	`vendorbio` text NOT NULL,
	`vendoraddress` varchar(200) NOT NULL default '',
	`vendorcity` varchar(100) NOT NULL default '',
	`vendorcountry` varchar(100) NOT NULL default '',
	`vendorstate` varchar(100) NOT NULL default '',
	`vendorzip` varchar(20) NOT NULL default '',
	`vendornumsales` int unsigned NOT NULL default '0',
	`vendororderemail` varchar(200) NOT NULL default '',
	`vendorshipping` int(1) NOT NULL default '0',
	`vendoremail` varchar(200) NOT NULL default '',
	`vendoraccesscats` text NULL,
	`vendorlogo` varchar(200) NOT NULL default '',
	`vendorphoto` varchar(200) NOT NULL default '',
	`vendorprofitmargin` decimal(20,4) NOT NULL default '0.00',
	PRIMARY KEY(vendorid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS %%PREFIX%%product_tags(
	 tagid INT UNSIGNED NOT NULL AUTO_INCREMENT ,
	 tagname VARCHAR( 100 ) NOT NULL DEFAULT  '',
	 tagfriendlyname VARCHAR( 100 ) NOT NULL DEFAULT  '',
	 tagcount INT UNSIGNED NOT NULL DEFAULT  '0',
	 PRIMARY KEY ( tagid )
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS %%PREFIX%%product_tagassociations(
	 tagassocid INT UNSIGNED NOT NULL AUTO_INCREMENT ,
	 tagid INT UNSIGNED NOT NULL DEFAULT  '0',
	 productid INT UNSIGNED NOT NULL DEFAULT  '0',
	 PRIMARY KEY ( tagassocid )
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS %%PREFIX%%gift_wrapping (
	wrapid int unsigned NOT NULL auto_increment,
	wrapname varchar(100) NOT NULL default '',
	wrapprice decimal(20, 4) NOT NULL default '0.00',
	wrapvisible int(1) NOT NULL default '0',
	wrapallowcomments int(1) NOT NULL default '0',
	wrappreview varchar(100) NOT NULL default '',
	PRIMARY KEY(wrapid)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS [|PREFIX|]shipments (
	shipmentid int unsigned NOT NULL auto_increment,
	shipcustid int unsigned NOT NULL default '0',
	shipvendorid int unsigned NOT NULL default '0',
	shipdate int(11) NOT NULL default '0',
	shiptrackno varchar(50) NOT NULL default '',
	shipmethod varchar(100) NOT NULL default '',
	shiporderid int unsigned NOT NULL default '0',
	shiporderdate int(11) NOT NULL default '0',
	shipcomments TEXT NULL,
	shipbillfirstname varchar(255) NOT NULL default '',
	shipbilllastname varchar(255) NOT NULL default '',
	shipbillcompany varchar(100) NOT NULL default '',
	shipbillstreet1 varchar(255) NOT NULL default '',
	shipbillstreet2 varchar(255) NOT NULL default '',
	shipbillsuburb varchar(100) NOT NULL default '',
	shipbillstate varchar(50) NOT NULL default '',
	shipbillzip varchar(20) NOT NULL default '',
	shipbillcountry varchar(50) NOT NULL default '',
	shipbillcountrycode varchar(2) NOT NULL default '',
	shipbillcountryid int(11) NOT NULL default '0',
	shipbillstateid int(11) NOT NULL default '0',
	shipbillphone varchar(50) NOT NULL default '',
	shipbillemail varchar(250) NOT NULL default '',
	shipshipfirstname varchar(100) NOT NULL default '',
	shipshiplastname varchar(100) NOT NULL default '',
	shipshipcompany varchar(100) NOT NULL default '',
	shipshipstreet1 varchar(255) NOT NULL default '',
	shipshipstreet2 varchar(255) NOT NULL default '',
	shipshipsuburb varchar(100) NOT NULL default '',
	shipshipstate varchar(50) NOT NULL default '',
	shipshipzip varchar(20) NOT NULL default '',
	shipshipcountry varchar(50) NOT NULL default '',
	shipshipcountrycode varchar(2) NOT NULL default '',
	shipshipcountryid int(11) NOT NULL default '0',
	shipshipstateid int(11) NOT NULL default '0',
	shipshipphone varchar(50) NOT NULL default '',
	shipshipemail varchar(250) NOT NULL default '',
	PRIMARY KEY(shipmentid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS [|PREFIX|]shipment_items (
	itemid int unsigned NOT NULL auto_increment,
	shipid int unsigned NOT NULL default '0',
	itemprodid int unsigned NOT NULL default '0',
	itemordprodid int unsigned NOT NULL default '0',
	itemprodsku varchar(250) NOT NULL default '',
	itemprodname varchar(250) NOT NULL default '',
	itemqty int unsigned NOT NULL default '0',
	itemprodoptions text NULL,
	itemprodvariationid int unsigned NOT NULL default '0',
	itemprodeventname VARCHAR(255),
	itemprodeventdate INT(9),
	PRIMARY KEY(itemid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS [|PREFIX|]vendor_payments (
	paymentid int unsigned NOT NULL auto_increment,
	paymentfrom int(11) NOT NULL default '0',
	paymentto int(11) NOT NULL default '0',
	paymentvendorid int unsigned NOT NULL default '0',
	paymentamount decimal(20, 4) NOT NULL default '0.0000',
	paymentforwardbalance decimal(20, 4) NOT NULL default '0.0000',
	paymentdate int(11) NOT NULL default '0',
	paymentdeducted int(1) NOT NULL default '0',
	paymentmethod varchar(100) NOT NULL default '',
	paymentcomments text NULL,
	PRIMARY KEY(paymentid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `%%PREFIX%%product_discounts`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_discounts` (
 `discountid` INT NOT NULL auto_increment,
 `discountprodid` INT NOT NULL default '0',
 `discountquantitymin` INT NOT NULL default '0',
 `discountquantitymax` INT NOT NULL default '0',
 `discounttype` ENUM('price', 'percent', 'fixed') NOT NULL default 'price',
 `discountamount` DECIMAL(20,4) NOT NULL default '0',
 PRIMARY KEY (`discountid`),
 INDEX `i_product_discounts_discountprodid` (`discountprodid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `%%PREFIX%%product_configurable_fields` (
  `productfieldid` int(11) NOT NULL auto_increment,
  `fieldprodid` int(11) NOT NULL default '0',
  `fieldname` varchar(255) NOT NULL default '',
  `fieldtype` varchar(255) NOT NULL default '',
  `fieldfiletype` varchar(255) NOT NULL default '',
  `fieldfilesize` int(11) NOT NULL default '0',
  `fieldrequired` tinyint(4) NOT NULL default '0',
  `fieldsortorder` int(11) NOT NULL default '1',
  PRIMARY KEY  (`productfieldid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `%%PREFIX%%order_configurable_fields` (
  `orderfieldid` int(11) NOT NULL auto_increment,
  `fieldid` int(11) NOT NULL default '0',
  `orderid` int(11) NOT NULL default '0',
  `ordprodid` int(11) NOT NULL default '0',
  `productid` int(11) NOT NULL default '0',
  `textcontents` text NULL,
  `filename` varchar(255) NOT NULL default '',
  `filetype` varchar(255) NOT NULL default '',
  `originalfilename` varchar(255) NOT NULL default '',
  `fieldname` varchar(255) NOT NULL default '',
  `fieldtype` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`orderfieldid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%export_templates` (
	`exporttemplateid` int(11) unsigned NOT NULL auto_increment,
	`exporttemplatename` varchar(100) NOT NULL,
	`myobassetaccount` varchar(20) NOT NULL,
	`myobincomeaccount` varchar(20) NOT NULL,
	`myobexpenseaccount` varchar(20) NOT NULL,
	`peachtreereceivableaccount` varchar(20) NOT NULL,
	`peachtreeglaccount` varchar(20) NOT NULL,
	`modifyforpeachtree` tinyint(1) unsigned NOT NULL,
	`dateformat` varchar(15) NOT NULL,
	`priceformat` varchar(15) NOT NULL,
	`boolformat` varchar(15) NOT NULL,
	`blankforfalse` tinyint(1) unsigned NOT NULL,
	`vendorid` int(11) unsigned NOT NULL,
	`usedtypes` varchar(63) NOT NULL,
	`builtin` tinyint(1) unsigned NOT NULL,
	PRIMARY KEY  (`exporttemplateid`),
	KEY `exporttemplatename` (`exporttemplatename`),
	KEY `vendorid` (`vendorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%export_template_fields` (
	`exporttemplatefieldid` smallint(5) unsigned NOT NULL auto_increment,
	`exporttemplateid` smallint(5) unsigned NOT NULL,
	`fieldid` varchar(31) NOT NULL,
	`fieldtype` varchar(31) NOT NULL,
	`fieldname` varchar(63) NOT NULL,
	`includeinexport` tinyint(1) unsigned NOT NULL,
	`sortorder` tinyint(3) unsigned NOT NULL,
	PRIMARY KEY  (`exporttemplatefieldid`),
	KEY `exporttemplateid` (`exporttemplateid`,`fieldtype`,`includeinexport`,`sortorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%export_method_settings` (
	`exportmethodid` int(11) unsigned NOT NULL auto_increment,
	`methodname` varchar(15) NOT NULL,
	`exporttemplateid` int(11) unsigned NOT NULL,
	`variablename` varchar(31) NOT NULL,
	`variablevalue` varchar(31) NOT NULL,
	PRIMARY KEY  (`exportmethodid`),
	KEY `methodname` (`methodname`,`exporttemplateid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `%%PREFIX%%discounts` (
	`discountid` int(11) NOT NULL auto_increment,
	`discountname` varchar(100) NOT NULL,
	`discountruletype` varchar(100) NOT NULL,
	`discountmaxuses` int(11) NOT NULL default '0',
	`discountcurrentuses` int(11) NOT NULL default '0',
	`discountexpiry` int(11) NOT NULL default '0',
	`discountenabled` tinyint(4) NOT NULL default '0',
	`sortorder` int(9) NOT NULL,
	`halts` int(1) NOT NULL,
	`configdata` text NOT NULL,
	PRIMARY KEY  (`discountid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Default template

INSERT INTO `%%PREFIX%%export_templates` (`exporttemplateid`, `exporttemplatename`, `myobassetaccount`, `myobincomeaccount`, `myobexpenseaccount`, `peachtreereceivableaccount`, `peachtreeglaccount`, `modifyforpeachtree`, `dateformat`, `priceformat`, `boolformat`, `blankforfalse`, `vendorid`, `usedtypes`, `builtin`) VALUES (1, 'Default', '', '', '', '', '', 0, 'dmy-slash', 'number', 'yn', 0, 0, 'customers,orders,products', 1);

INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'FieldSeparator', ',');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'FieldEnclosure', '"');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'IncludeHeader', '1');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'BlankLine', '0');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'SubItems', '1');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'SubItemSeparator', '|');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'LineEnding', 'Windows');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 1, 'AltCustomers', '1');

INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerID', 'customers', 'Customer ID', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerName', 'customers', 'Customer Name', 0, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerFirstName', 'customers', 'First Name', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerLastName', 'customers', 'Last Name', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerCompany', 'customers', 'Company', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerEmail', 'customers', 'Email', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerPhone', 'customers', 'Phone', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerNotes', 'customers', 'Notes', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerCredit', 'customers', 'Store Credit', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerGroup', 'customers', 'Customer Group', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerDateJoined', 'customers', 'Date Joined', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerAddresses', 'customers', 'Addresses', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressName', 'customers', 'Address Name', 0, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressFirstName', 'customers', 'Address First Name', 1, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressLastName', 'customers', 'Address Last Name', 1, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressCompany', 'customers', 'Address Company', 1, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressLine1', 'customers', 'Address Line 1', 1, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressLine2', 'customers', 'Address Line 2', 1, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressSuburb', 'customers', 'City', 1, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressState', 'customers', 'State/Province', 0, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressStateAbbrv', 'customers', 'State', 1, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressPostcode', 'customers', 'Zip', 1, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressCountry', 'customers', 'Country', 1, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressBuilding', 'customers', 'Building Type', 0, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressPhone', 'customers', 'Address Phone', 1, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'addressFormFields', 'customers', 'Address Form Fields', 1, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'customerFormFields', 'customers', 'Form Fields', 1, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderID', 'orders', 'Order ID', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderStatus', 'orders', 'Order Status', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderDate', 'orders', 'Order Date', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderSubtotal', 'orders', 'Subtotal', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTaxtotal', 'orders', 'Tax Total', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTaxRate', 'orders', 'Tax Rate', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTaxName', 'orders', 'Tax Name', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTotalIncTax', 'orders', 'Total Includes Tax', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderShipCost', 'orders', 'Shipping Cost', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderHandlingCost', 'orders', 'Handling Cost', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTotalAmount', 'orders', 'Order Total', 1, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderCustomerID', 'orders', 'Customer ID', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderShipMethod', 'orders', 'Ship Method', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderPayMethod', 'orders', 'Payment Method', 1, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTotalQty', 'orders', 'Total Quantity', 1, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTotalShipped', 'orders', 'Total Shipped', 1, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderDateShipped', 'orders', 'Date Shipped', 1, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTrackingNo', 'orders', 'Tracking No', 1, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderCurrency', 'orders', 'Order Currency Code', 1, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderExchangeRate', 'orders', 'Exchange Rate', 1, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderNotes', 'orders', 'Order Notes', 1, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderCustMessage', 'orders', 'Customer Message', 1, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billName', 'orders', 'Billing Name', 0, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billFirstName', 'orders', 'Billing First Name', 1, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billLastName', 'orders', 'Billing Last Name', 1, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billCompany', 'orders', 'Billing Company', 1, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billStreet1', 'orders', 'Billing Street 1', 1, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billStreet2', 'orders', 'Billing Street 2', 1, 27);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billSuburb', 'orders', 'Billing Suburb', 1, 28);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billState', 'orders', 'Billing State', 0, 29);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billStateAbbrv', 'orders', 'Billing State', 1, 30);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billZip', 'orders', 'Billing Zip', 1, 31);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billCountry', 'orders', 'Billing Country', 1, 32);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billSSC', 'orders', 'Billing Suburb + State + Zip', 0, 33);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billPhone', 'orders', 'Billing Phone', 1, 34);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billEmail', 'orders', 'Billing Email', 1, 35);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'billFormFields', 'orders', 'Billing Form Fields', 1, 36);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipName', 'orders', 'Shipping Name', 0, 37);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipFirstName', 'orders', 'Shipping First Name', 1, 38);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipLastName', 'orders', 'Shipping Last Name', 1, 39);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipCompany', 'orders', 'Shipping Company', 1, 40);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipStreet1', 'orders', 'Shipping Street 1', 1, 41);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipStreet2', 'orders', 'Shipping Street 2', 1, 42);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipSuburb', 'orders', 'Shipping Suburb', 1, 43);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipState', 'orders', 'Shipping State', 0, 44);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipStateAbbrv', 'orders', 'Shipping State', 1, 45);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipZip', 'orders', 'Shipping Zip', 1, 46);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipCountry', 'orders', 'Shipping Country', 1, 47);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipSSC', 'orders', 'Shipping Suburb + State + Zip', 0, 48);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipPhone', 'orders', 'Shipping Phone', 1, 49);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipEmail', 'orders', 'Shipping Email', 1, 50);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'shipFormFields', 'orders', 'Shipping Form Fields', 1, 51);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdDetails', 'orders', 'Product Details', 1, 52);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdID', 'orders', 'Product ID', 1, 53);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdQty', 'orders', 'Product Qty', 1, 54);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdSKU', 'orders', 'Product SKU', 1, 55);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdName', 'orders', 'Product Name', 1, 56);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdPrice', 'orders', 'Product Unit Price', 1, 57);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdIndex', 'orders', 'Product Index', 0, 58);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProdTotalPrice', 'orders', 'Product Total Price', 1, 59);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderGLAccount', 'orders', 'Peachtree General Ledger Account', 0, 60);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderPTTaxType', 'orders', 'Peachtree Tax Type', 0, 61);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderProductCount', 'orders', '# Unique Products in Order', 0, 62);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderTodaysDate', 'orders', 'Todays Date', 0, 63);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'orderAccountsReceivable', 'orders', 'Peachtree Accounts Receivable Account', 0, 64);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productID', 'products', 'Product ID', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productType', 'products', 'Product Type', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCode', 'products', 'Code', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productName', 'products', 'Name', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productBrand', 'products', 'Brand', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productBrandName', 'products', 'Brand + Name', 0, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productDesc', 'products', 'Description', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productTaxable', 'products', 'Taxable Product', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCostPrice', 'products', 'Cost Price', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productRetailPrice', 'products', 'Retail Price', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productSalePrice', 'products', 'Sale Price', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCalculatedPrice', 'products', 'Calculated Price', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productShippingPrice', 'products', 'Fixed Shipping Price', 1, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productFreeShipping', 'products', 'Free Shipping', 1, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productWarranty', 'products', 'Warranty', 1, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productWeight', 'products', 'Weight', 1, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productWidth', 'products', 'Width', 1, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productHeight', 'products', 'Height', 1, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productDepth', 'products', 'Depth', 1, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productPurchasable', 'products', 'Allow Purchases', 1, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVisible', 'products', 'Product Visible', 1, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productNotVisible', 'products', 'Product Not Visible', 0, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productAvailability', 'products', 'Product Availability', 1, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productInventoried', 'products', 'Product Inventoried', 1, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productStockLevel', 'products', 'Stock Level', 1, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productLowStockLevel', 'products', 'Low Stock Level', 1, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productDateAdded', 'products', 'Date Added', 1, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productLastModified', 'products', 'Date Modified', 1, 27);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCategories', 'products', 'Category Details', 1, 28);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCategoryID', 'products', 'Category ID', 0, 29);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCategoryName', 'products', 'Category Name', 1, 30);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productCategoryPath', 'products', 'Category Path', 1, 31);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productPageTitle', 'products', 'Page Title', 1, 32);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productMetaKeywords', 'products', 'META Keywords', 1, 33);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productMetaDesc', 'products', 'META Description', 1, 34);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVariations', 'products', 'Product Variations', 1, 35);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVarDetails', 'products', 'Variation Details', 1, 36);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVarSKU', 'products', 'SKU', 1, 37);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVarPrice', 'products', 'Price', 1, 38);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVarWeight', 'products', 'Weight', 1, 39);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVarStockLevel', 'products', 'Stock Level', 1, 40);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productVarLowStockLevel', 'products', 'Low Stock Level', 1, 41);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productMYOBAsset', 'products', 'MYOB Asset Acct', 0, 42);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productMYOBIncome', 'products', 'MYOB Income Acct', 0, 43);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (1, 'productMYOBExpense', 'products', 'MYOB Expense Acct', 0, 44);

-- MYOB template

INSERT INTO `%%PREFIX%%export_templates` (`exporttemplateid`, `exporttemplatename`, `myobassetaccount`, `myobincomeaccount`, `myobexpenseaccount`, `peachtreereceivableaccount`, `peachtreeglaccount`, `modifyforpeachtree`, `dateformat`, `priceformat`, `boolformat`, `blankforfalse`, `vendorid`, `usedtypes`, `builtin`) VALUES (2, 'MYOB', '', '', '', '', '', 0, 'dmy-slash', 'number', 'yn', 1, 0, 'customers,orders,products', 1);

INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'FieldSeparator', ',');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'FieldEnclosure', '"');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'IncludeHeader', '1');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'BlankLine', '1');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'SubItems', '0');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'SubItemSeparator', '|');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'LineEnding', 'Windows');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 2, 'AltCustomers', '1');

INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerID', 'customers', 'Card ID', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerName', 'customers', 'Customer Name', 0, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerFirstName', 'customers', 'First Name', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerLastName', 'customers', 'Co./Last Name', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerCompany', 'customers', 'Company', 0, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerEmail', 'customers', 'Email', 0, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerPhone', 'customers', 'Phone', 0, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerNotes', 'customers', 'Notes', 1, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerCredit', 'customers', 'Store Credit', 0, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerGroup', 'customers', 'Customer Group', 0, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerDateJoined', 'customers', 'Date Joined', 0, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerAddresses', 'customers', 'Addresses', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressName', 'customers', 'Address Contact Name', 1, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressFirstName', 'customers', 'Address First Name', 0, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressLastName', 'customers', 'Address Last Name', 0, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressCompany', 'customers', 'Address Company', 0, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressLine1', 'customers', 'Address Line 1', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressLine2', 'customers', 'Address Line 2', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressSuburb', 'customers', 'Address City', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressState', 'customers', 'Address State', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressStateAbbrv', 'customers', 'State Abbreviation', 0, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressPostcode', 'customers', 'Address Postcode', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressCountry', 'customers', 'Address Country', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressBuilding', 'customers', 'Building Type', 0, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressPhone', 'customers', 'Address Phone 1', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressFormFields', 'customers', 'Address Form Fields', 0, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerFormFields', 'customers', 'Form Fields', 0, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderID', 'orders', 'Invoice #', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderStatus', 'orders', 'Order Status', 0, 37);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderDate', 'orders', 'Date', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderSubtotal', 'orders', 'Total', 1, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTaxtotal', 'orders', 'Tax Amount', 1, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTaxRate', 'orders', 'Tax Rate', 0, 32);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTaxName', 'orders', 'Tax Code', 1, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTotalIncTax', 'orders', 'Inclusive', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderShipCost', 'orders', 'Inc-Tax Freight Amount', 1, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderHandlingCost', 'orders', 'Handling Cost', 0, 38);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTotalAmount', 'orders', 'Inc-Tax Total', 1, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderCustomerID', 'orders', 'Card ID', 1, 31);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderShipMethod', 'orders', 'Ship Via', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderPayMethod', 'orders', 'Payment Method', 1, 29);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTotalQty', 'orders', 'Total Quantity', 0, 39);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTotalShipped', 'orders', 'Total Shipped', 0, 40);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderDateShipped', 'orders', 'Shipping Date', 1, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTrackingNo', 'orders', 'Tracking No', 0, 41);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderCurrency', 'orders', 'Currency Code', 1, 27);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderExchangeRate', 'orders', 'Exchange Rate', 1, 28);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderNotes', 'orders', 'Comment', 1, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderCustMessage', 'orders', 'Payment Notes', 1, 30);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billName', 'orders', '', 0, 42);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billFirstName', 'orders', 'First Name', 0, 33);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billLastName', 'orders', 'Co./Last Name', 0, 34);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billCompany', 'orders', 'Billing Company', 0, 43);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billStreet1', 'orders', 'Address Line 1', 0, 44);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billStreet2', 'orders', 'Address Line 2', 0, 45);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billSuburb', 'orders', 'Billing Suburb', 0, 46);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billState', 'orders', 'Billing State', 0, 47);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billStateAbbrv', 'orders', 'Billing State Abbreviation', 0, 48);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billZip', 'orders', 'Billing Zip', 0, 49);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billCountry', 'orders', 'Billing Country', 0, 50);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billSSC', 'orders', '', 0, 35);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billPhone', 'orders', 'Billing Phone', 0, 51);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billEmail', 'orders', 'Billing Email', 0, 52);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billFormFields', 'orders', 'Billing Form Fields', 0, 63);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipName', 'orders', 'Shipping Name', 0, 53);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipFirstName', 'orders', 'First Name', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipLastName', 'orders', 'Co./Last Name', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipCompany', 'orders', 'Shipping Company', 0, 54);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipStreet1', 'orders', 'Address Line 1', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipStreet2', 'orders', 'Address Line 2', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipSuburb', 'orders', 'Address Line 3', 0, 36);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipState', 'orders', 'Shipping State', 0, 55);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipStateAbbrv', 'orders', 'Shipping State Abbreviation', 0, 56);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipZip', 'orders', 'Shipping Zip', 0, 57);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipCountry', 'orders', 'Address Line 4', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipSSC', 'orders', 'Address Line 3', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipPhone', 'orders', 'Shipping Phone', 0, 58);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipEmail', 'orders', 'Shipping Email', 0, 59);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipFormFields', 'orders', 'Shipping Form Fields', 0, 64);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdDetails', 'orders', 'Product Details', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdID', 'orders', 'Item Number', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdQty', 'orders', 'Quantity', 1, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdSKU', 'orders', 'Product SKU', 0, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdName', 'orders', 'Description', 1, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdPrice', 'orders', 'Inc-Tax Price', 1, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdIndex', 'orders', 'Product Index', 0, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProdTotalPrice', 'orders', 'Product Total Price', 0, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderGLAccount', 'orders', 'G/L Account', 0, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderPTTaxType', 'orders', 'Peachtree Tax Type', 0, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderProductCount', 'orders', '# Unique Products in Order', 0, 60);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderTodaysDate', 'orders', 'Todays Date', 0, 61);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'orderAccountsReceivable', 'orders', 'Peachtree Accounts Receivable Account', 0, 62);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productID', 'products', 'Item Number', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productType', 'products', 'Product Type', 0, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCode', 'products', 'Code', 0, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productName', 'products', 'Item Name', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productBrand', 'products', 'Brand', 0, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productBrandName', 'products', '', 0, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productDesc', 'products', 'Description', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productTaxable', 'products', 'Taxable Product', 0, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCostPrice', 'products', 'Standard Cost', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productRetailPrice', 'products', 'Retail Price', 0, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productSalePrice', 'products', 'Sale Price', 0, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCalculatedPrice', 'products', 'Selling Price', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productShippingPrice', 'products', 'Fixed Shipping Price', 0, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productFreeShipping', 'products', 'Free Shipping', 0, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productWarranty', 'products', 'Warranty', 0, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productWeight', 'products', 'Weight', 0, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productWidth', 'products', 'Width', 0, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productHeight', 'products', 'Height', 0, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productDepth', 'products', 'Depth', 0, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productPurchasable', 'products', 'Sell', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVisible', 'products', 'Product Visible', 0, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productNotVisible', 'products', 'Inactive Item', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productAvailability', 'products', 'Product Availability', 0, 27);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productInventoried', 'products', 'Inventory', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productStockLevel', 'products', 'Stock Level', 0, 28);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productLowStockLevel', 'products', 'Minimum Level', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productDateAdded', 'products', 'Date Added', 0, 29);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productLastModified', 'products', 'Date Modified', 0, 30);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCategories', 'products', 'Category Details', 0, 31);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCategoryID', 'products', 'Category ID', 0, 32);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCategoryName', 'products', 'Category Name', 0, 33);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productCategoryPath', 'products', 'Category Path', 0, 34);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productPageTitle', 'products', 'Page Title', 0, 35);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productMetaKeywords', 'products', 'META Keywords', 0, 36);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productMetaDesc', 'products', 'META Description', 0, 37);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVariations', 'products', 'Product Variations', 0, 38);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVarDetails', 'products', 'Variation Details', 0, 39);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVarSKU', 'products', 'SKU', 0, 40);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVarPrice', 'products', 'Price', 0, 41);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVarWeight', 'products', 'Weight', 0, 42);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVarStockLevel', 'products', 'Stock Level', 0, 43);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productVarLowStockLevel', 'products', 'Low Stock Level', 0, 44);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productMYOBAsset', 'products', 'Asset Acct', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productMYOBIncome', 'products', 'Income Acct', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'productMYOBExpense', 'products', 'Expense/COS Acct', 1, 6);

-- Peachtree template

INSERT INTO `%%PREFIX%%export_templates` (`exporttemplateid`, `exporttemplatename`, `myobassetaccount`, `myobincomeaccount`, `myobexpenseaccount`, `peachtreereceivableaccount`, `peachtreeglaccount`, `modifyforpeachtree`, `dateformat`, `priceformat`, `boolformat`, `blankforfalse`, `vendorid`, `usedtypes`, `builtin`) VALUES (3, 'Peachtree Accounting', '', '', '', '', '', 1, 'dmy-slash', 'number', 'truefalse', 0, 0, 'customers,orders,products', 1);

INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'FieldSeparator', ',');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'FieldEnclosure', '"');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'IncludeHeader', '1');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'SubItems', '0');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'SubItemSeparator', '|');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'LineEnding', 'Windows');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'BlankLine', '0');
INSERT INTO `%%PREFIX%%export_method_settings` (`methodname`, `exporttemplateid`, `variablename`, `variablevalue`) VALUES ('CSV', 3, 'AltCustomers', '1');

INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerID', 'customers', 'Customer ID', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerName', 'customers', 'Customer Name', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerFirstName', 'customers', 'First Name', 0, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerLastName', 'customers', 'Last Name', 0, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerCompany', 'customers', 'Company', 0, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerEmail', 'customers', 'Customer E-mail', 1, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerPhone', 'customers', 'Telephone 1', 1, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerNotes', 'customers', 'Notes', 0, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerCredit', 'customers', 'Customer Balance', 1, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerGroup', 'customers', 'Customer Group', 0, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerDateJoined', 'customers', 'Customer Since Date', 1, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'customerAddresses', 'customers', 'Addresses', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressName', 'customers', 'Ship to Name', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressFirstName', 'customers', 'Address First Name', 0, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressLastName', 'customers', 'Address Last Name', 0, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressCompany', 'customers', 'Address Company', 0, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressLine1', 'customers', 'Ship to Address Line 1', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressLine2', 'customers', 'Ship to Address Line 2', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressSuburb', 'customers', 'Ship to City', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressState', 'customers', 'Ship to State', 0, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressStateAbbrv', 'customers', 'Ship to State', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressPostcode', 'customers', 'Ship to Zipcode', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressCountry', 'customers', 'Ship to Country', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressBuilding', 'customers', 'Building Type', 0, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'addressPhone', 'customers', 'Address Phone', 0, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'addressFormFields', 'customers', 'Address Form Fields', 0, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'customerFormFields', 'customers', 'Form Fields', 0, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderID', 'orders', 'Invoice/CM #', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderStatus', 'orders', 'Order Status', 0, 27);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderDate', 'orders', 'Date', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderSubtotal', 'orders', 'Subtotal', 0, 28);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTaxtotal', 'orders', 'Tax Total', 0, 29);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTaxRate', 'orders', 'Tax Rate', 0, 30);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTaxName', 'orders', 'Sales Tax Agency', 0, 31);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTotalIncTax', 'orders', 'Total Includes Tax', 0, 32);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderShipCost', 'orders', 'Shipping Cost', 0, 33);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderHandlingCost', 'orders', 'Handling Cost', 0, 34);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTotalAmount', 'orders', 'Order Total', 0, 35);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderCustomerID', 'orders', 'Customer ID', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderShipMethod', 'orders', 'Ship Via', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderPayMethod', 'orders', 'Payment Method', 0, 36);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTotalQty', 'orders', 'Total Quantity', 0, 37);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTotalShipped', 'orders', 'Total Shipped', 0, 38);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderDateShipped', 'orders', 'Ship Date', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTrackingNo', 'orders', 'Tracking No', 0, 39);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderCurrency', 'orders', 'Order Currency Code', 0, 40);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderExchangeRate', 'orders', 'Exchange Rate', 0, 41);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderNotes', 'orders', 'Internal Note', 1, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderCustMessage', 'orders', 'Invoice Note', 1, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billName', 'orders', 'Billing Name', 0, 58);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billFirstName', 'orders', 'Billing First Name', 0, 42);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billLastName', 'orders', 'Billing Last Name', 0, 43);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billCompany', 'orders', 'Billing Company', 0, 44);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billStreet1', 'orders', 'Billing Street 1', 0, 45);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billStreet2', 'orders', 'Billing Street 2', 0, 46);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billSuburb', 'orders', 'Billing Suburb', 0, 47);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billState', 'orders', 'Billing State', 0, 48);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billStateAbbrv', 'orders', 'Billing State Abbreviation', 0, 59);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billZip', 'orders', 'Billing Zip', 0, 49);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billCountry', 'orders', 'Billing Country', 0, 50);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billSSC', 'orders', 'Billing Suburb + State + Zip', 0, 61);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billPhone', 'orders', 'Billing Phone', 0, 51);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'billEmail', 'orders', 'Billing Email', 0, 52);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'billFormFields', 'orders', 'Billing Form Fields', 0, 63);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipName', 'orders', 'Ship to Name', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipFirstName', 'orders', '', 0, 53);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipLastName', 'orders', 'Shipping Last Name', 0, 54);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipCompany', 'orders', 'Shipping Company', 0, 55);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipStreet1', 'orders', 'Ship to Address-Line One', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipStreet2', 'orders', 'Ship to Address-Line Two', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipSuburb', 'orders', 'Ship to City', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipState', 'orders', 'Ship to State', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipStateAbbrv', 'orders', 'Shipping State Abbreviation', 0, 60);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipZip', 'orders', 'Ship to Zipcode', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipCountry', 'orders', 'Ship to Country', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipSSC', 'orders', 'Shipping Suburb + State + Zip', 0, 62);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipPhone', 'orders', 'Shipping Phone', 0, 56);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'shipEmail', 'orders', 'Shipping Email', 0, 57);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (2, 'shipFormFields', 'orders', 'Billing Form Fields', 0, 64);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdDetails', 'orders', 'Product Details', 1, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdID', 'orders', 'Item ID', 1, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdQty', 'orders', 'Quantity', 1, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdSKU', 'orders', 'UPC/SKU', 1, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdName', 'orders', 'Description ', 1, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdPrice', 'orders', 'Unit Price', 1, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdIndex', 'orders', 'Invoice/CM Distribution', 1, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProdTotalPrice', 'orders', 'Amount', 1, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderGLAccount', 'orders', 'G/L Account', 1, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderPTTaxType', 'orders', 'Tax Type', 1, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderProductCount', 'orders', 'Number of Distributions', 1, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderTodaysDate', 'orders', 'Date Due', 0, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'orderAccountsReceivable', 'orders', 'Accounts Receivable Account', 1, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productID', 'products', 'Item ID', 1, 0);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productType', 'products', 'Item Type', 1, 7);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCode', 'products', 'UPC/SKU', 1, 6);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productName', 'products', 'Item Description', 1, 1);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productBrand', 'products', 'Brand', 0, 13);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productBrandName', 'products', 'Brand + Name', 0, 39);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productDesc', 'products', 'Description for Sales ', 1, 3);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productTaxable', 'products', 'Is Taxable', 1, 10);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCostPrice', 'products', 'Last Unit Cost', 1, 5);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productRetailPrice', 'products', 'Retail Price', 0, 14);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productSalePrice', 'products', 'Sales Price 1', 0, 15);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCalculatedPrice', 'products', 'Sales Price 1', 1, 4);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productShippingPrice', 'products', 'Fixed Shipping Price', 0, 16);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productFreeShipping', 'products', 'Free Shipping', 0, 17);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productWarranty', 'products', 'Warranty', 0, 18);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productWeight', 'products', 'Weight', 1, 8);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productWidth', 'products', 'Width', 0, 20);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productHeight', 'products', 'Height', 0, 21);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productDepth', 'products', 'Depth', 0, 22);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productPurchasable', 'products', 'Allow Purchases', 0, 40);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVisible', 'products', 'Product Visible', 0, 12);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productNotVisible', 'products', 'Inactive', 1, 2);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productAvailability', 'products', 'Product Availability', 0, 23);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productInventoried', 'products', 'Product Inventoried', 0, 41);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productStockLevel', 'products', 'Quantity on Hand', 0, 19);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productLowStockLevel', 'products', 'Minimum Stock', 1, 9);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productDateAdded', 'products', 'Date Added', 0, 24);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productLastModified', 'products', 'Effective Date ', 1, 11);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCategories', 'products', 'Category Details', 0, 25);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCategoryID', 'products', 'Category ID', 0, 26);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCategoryName', 'products', 'Category Name', 0, 27);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productCategoryPath', 'products', 'Category Path', 0, 28);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productPageTitle', 'products', 'Page Title', 0, 29);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productMetaKeywords', 'products', 'META Keywords', 0, 30);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productMetaDesc', 'products', 'META Description', 0, 31);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVariations', 'products', 'Product Variations', 0, 32);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVarDetails', 'products', 'Variation Details', 0, 33);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVarSKU', 'products', 'SKU', 0, 34);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVarPrice', 'products', 'Price', 0, 35);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVarWeight', 'products', 'Weight', 0, 36);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVarStockLevel', 'products', 'Stock Level', 0, 37);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productVarLowStockLevel', 'products', 'Low Stock Level', 0, 38);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productMYOBAsset', 'products', 'MYOB Asset Acct', 0, 42);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productMYOBIncome', 'products', 'MYOB Income Acct', 0, 43);
INSERT INTO `%%PREFIX%%export_template_fields` (`exporttemplateid`, `fieldid`, `fieldtype`, `fieldname`, `includeinexport`, `sortorder`) VALUES (3, 'productMYOBExpense', 'products', 'MYOB Expense Acct', 0, 44);
