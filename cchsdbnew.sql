-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2015 at 04:33 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cchsdbnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcementmaster`
--

CREATE TABLE IF NOT EXISTS `announcementmaster` (
  `announcementid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `what` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `eventdate` varchar(100) NOT NULL,
  `who` varchar(100) NOT NULL,
  `isactive` int(11) NOT NULL,
  `expirydate` date NOT NULL,
  `addby` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  `editby` varchar(25) NOT NULL,
  PRIMARY KEY (`announcementid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facultymaster`
--

CREATE TABLE IF NOT EXISTS `facultymaster` (
  `employeeid` varchar(7) NOT NULL,
  `userid` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `sex` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `cellno` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`employeeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facultymaster`
--

INSERT INTO `facultymaster` (`employeeid`, `userid`, `address`, `sex`, `birthday`, `birthplace`, `cellno`, `email`, `adddate`, `editdate`) VALUES
('0917778', 5, 'Sta. Mesa, Quezon City', 0, '1975-06-20', 'Makati Medical Hospital', '09175639872', 'pedrodelacruz@yahoo.com', '2015-02-17 07:43:37', '2015-02-20 03:44:51'),
('123456', 1, 'Manila', 1, '1970-07-14', 'PNP General Hospital', '09353103821', 'julietaalbarida@yahoo.com', '2015-02-15 15:50:58', '2015-02-20 01:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `gradelevelmaster`
--

CREATE TABLE IF NOT EXISTS `gradelevelmaster` (
  `gradeid` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `gradelevelmaster`
--

INSERT INTO `gradelevelmaster` (`gradeid`, `description`, `adddate`) VALUES
(1, '7', '2015-01-28 03:41:03'),
(2, '8', '2015-01-17 19:54:38'),
(3, '9', '2015-01-17 19:54:38'),
(4, '10', '2015-01-17 19:54:38'),
(5, '11', '2015-01-17 19:54:38'),
(6, '12', '2015-01-17 19:54:38'),
(7, '7-SUMMER', '2015-01-28 05:59:31'),
(8, '8-SUMMER', '2015-01-28 05:59:31'),
(9, '9-SUMMER', '2015-01-28 05:59:31'),
(10, '10-SUMMER', '2015-01-28 05:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `gradetxn`
--

CREATE TABLE IF NOT EXISTS `gradetxn` (
  `gradetxnid` int(11) NOT NULL AUTO_INCREMENT,
  `lrn` varchar(12) NOT NULL,
  `subjectid` int(11) NOT NULL,
  `gradeid` int(11) NOT NULL,
  `project` decimal(10,0) NOT NULL,
  `quiz` decimal(10,0) NOT NULL,
  `assignment` decimal(10,0) NOT NULL,
  `attendance` decimal(10,0) NOT NULL,
  `projectpercent` int(11) NOT NULL,
  `assignmentpercent` int(11) NOT NULL,
  `attendancepercent` int(11) NOT NULL,
  `quizpercent` int(11) NOT NULL,
  `exam` decimal(10,0) NOT NULL,
  `exampercent` int(11) NOT NULL,
  `extracurricular` decimal(10,0) NOT NULL,
  `extracurricularpercent` int(11) NOT NULL,
  `gradingperiod` int(11) NOT NULL,
  `syid` int(11) NOT NULL,
  `uploadedby` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`gradetxnid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gradingperiodmaster`
--

CREATE TABLE IF NOT EXISTS `gradingperiodmaster` (
  `periodid` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`periodid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gradingperiodmaster`
--

INSERT INTO `gradingperiodmaster` (`periodid`, `description`, `adddate`) VALUES
(1, 'First', '2015-01-30 16:32:49'),
(2, 'Second', '2015-01-30 16:32:49'),
(3, 'Third', '2015-01-30 16:32:49'),
(4, 'Fourth', '2015-01-30 16:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `informationmaster`
--

CREATE TABLE IF NOT EXISTS `informationmaster` (
  `infoid` int(11) NOT NULL AUTO_INCREMENT,
  `infoname` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`infoid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `informationmaster`
--

INSERT INTO `informationmaster` (`infoid`, `infoname`, `description`, `adddate`) VALUES
(1, 'Mission', 'Camp Crame High School is a learner-centered school that envisions to develop individuals who are God-loving, competent, empowered and globally competitive.', '2015-01-17 21:50:24'),
(2, 'Vision', 'Camp Crame High School is committed to provide learner access to quality basic education through a meaningful and relevant curriculum, creative and dedicated mentors, innovative, visionary school leaders and supportive stakeholders.', '2015-01-17 21:50:24'),
(3, 'Principal', 'GUILIVER EDUARD L. VAN ZANDT', '2015-02-02 13:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `preregmaster`
--

CREATE TABLE IF NOT EXISTS `preregmaster` (
  `userid` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `sex` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `cellno` varchar(11) NOT NULL,
  `mother` varchar(50) NOT NULL,
  `motherocc` varchar(50) NOT NULL,
  `father` varchar(50) NOT NULL,
  `fatherocc` varchar(50) NOT NULL,
  `lastschoolattended` varchar(100) NOT NULL,
  `schooladdress` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gradeid` int(11) NOT NULL,
  `registrationid` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preregmaster`
--

INSERT INTO `preregmaster` (`userid`, `address`, `sex`, `birthday`, `birthplace`, `cellno`, `mother`, `motherocc`, `father`, `fatherocc`, `lastschoolattended`, `schooladdress`, `email`, `gradeid`, `registrationid`, `adddate`) VALUES
(14, 'Condo 7 231 Camp Crame Quezon City', 1, '2002-10-10', 'Makati Medical Hospital', '09176355131', 'Delia Baldovino', 'Housewife', 'Leon Baldovino', 'Police', 'Camp Crame Elementary School', 'Camp Crame', 'lalainebaldovino@gmail.com', 1, 1, '2015-03-06 03:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `registrationtypemaster`
--

CREATE TABLE IF NOT EXISTS `registrationtypemaster` (
  `registrationid` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`registrationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `registrationtypemaster`
--

INSERT INTO `registrationtypemaster` (`registrationid`, `description`, `adddate`, `editdate`) VALUES
(1, 'New', '2015-01-17 17:42:00', NULL),
(2, 'Old', '2015-01-17 17:42:00', NULL),
(5, 'Transferee', '2015-01-17 17:42:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requirementmaster`
--

CREATE TABLE IF NOT EXISTS `requirementmaster` (
  `docid` int(11) NOT NULL AUTO_INCREMENT,
  `regid` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `reqtype` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`docid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `requirementmaster`
--

INSERT INTO `requirementmaster` (`docid`, `regid`, `description`, `reqtype`, `adddate`, `editdate`) VALUES
(1, 1, 'Good Moral', 1, '2015-02-15 14:27:39', NULL),
(2, 1, 'NSO (Photocopy and Original Copy)', 1, '2015-02-15 14:28:18', NULL),
(3, 1, 'Diploma (Photocopy)', 1, '2015-02-15 14:28:42', NULL),
(4, 1, 'Form 1-38', 1, '2015-02-15 14:29:17', NULL),
(5, 1, 'I.D Picture (3 pcs.)', 0, '2015-02-15 14:29:41', NULL),
(6, 2, 'Form 1-38', 1, '2015-02-15 14:30:04', NULL),
(7, 2, 'Clearance', 1, '2015-02-15 14:30:28', NULL),
(8, 5, 'Good Moral', 1, '2015-02-15 14:31:03', NULL),
(9, 5, 'NSO (Photocopy and Original Copy)', 1, '2015-02-15 14:31:17', NULL),
(10, 5, 'Diploma (Photocopy)', 1, '2015-02-15 14:31:29', NULL),
(11, 5, 'Form 1-37', 1, '2015-02-15 14:31:43', NULL),
(12, 5, 'I.D Picture (3 pcs.)', 0, '2015-02-15 14:32:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requirementstxn`
--

CREATE TABLE IF NOT EXISTS `requirementstxn` (
  `reqtxnid` int(11) NOT NULL AUTO_INCREMENT,
  `regid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `docid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `datereceived` date DEFAULT NULL,
  `receivedby` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reqtxnid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `requirementstxn`
--

INSERT INTO `requirementstxn` (`reqtxnid`, `regid`, `userid`, `docid`, `status`, `datereceived`, `receivedby`, `adddate`, `editdate`) VALUES
(1, 4, 2, 6, 1, '2015-03-05', '1', '2015-02-16 01:54:01', NULL),
(2, 4, 2, 7, 1, '2015-03-05', '1', '2015-02-16 01:54:01', NULL),
(3, 4, 3, 6, 1, '2015-03-05', '1', '2015-02-16 01:58:02', NULL),
(4, 4, 3, 7, 1, '2015-03-05', '1', '2015-02-16 01:58:02', NULL),
(5, 4, 4, 6, 1, '2015-03-05', '1', '2015-02-16 02:02:10', NULL),
(6, 4, 4, 7, 1, '2015-03-05', '1', '2015-02-16 02:02:10', NULL),
(7, 4, 6, 6, 1, '2015-03-05', '1', '2015-03-06 02:40:46', NULL),
(8, 4, 6, 7, 1, '2015-03-05', '1', '2015-03-06 02:40:46', NULL),
(9, 4, 7, 6, 1, '2015-03-05', '1', '2015-03-06 02:48:19', NULL),
(10, 4, 7, 7, 1, '2015-03-05', '1', '2015-03-06 02:48:19', NULL),
(11, 2, 8, 6, 1, '2015-03-05', '1', '2015-03-06 02:51:58', NULL),
(12, 2, 8, 7, 1, '2015-03-05', '1', '2015-03-06 02:51:58', NULL),
(13, 4, 9, 6, 1, '2015-03-05', '1', '2015-03-06 02:58:58', NULL),
(14, 4, 9, 7, 1, '2015-03-05', '1', '2015-03-06 02:58:58', NULL),
(15, 2, 10, 6, 1, '2015-03-05', '1', '2015-03-06 03:02:32', NULL),
(16, 2, 10, 7, 1, '2015-03-05', '1', '2015-03-06 03:02:32', NULL),
(17, 4, 11, 6, 1, '2015-03-05', '1', '2015-03-06 03:06:06', NULL),
(18, 4, 11, 7, 1, '2015-03-05', '1', '2015-03-06 03:06:06', NULL),
(19, 2, 12, 6, 1, '2015-03-05', '1', '2015-03-06 03:09:23', NULL),
(20, 2, 12, 7, 1, '2015-03-05', '1', '2015-03-06 03:09:23', NULL),
(21, 4, 13, 6, 1, '2015-03-05', '1', '2015-03-06 03:15:13', NULL),
(22, 4, 13, 7, 1, '2015-03-05', '1', '2015-03-06 03:15:13', NULL),
(23, 1, 14, 1, 0, NULL, '', '2015-03-06 03:25:28', NULL),
(24, 1, 14, 2, 0, NULL, '', '2015-03-06 03:25:28', NULL),
(25, 1, 14, 3, 0, NULL, '', '2015-03-06 03:25:28', NULL),
(26, 1, 14, 4, 0, NULL, '', '2015-03-06 03:25:28', NULL),
(27, 1, 14, 5, 0, NULL, '', '2015-03-06 03:25:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requirementstxn_hist`
--

CREATE TABLE IF NOT EXISTS `requirementstxn_hist` (
  `reqtxnid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `docid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `datereceived` date DEFAULT NULL,
  `receivedby` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reqtxnid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schoolyearmaster`
--

CREATE TABLE IF NOT EXISTS `schoolyearmaster` (
  `syid` int(11) NOT NULL AUTO_INCREMENT,
  `syname` varchar(25) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`syid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `schoolyearmaster`
--

INSERT INTO `schoolyearmaster` (`syid`, `syname`, `adddate`, `editdate`) VALUES
(1, '2007-2008', '2015-02-07 08:01:17', NULL),
(2, '2008-2009', '2015-02-07 08:01:17', NULL),
(3, '2009-2010', '2015-02-07 08:01:17', NULL),
(4, '2010-2011', '2015-02-07 08:01:17', NULL),
(5, '2011-2012', '2015-02-07 08:01:17', NULL),
(6, '2012-2013', '2015-02-07 08:01:17', NULL),
(7, '2013-2014', '2015-02-07 08:01:17', NULL),
(8, '2014-2015', '2015-02-07 08:01:17', NULL),
(9, '2015-2016', '2015-02-07 08:01:17', NULL),
(10, '2016-2017', '2015-02-07 08:01:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sectionmaster`
--

CREATE TABLE IF NOT EXISTS `sectionmaster` (
  `sectionid` int(11) NOT NULL AUTO_INCREMENT,
  `gradeid` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `maxcount` int(11) NOT NULL,
  `actualcount` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sectionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `sectionmaster`
--

INSERT INTO `sectionmaster` (`sectionid`, `gradeid`, `section`, `maxcount`, `actualcount`, `adddate`, `editdate`) VALUES
(1, 1, 'Earth', 50, 0, '2015-01-20 21:24:40', '2015-02-16 02:03:20'),
(2, 1, 'Air', 50, 0, '2015-01-23 17:11:22', '2015-02-15 15:38:34'),
(3, 2, 'Faith', 10, 3, '2015-01-23 17:12:05', '2015-02-15 15:38:34'),
(4, 2, 'Hope', 10, 0, '2015-01-23 17:12:05', '2015-02-15 15:38:34'),
(5, 1, 'Water', 10, 0, '2015-01-24 06:08:32', '2015-02-15 15:38:34'),
(6, 1, 'Fire', 10, 0, '2015-01-28 05:42:46', '2015-02-15 15:38:34'),
(7, 2, 'Love', 10, 0, '2015-01-28 05:49:28', '2015-02-15 15:38:34'),
(8, 2, 'Joy', 10, 0, '2015-01-28 05:49:57', '2015-02-15 15:38:34'),
(11, 3, 'Avogadro', 10, 0, '2015-01-31 09:52:49', '2015-02-15 15:38:34'),
(12, 3, 'Boyle', 10, 0, '2015-01-31 09:52:59', '2015-02-15 15:38:34'),
(13, 3, 'Charles', 10, 0, '2015-01-31 09:53:20', '2015-02-15 15:38:34'),
(14, 3, 'Dalton', 10, 0, '2015-01-31 09:53:30', '2015-02-15 15:38:34'),
(15, 4, 'Diamond', 10, 8, '2015-01-31 09:54:15', '2015-02-15 15:38:34'),
(16, 4, 'Pearl', 10, 0, '2015-01-31 09:54:34', '2015-02-15 15:38:34'),
(17, 4, 'Ruby', 10, 0, '2015-01-31 09:55:11', '2015-02-15 15:38:34'),
(18, 4, 'Sapphire', 10, 0, '2015-01-31 09:55:21', '2015-02-15 15:38:34'),
(19, 5, 'Test', 25, 0, '2015-02-08 06:55:38', '2015-02-15 15:38:34'),
(20, 9, 'A-Summer', 15, 0, '2015-02-08 07:02:10', '2015-02-15 15:38:34'),
(21, 7, 'Avogadro2', 36, 0, '2015-02-08 08:38:34', '2015-02-15 15:38:34'),
(22, 6, 'Test', 5, 0, '2015-02-14 15:46:40', '2015-02-15 15:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `studentmaster`
--

CREATE TABLE IF NOT EXISTS `studentmaster` (
  `lrn` varchar(12) NOT NULL,
  `userid` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sex` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `cellno` varchar(11) NOT NULL,
  `mother` varchar(50) NOT NULL,
  `motherocc` varchar(50) NOT NULL,
  `father` varchar(50) NOT NULL,
  `fatherocc` varchar(50) NOT NULL,
  `lastschoolattended` varchar(100) NOT NULL,
  `schooladdress` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gradeid` int(11) NOT NULL,
  `sectionid` int(11) NOT NULL,
  `registrationid` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lrn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentmaster`
--

INSERT INTO `studentmaster` (`lrn`, `userid`, `address`, `sex`, `birthday`, `birthplace`, `cellno`, `mother`, `motherocc`, `father`, `fatherocc`, `lastschoolattended`, `schooladdress`, `email`, `gradeid`, `sectionid`, `registrationid`, `adddate`, `editdate`) VALUES
('305357121313', 9, 'Condo 11 A-4 Camp Crame Quezon City', 1, '2000-02-14', 'PNP General Hospital', '09173268193', 'Raquel Montemayor', 'Housewife', 'Jeremiah Montemayor', 'Police', 'Camp Crame High School', 'Camp Crame', 'nicolemontemayor18@rocketmail.com', 4, 15, 2, '2015-03-06 03:16:12', NULL),
('305357121333', 4, 'Quezon City', 1, '1998-09-19', 'M. V. Santiago', '09497318329', 'Analyn Apostol', 'Businesswoman', 'Art Apostol', 'Police', 'Camp Crame Elementary School', 'Camp Crame', 'ajapostol@yahoo.com', 4, 15, 2, '2015-03-06 02:35:21', NULL),
('305357121738', 11, 'West Crame Quezon City', 0, '1999-05-30', 'Saint Luke Hospital', '09287321893', 'Madonna De Villa', 'Civilian Employee - Government', 'Doroteo De Villa', 'Engineer', 'Camp Crame High School', 'Camp Crame', 'antondevilla@gmail.com', 4, 15, 2, '2015-03-06 03:17:01', NULL),
('305357121780', 7, 'West Crame Quezon City', 0, '1999-04-18', 'PNP General Hospital', '09183667218', 'Darlene Avenido', 'Policewomen', 'Daniel Avenido', 'Civilian Employee - Government', 'Camp Crame High School', 'Camp Crame', 'daveryan16@yahoo.com', 4, 15, 2, '2015-03-06 03:09:55', NULL),
('305357131977', 8, 'Project 4 Quezon City', 1, '1998-10-17', 'Saint Luke Hospital', '09362783213', 'Janine Lacuna', 'Policewomen', 'Marianito Lacuna', 'Government Employee', 'Camp Crame High School', 'Camp Crame', 'clarisselacuna@gmail.com', 2, 3, 2, '2015-03-06 03:15:50', NULL),
('305357153634', 3, 'Pagasa Village', 0, '1999-05-17', 'PNP General Hospital', '09936712738', 'Realyn Dineros', 'Government Employee', 'Rogelio Dineros', 'Government Employee', 'Camp Crame Elementary School', 'Camp Crame', 'rjdineros@yahoo.com', 4, 15, 2, '2015-03-06 02:35:03', NULL),
('305357153678', 2, 'Quezon City', 0, '1999-03-13', 'Manila', '09136478493', 'Rosita Alvarado', 'Housewife', 'Ricardo Alvarado', 'Government Employee', 'Camp Crame Elementary School', 'Camp Crame', 'rossalvarado@yahoo.com', 4, 15, 2, '2015-03-06 02:34:45', NULL),
('305357321124', 6, 'West Crame Quezon City', 0, '1999-09-14', 'PGH', '09339283783', 'Alicia Maute', 'Government Employee', 'Sandoval Maute', 'Police', 'Camp Crame High School', 'Camp Crame', 'sahani_maute@gmail.com', 4, 15, 2, '2015-03-06 02:45:26', NULL),
('305357349933', 10, 'Condo 11 C-8 Camp Crame Quezon City', 1, '2000-12-19', 'PNP General Hospital', '09227821678', 'Pauleen Villagantol', 'Civilian Employee - Government', 'Jayvee Villagantol', 'Civilian Employee - Government', 'Camp Crame High School', 'Camp Crame', 'kemberly_villaganto@yahoo.com', 2, 3, 2, '2015-03-06 03:16:35', NULL),
('305357368709', 13, 'Murphy Quezon City', 1, '1999-08-15', 'Makati Medical Hospital', '09368982183', 'Arlene Cantano', 'Policewomen', 'Harry Cantano', 'Civilian Employee - Government', 'Camp Crame High School', 'Camp Crame', 'harlyn_26@gmail.com', 4, 15, 2, '2015-03-06 03:17:36', NULL),
('305357896313', 12, 'Aguinaldo Highway', 1, '2000-11-18', 'PNP General Hospital', '09167387219', 'Analyn Eslabon', 'Housewife', 'Arthur Eslabon', 'Police', 'Camp Crame High School', 'Camp Crame', 'airaeslabon@yahoo.com', 2, 3, 2, '2015-03-06 03:17:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjectmaster`
--

CREATE TABLE IF NOT EXISTS `subjectmaster` (
  `subjectid` int(11) NOT NULL AUTO_INCREMENT,
  `subjectname` varchar(50) NOT NULL,
  `units` decimal(10,2) NOT NULL,
  `gradeid` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`subjectid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `subjectmaster`
--

INSERT INTO `subjectmaster` (`subjectid`, `subjectname`, `units`, `gradeid`, `adddate`, `editdate`) VALUES
(1, 'Filipino', 1.20, 1, '2015-01-29 16:26:26', NULL),
(2, 'English', 1.50, 1, '2015-01-29 16:26:41', NULL),
(3, 'Mathematics', 1.50, 1, '2015-01-29 16:27:00', NULL),
(4, 'Science', 1.80, 1, '2015-01-29 16:27:10', NULL),
(5, 'Araling Panlipunan', 1.20, 1, '2015-01-29 16:27:35', NULL),
(6, 'Technology and Livelihood Education', 1.20, 1, '2015-01-29 16:27:49', NULL),
(7, 'MAPEH', 1.20, 1, '2015-01-29 16:28:16', '2015-01-29 16:29:24'),
(8, 'Edukasyon sa Pagpapakatao', 0.90, 1, '2015-01-29 16:28:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userlevelmaster`
--

CREATE TABLE IF NOT EXISTS `userlevelmaster` (
  `levelid` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`levelid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userlevelmaster`
--

INSERT INTO `userlevelmaster` (`levelid`, `description`, `adddate`) VALUES
(1, 'Guest', '2015-01-18 10:36:25'),
(2, 'Student', '2015-01-18 10:36:25'),
(3, 'Faculty', '2015-01-18 10:36:25'),
(4, 'Registrar', '2015-01-18 10:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

CREATE TABLE IF NOT EXISTS `usermaster` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `levelid` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogindate` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `usermaster`
--

INSERT INTO `usermaster` (`userid`, `fname`, `mname`, `lname`, `username`, `password`, `pic`, `levelid`, `isactive`, `adddate`, `lastlogindate`) VALUES
(1, 'Julieta    ', 'Bravo ', 'Albarida', 'julieta', '*69E2C7B77226977A89099F785B374931CE6801F3', '1.jpg', 4, 1, '2015-02-15 15:50:32', '2015-03-06 03:22:38'),
(2, 'Ross Morico', 'A.', 'Alvarado', 'ross', '*B192851CFE45E250C4ED1205E3949B03F9865323', 'Default.jpg', 2, 1, '2015-02-16 01:54:01', '2015-03-06 02:41:39'),
(3, 'Richard James', 'P', 'Dineros', 'richard', '*3EAAA9DBD65D9D1473EAA9D60EFEFE68CD4517C5', 'Default.jpg', 2, 1, '2015-02-16 01:58:02', '0000-00-00 00:00:00'),
(4, 'Arianne Joy', 'P', 'Apostol', 'arianne', '*15177548E27FB84F3BA291E7A35BBC1C6758F0E1', 'Default.jpg', 2, 1, '2015-02-16 02:02:10', '2015-02-22 01:04:33'),
(5, 'Pedro ', 'B. ', 'Dela Cruz', 'pedro', '*E703914C23317DC063A5A1B7B3D5758A9F70C3DA', 'Default.jpg', 3, 1, '2015-02-17 07:43:37', '2015-02-21 01:40:39'),
(6, 'Sahani', 'H', 'Maute', 'sahani', '*DDA60DFF6C74356F3521CD05002556A5E1853B65', 'Default.jpg', 2, 1, '2015-03-06 02:40:45', '2015-03-06 02:40:57'),
(7, 'Dave Ryan', 'M', 'Avenido', 'dave', '*1F97044D1FA97CD94DCDCD501A3B85D009F0C490', 'Default.jpg', 2, 1, '2015-03-06 02:48:19', '0000-00-00 00:00:00'),
(8, 'Maria Clarisse', 'D', 'Lacuna', 'clarisse', '*444C27E3E11577AC481F77C9AA87FE5009E8AF34', 'Default.jpg', 2, 1, '2015-03-06 02:51:58', '2015-03-06 03:11:49'),
(9, 'Jeremie Nicole', 'J', 'Montemayor', 'nicole', '*1639F572207C57D8D36E533131CC484DCEBCB160', 'Default.jpg', 2, 1, '2015-03-06 02:58:57', '0000-00-00 00:00:00'),
(10, 'Kemberly', 'M', 'Villagantol', 'kemberly', '*B8A7CD5AECEAE29233636EA8DAA3711467B6E6F2', 'Default.jpg', 2, 1, '2015-03-06 03:02:32', '0000-00-00 00:00:00'),
(11, 'Diego Anton', 'B', 'De Villa', 'anton', '*38E95C4147F7740C4E9FE1E83B830F234DB8BB5E', 'Default.jpg', 2, 1, '2015-03-06 03:06:06', '0000-00-00 00:00:00'),
(12, 'Aira', 'E', 'Eslabon', 'aira', '*E1101C62397F4C4832C026FB29D969210B5837A1', 'Default.jpg', 2, 1, '2015-03-06 03:09:23', '0000-00-00 00:00:00'),
(13, 'Harlyn', 'L', 'Cantano', 'harlyn', '*83E7466AE517069FC40FE3B36272AD0E51E53B28', 'Default.jpg', 2, 1, '2015-03-06 03:15:13', '0000-00-00 00:00:00'),
(14, 'Lalaine', 'D', 'Baldovino', 'lalaine', '*8ABC07413E34F92DB738CB6577DD430E3ED82ECE', 'Default.jpg', 1, 1, '2015-03-06 03:25:28', '2015-03-06 03:30:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
