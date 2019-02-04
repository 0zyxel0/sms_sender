-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2019 at 12:55 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tapper_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryAbsentTimeline` ()  NO SQL
SELECT DISTINCT
gh.createdate AS 'Time_In',
gp.userGivenId AS 'Pid',
gc.card_id AS 'Id',
gp.familyname AS 'LastName',
gp.givenname as 'name',
gt.categoryName AS 'category',
gh.gate_Id as 'Gate'
from gate_history gh
Left JOIN gate_cardassignment gc on gc.card_id = gh.card_id
LEFT Join gate_persondetails gp on gp.persondetailid = gc.partyid 
LEFT JOIN gate_categoryType gt on gt.categoryId = gp.categoryid
where CAST(gh.createdate as time) >= gt.gateTimeSettingAbsent
Group By gc.card_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryEarlyTimeline` ()  NO SQL
select * from 
(SELECT DISTINCT
gh.createdate AS 'Time_In',
gp.userGivenId AS 'Pid',
gc.card_id AS 'Id',
gp.familyname AS 'LastName',
gp.givenname as 'name',
gt.categoryName AS 'category',
gh.gate_Id as 'Gate'
from gate_history gh
Left JOIN gate_cardassignment gc on gc.card_id = gh.card_id
LEFT Join gate_persondetails gp on gp.persondetailid = gc.partyid 
LEFT JOIN gate_categoryType gt on gt.categoryId = gp.categoryid
where CAST(gh.createdate as time) <= gt.gateTimeInSetting
ORDER BY gh.createDate DESC)X
Where CAST(x.Time_in as date) = CAST(now() as date)
Group BY x.ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryLateTimeline` ()  NO SQL
select * from (
SELECT DISTINCT
gh.createdate AS 'Time_In',
gp.userGivenId AS 'Pid',
gc.card_id AS 'Id',
gp.familyname AS 'LastName',
gp.givenname as 'name',
gt.categoryName AS 'category',
gh.gate_Id as 'Gate',
uc.contactName AS 'Cname',
uc.contactNumber as 'Number'               
from gate_history gh
Left JOIN gate_cardassignment gc on gc.card_id = gh.card_id
LEFT Join gate_persondetails gp on gp.persondetailid = gc.partyid 
LEFT JOIN gate_categoryType gt on gt.categoryId = gp.categoryid
LEFT JOIN user_emergencycontact uc on uc.personDetailId = gp.personDetailId               
where CAST(gh.createdate as time) >= gt.gateTimeInSetting
order by gh.createdate desc
)x 
where CAST(x.Time_In as date) = CAST(now() as date)
Group by x.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryReport` ()  NO SQL
SELECT
gh.createdate AS 'Time_In',
gp.userGivenId AS 'Pid',
gc.card_id AS 'Id',
gp.familyname AS 'LastName',
gp.givenname as 'name',
gt.categoryName AS 'category',
gh.gate_Id as 'Gate'
from gate_history gh
Left JOIN gate_cardassignment gc on gc.card_id = gh.card_id
LEFT Join gate_persondetails gp on gp.persondetailid = gc.partyid 
LEFT JOIN gate_categoryType gt on gt.categoryId = gp.categoryid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryTimeline` ()  NO SQL
select 
gp.userGivenId AS 'Id', 
gh.card_id AS 'Card_id', 
gp.givenname AS 'Name', 
gp.familyname AS 'FamilyName',
gh.createDate AS 'Time_In',
gt.categoryName AS 'Type'
from gate_history gh
left join gate_cardassignment gc on gh.card_id = gc.card_id
left join gate_persondetails gp on gp.persondetailId = gc.partyId
left join gate_categoryType gt on gt.categoryId = gp.categoryId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateScanningExtract` ()  NO SQL
select 
pp.image_url AS 'url',
ga.partyid AS 'ID',
gd.givenname as 'name',
gd.familyname as 'lastname',
gh.createDate as 'time_in',
gd.userGivenId as 'givenId'
from gate_history gh
left join gate_cardassignment ga on gh.card_id = ga.card_id
left join gate_persondetails gd on gd.persondetailId = ga.partyid
left join gate_personphoto pp on pp.persondetailId = gd.persondetailId
ORDER BY gh.transaction_id DESC
LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateScanTopUp` ()  NO SQL
SELECT pi.image_url,ps.partyId,gh.createDate,ps.card_id,c.courseCode
FROM gate_history gh
JOIN party_stdconnector ps on ps.card_id = gh.card_id
JOIN person_image pi on pi.partyId = ps.partyId
JOIN student s on s.studentnumber = ps.partyid
LEFT JOIN course c on c.courseID = s.courseID
ORDER BY gh.transaction_id DESC
LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GenerateAllUsers` ()  NO SQL
select 
pic.image_url AS 'Image',
gp.personDetailId AS 'Student_ID',
gp.familyname AS 'Last_Name',
gp.givenname AS 'Given_Name',
gp.middlename AS 'Middle_Name',
gp.suffix AS 'Suffix',
gp.civilStatus AS 'Status',
gp.gender AS 'Gender',
gp.dateOfBirth AS 'Birthday',
gp.age AS 'Age',
gp.categoryId AS 'Category_ID',
gt.categoryName,
gp.userGivenId,
gc.card_id AS 'Card',
pp.contactName AS 'Contact',
pp.contactNumber AS 'Number',
pp.contactRelationship AS 'Relationship',
case when pic.image_url is NULL then 'N' Else 'Y' END AS 'Option'



from gate_persondetails gp
LEFT JOIN gate_personphoto pic on gp.personDetailId = pic.personDetailId
LEFT JOIN gate_categorytype gt on gt.categoryID = gp.categoryId
LEFT JOIN gate_cardassignment gc on gc.partyId = gp.personDetailId
LEFT JOIN user_emergencycontact pp on gp.personDetailId = pp.personDetailId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GenerateStudentListReport` ()  NO SQL
SELECT distinct 
'<img src=<?php echo base_url()?>'+pi.image_url+'height="42" width="42">' as'image_url',
pi.image_url,s.studentNumber, p.lastname, p.firstname,s.studentType,s.studentstatus, case when pi.image_url is NULL then "N" Else "Y" END AS "Upload"
FROM student s 
left join person p on s.personID = p.personID
left join person_image pi on pi.partyId = s.studentNumber$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GetAllUserCategory` ()  NO SQL
SELECT
categoryID AS 'ID',
categoryName AS 'Name',
categoryType AS 'Type',
gateTimeInSetting AS 'Time_Setting',
gateTimeSettingAbsent AS 'Absent_Setting',
createdBy AS 'Create',
updateDate AS 'Date',
case when gateTimeInSetting is not NULL then 'O' Else 'O' END AS 'Option'
FROM gate_categorytype$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GetExistingCardUsers` ()  NO SQL
SELECT 
gp.personDetailId AS 'ID',
gc.card_Id AS 'Card_Number', 
gp.familyname AS 'Last_Name', 
gp.givenname AS 'Given_Name', 
gt.categoryName AS 'Category', 
gc.isDisabled AS 'Status' 
FROM gate_cardassignment gc 
LEFT JOIN gate_persondetails gp on gc.partyid = gp.personDetailId 
LEFT JOIN gate_categorytype gt on gt.categoryId = gc.categoryId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_getGuardianList` ()  NO SQL
select
gp.personDetailId AS 'ID',
CONCAT(gp.familyname,' ', gp.givenname) AS 'User',
gc.categoryname AS 'Type',
ue.contactname AS 'Contact',
ue.contactRelationship AS'Rel',
ue.contactnumber AS 'num'
from user_emergencycontact ue
left join gate_persondetails gp on ue.persondetailid = gp.persondetailid
left join gate_categorytype gc on gc.categoryId = gp.categoryId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GuardianContactDetails` ()  NO SQL
SELECT 

p.firstName + ' ' + p.lastName as 'Student Name'
,af.guardianFirstName + ' ' + af.guardianLastName as 'Guardian Name'
,af.guardianContact 'Guardian Contact Details' 

FROM person p
left join applicant_family  af on p.personId = af.personId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_ImageGateHistory` ()  NO SQL
select 
pp.image_url AS 'url'
from gate_history gh
left join gate_cardassignment ga on gh.card_id = ga.card_id
left join gate_persondetails gd on gd.persondetailId = ga.partyid
left join gate_personphoto pp on pp.persondetailId = gd.persondetailId
ORDER BY gh.transaction_id DESC
LIMIT 7$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_MsgTemplates` ()  NO SQL
select 
messageId AS 'Id',
message_type AS 'Type',
msg_text AS 'Text',
updatedBy As 'By',
updateDate as 'date'
from msg_template$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_StudentAbsentList` ()  NO SQL
    COMMENT 'Generate a List of Students that are absent'
select distinct card_id from gate_history
where cast(createdate as date) = cast(now() as date)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_family`
--

CREATE TABLE `applicant_family` (
  `personID` int(11) NOT NULL,
  `occupationM` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `occupationF` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motherFirstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motherLastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motherContact` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fatherFirstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fatherLastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fatherContact` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianFirstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianLastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianContact` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianAddress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulknotification_activities`
--

CREATE TABLE `bulknotification_activities` (
  `id` int(11) NOT NULL,
  `sms_to` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sms_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedon` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bulknotification_activities`
--

INSERT INTO `bulknotification_activities` (`id`, `sms_to`, `message`, `sms_status`, `createdon`, `updatedon`) VALUES
(18, '09175573914', '2019-02-05 00:40:37 , Melina , Aron has walked out to the campus premises. This is a system generated message.', 'Sent', '2019-02-04 23:45:48', '2019-02-04 23:40:37'),
(19, '09175573914', '2019-02-05 00:40:54 , Melina , Aron has walked in to the campus premises. This is a system generated message.', 'Sent', '2019-02-04 23:45:59', '2019-02-04 23:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `contactlist`
--

CREATE TABLE `contactlist` (
  `contactlistid` int(11) NOT NULL,
  `contactlist_name` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `createdby` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `updatedby` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `updatedon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactlist_users`
--

CREATE TABLE `contactlist_users` (
  `contactlistuserid` int(11) NOT NULL,
  `contactlistid` int(11) NOT NULL,
  `personDetailId` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `createdby` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `updatedby` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `updatedon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `courseName` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courseCode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courseType` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `departmentID` int(11) DEFAULT NULL,
  `schoolLevel` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courseYears` int(2) DEFAULT NULL,
  `durationMonths` int(5) DEFAULT NULL,
  `dateAdded` date DEFAULT NULL,
  `dateModified` date DEFAULT NULL,
  `recordStatus` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gate_cardassignment`
--

CREATE TABLE `gate_cardassignment` (
  `assignmentId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partyId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `categoryId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  `isDisabled` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_cardassignment`
--

INSERT INTO `gate_cardassignment` (`assignmentId`, `partyId`, `card_id`, `categoryId`, `createdBy`, `createDate`, `updateDate`, `isDisabled`) VALUES
('260a74ff-2282-11e9-8c97-ace2d3624318', 'c597a67e-19d1-11e9-89f2-ace2d3624318', '884936621', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-27 23:23:19', '2019-01-27 23:23:19', 0),
('72902241-2282-11e9-8c97-ace2d3624318', 'd6216bb5-19d1-11e9-89f2-ace2d3624318', '45642562', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-27 23:25:27', '2019-01-27 23:25:27', 0),
('93ea9dc1-24bd-11e9-a60d-ace2d3624318', '821750ef-24bd-11e9-a60d-ace2d3624318', '9879788775', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-30 19:33:46', '2019-01-30 19:33:46', 0),
('a1d5fc0f-c316-11e8-a587-ace2d3624318', '9d85f8f7-c316-11e8-a587-ace2d3624318', '2345243523', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2018-09-28 14:04:20', '2018-09-28 14:04:20', 0),
('aec20378-1b75-11e9-85e8-ace2d3624318', '339dc8b3-19d2-11e9-89f2-ace2d3624318', '6789689', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-19 00:06:30', '2019-01-19 00:06:30', 0),
('b37a1bff-2282-11e9-8c97-ace2d3624318', 'aee33dbb-2282-11e9-8c97-ace2d3624318', '4272727227', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-27 23:27:16', '2019-01-27 23:27:16', 0),
('d983ccc0-24bd-11e9-a60d-ace2d3624318', 'd60fa7ff-24bd-11e9-a60d-ace2d3624318', '4567456213', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-30 19:35:42', '2019-01-30 19:35:42', 0),
('fece5139-24d2-11e9-a60d-ace2d3624318', 'f6dde6c0-24d2-11e9-a60d-ace2d3624318', '8966664456', '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-30 22:07:00', '2019-01-30 22:07:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gate_categorytype`
--

CREATE TABLE `gate_categorytype` (
  `categoryId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categoryType` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `categoryName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gateTimeInSetting` time DEFAULT NULL,
  `gateTimeSettingAbsent` time DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_categorytype`
--

INSERT INTO `gate_categorytype` (`categoryId`, `categoryType`, `categoryName`, `gateTimeInSetting`, `gateTimeSettingAbsent`, `createdBy`, `updateDate`) VALUES
('77f9afea-c316-11e8-a587-ace2d3624318', 'STD', 'Student', '09:00:00', '12:00:00', 'Admin', '2018-09-28 14:03:10'),
('88591e2d-c316-11e8-a587-ace2d3624318', 'TCH', 'Teacher', '09:00:00', '13:00:00', 'Admin', '2018-09-28 14:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `gate_coursetype`
--

CREATE TABLE `gate_coursetype` (
  `courseId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `courseName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `courseType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gate_history`
--

CREATE TABLE `gate_history` (
  `transaction_id` int(255) NOT NULL,
  `card_id` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` datetime NOT NULL,
  `gate_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_history`
--

INSERT INTO `gate_history` (`transaction_id`, `card_id`, `createDate`, `gate_id`) VALUES
(1, '<input cla', '2019-01-19 10:04:43', 'GTONE'),
(2, '2345243523', '2019-01-19 10:06:58', 'GTONE'),
(3, '2345243523', '2019-01-19 10:07:34', 'GTONE'),
(4, '2345243523', '2019-01-19 10:08:35', 'GTONE'),
(5, '2345243523', '2019-01-19 12:18:07', 'GTONE'),
(6, '2345243523', '2019-01-19 12:18:50', 'GTONE'),
(7, '2345243523', '2019-01-19 12:28:31', 'GTONE'),
(8, '2345243523', '2019-01-19 12:30:57', 'GTONE'),
(9, '2345243523', '2019-01-19 12:32:43', 'GTONE'),
(10, '2345243523', '2019-01-19 12:33:06', 'GTONE'),
(11, '2345243523', '2019-01-19 12:35:10', 'GTONE'),
(12, '2345243523', '2019-01-19 12:45:42', 'GTONE'),
(13, '2345243523', '2019-01-19 23:49:47', 'GTONE'),
(14, '2345243523', '2019-01-19 23:50:47', 'GTONE'),
(15, '2345243523', '2019-01-20 00:17:31', 'GTONE'),
(16, '2345243523', '2019-01-20 20:51:21', 'GTONE'),
(17, '2345243523', '2019-01-20 20:51:54', 'GTONE'),
(18, '2345243523', '2019-01-20 23:20:00', 'GTONE'),
(19, '2345243523', '2019-01-20 23:21:56', 'GTONE'),
(20, '2345243523', '2019-01-20 23:23:01', 'GTONE'),
(21, '2345243523', '2019-01-20 23:23:10', 'GTONE'),
(22, '2345243523', '2019-01-20 23:27:21', 'GTONE'),
(23, '2345243523', '2019-01-20 23:29:55', 'GTONE'),
(24, '2345243523', '2019-01-20 23:30:16', 'GTONE'),
(25, '2345243523', '2019-01-22 23:18:26', 'GTONE'),
(26, '2345243523', '2019-01-22 23:21:34', 'GTONE'),
(27, '2345243523', '2019-01-22 23:23:30', 'GTONE'),
(28, '2345243523', '2019-01-22 23:29:42', 'GTONE'),
(29, '2345243523', '2019-01-22 23:31:46', 'GTONE'),
(30, '2345243523', '2019-01-22 23:31:52', 'GTONE'),
(31, '2345243523', '2019-01-22 23:44:38', 'GTONE'),
(32, '2345243523', '2019-01-22 23:44:58', 'GTONE'),
(33, '2345243523', '2019-01-22 23:46:27', 'GTONE'),
(34, '2345243523', '2019-01-22 23:46:30', 'GTONE'),
(35, '2345243523', '2019-01-22 23:50:29', 'GTONE'),
(36, '2345243523', '2019-01-22 23:52:34', 'GTONE'),
(37, '2345243523', '2019-01-22 23:57:11', 'GTONE'),
(38, '2345243523', '2019-01-22 23:57:25', 'GTONE'),
(39, '2345243523', '2019-01-23 00:01:05', 'GTONE'),
(40, '2345243523', '2019-01-23 00:03:52', 'GTONE'),
(41, '2345243523', '2019-01-24 00:33:54', 'GTONE'),
(42, '2345243523', '2019-01-24 00:34:04', 'GTONE'),
(43, '2345243523', '2019-01-27 17:08:13', 'GTONE'),
(44, '2345243523', '2019-01-27 17:08:23', 'GTONE'),
(45, '2345243523', '2019-01-27 17:08:54', 'GTONE'),
(46, '2345243523', '2019-01-27 17:10:23', 'GTONE'),
(47, '2345243523', '2019-01-27 17:11:42', 'GTONE'),
(48, '2345243523', '2019-01-27 17:11:47', 'GTONE'),
(49, '2345243523', '2019-01-27 17:12:37', 'GTONE'),
(50, '2345243523', '2019-01-27 17:12:51', 'GTONE'),
(51, '2345243523', '2019-01-27 17:14:28', 'GTONE'),
(52, '2345243523', '2019-01-27 17:14:36', 'GTONE'),
(53, '2345243523', '2019-01-27 17:15:10', 'GTONE'),
(54, '2345243523', '2019-01-27 17:28:23', 'GTONE'),
(55, '6789689', '2019-01-27 17:28:39', 'GTONE'),
(56, '6789689', '2019-01-27 17:28:59', 'GTONE'),
(57, '6789689', '2019-01-27 17:29:19', 'GTONE'),
(58, '2345243523', '2019-01-27 17:31:44', 'GTONE'),
(59, '2345243523', '2019-01-27 17:32:37', 'GTONE'),
(60, '2345243523', '2019-01-27 17:37:30', 'GTONE'),
(61, '2345243523', '2019-01-27 17:37:33', 'GTONE'),
(62, '2345243523', '2019-01-27 17:40:28', 'GTONE'),
(63, '2345243523', '2019-01-27 17:56:05', 'GTONE'),
(64, '2345243523', '2019-01-27 17:56:35', 'GTONE'),
(65, '2345243523', '2019-01-27 17:57:15', 'GTONE'),
(66, '2345243523', '2019-01-27 18:06:03', 'GTONE'),
(67, '2345243523', '2019-01-27 18:24:36', 'GTONE'),
(68, '2345243523', '2019-01-27 18:26:18', 'GTONE'),
(69, '2345243523', '2019-01-27 18:31:54', 'GTONE'),
(70, '2345243523', '2019-01-27 18:38:55', 'GTONE'),
(71, '2345243523', '2019-01-27 18:41:59', 'GTONE'),
(72, '2345243523', '2019-01-27 18:47:12', 'GTONE'),
(73, '2345243523', '2019-01-27 18:49:44', 'GTONE'),
(74, '2345243523', '2019-01-27 18:50:20', 'GTONE'),
(75, '2345243523', '2019-01-27 18:59:26', 'GTONE'),
(76, '2345243523', '2019-01-27 19:09:50', 'GTONE'),
(77, '2345243523', '2019-01-27 19:09:54', 'GTONE'),
(78, '2345243523', '2019-01-27 19:10:31', 'GTONE'),
(79, '2345243523', '2019-01-27 19:11:14', 'GTONE'),
(80, '2345243523', '2019-01-27 19:11:56', 'GTONE'),
(81, '2345243523', '2019-01-27 19:13:07', 'GTONE'),
(82, '2345243523', '2019-01-27 19:13:26', 'GTONE'),
(83, '6789689', '2019-01-27 19:15:08', 'GTONE'),
(84, '6789689', '2019-01-27 19:15:25', 'GTONE'),
(85, '2345243523', '2019-01-27 19:16:07', 'GTONE'),
(86, '2345243523', '2019-01-27 19:16:13', 'GTONE'),
(87, '2345243523', '2019-01-27 22:09:01', 'GTONE'),
(88, '2345243523', '2019-01-27 22:09:08', 'GTONE'),
(89, '2345243523', '2019-01-27 22:09:57', 'GTONE'),
(90, '6789689', '2019-01-27 23:01:39', 'GTONE'),
(91, '2345243523', '2019-01-27 23:02:12', 'GTONE'),
(92, '2345243523', '2019-01-27 23:35:29', 'GTONE'),
(93, '2345243523', '2019-01-27 23:35:49', 'GTONE'),
(94, '2345243523', '2019-01-27 23:35:56', 'GTONE'),
(95, '2345243523', '2019-01-27 23:36:51', 'GTONE'),
(96, '2345243523', '2019-01-27 23:36:55', 'GTONE'),
(97, '2345243523', '2019-01-28 21:21:03', 'GTONE'),
(98, '2345243523', '2019-01-28 21:50:44', 'GTONE'),
(99, '2345243523', '2019-01-28 21:52:57', 'GTONE'),
(100, '2345243523', '2019-01-28 21:54:05', 'GTONE'),
(101, '2345243523', '2019-01-28 21:54:09', 'GTONE'),
(102, '2345243523', '2019-01-28 21:54:28', 'GTONE'),
(103, '2345243523', '2019-01-28 21:55:46', 'GTONE'),
(104, '2345243523', '2019-01-28 21:55:56', 'GTONE'),
(105, '2345243523', '2019-01-28 21:57:11', 'GTONE'),
(106, '2345243523', '2019-01-28 21:57:17', 'GTONE'),
(107, '6789689', '2019-01-28 21:58:12', 'GTONE'),
(108, '6789689', '2019-01-28 21:58:19', 'GTONE'),
(109, '6789689', '2019-01-28 22:00:54', 'GTONE'),
(110, '2345243523', '2019-01-28 22:01:34', 'GTONE'),
(111, '2345243523', '2019-01-28 22:02:07', 'GTONE'),
(112, '6789689', '2019-01-28 22:02:57', 'GTONE'),
(113, '6789689', '2019-01-28 22:03:14', 'GTONE'),
(114, '6789689', '2019-01-28 22:03:16', 'GTONE'),
(115, '6789689', '2019-01-28 22:03:19', 'GTONE'),
(116, '6789689', '2019-01-28 22:03:21', 'GTONE'),
(117, '2345243523', '2019-01-28 22:04:36', 'GTONE'),
(118, '2345243523', '2019-01-28 22:04:59', 'GTONE'),
(119, '2345243523', '2019-01-28 22:05:08', 'GTONE'),
(120, '2345243523', '2019-01-28 22:05:44', 'GTONE'),
(121, '2345243523', '2019-01-28 22:05:58', 'GTONE'),
(122, '2345243523', '2019-01-28 22:06:52', 'GTONE'),
(123, '2345243523', '2019-01-28 22:06:57', 'GTONE'),
(124, '2345243523', '2019-01-28 22:07:01', 'GTONE'),
(125, '2345243523', '2019-01-28 22:38:02', 'GTONE'),
(126, '2345243523', '2019-01-28 22:38:08', 'GTONE'),
(127, '2345243523', '2019-01-28 22:38:19', 'GTONE'),
(128, '2345243523', '2019-01-28 23:23:48', 'GTONE'),
(129, '2345243523', '2019-01-28 23:23:54', 'GTONE'),
(130, '6789689', '2019-01-28 23:31:39', 'GTONE'),
(131, '6789689', '2019-01-28 23:32:34', 'GTONE'),
(132, '6789689', '2019-01-28 23:32:45', 'GTONE'),
(133, '2345243523', '2019-01-28 23:37:14', 'GTONE'),
(134, '2345243523', '2019-01-28 23:37:22', 'GTONE'),
(135, '2345243523', '2019-01-28 23:48:33', 'GTONE'),
(136, '2345243523', '2019-01-28 23:48:54', 'GTONE'),
(137, '2345243523', '2019-01-28 23:48:55', 'GTONE'),
(138, '2345243523', '2019-01-31 23:55:18', 'GTONE'),
(139, '6789689', '2019-01-31 23:56:43', 'GTONE'),
(140, '6789689', '2019-02-03 20:39:25', 'GTONE'),
(141, '6789689', '2019-02-03 20:39:42', 'GTONE'),
(142, '4567456213', '2019-02-03 20:42:12', 'GTONE'),
(143, '4567456213', '2019-02-03 20:42:51', 'GTONE'),
(144, '2345243523', '2019-02-04 23:53:17', 'GTONE'),
(145, '2345243523', '2019-02-04 23:53:33', 'GTONE'),
(146, '4567456213', '2019-02-04 23:54:47', 'GTONE'),
(147, '2345243523', '2019-02-04 23:57:17', 'GTONE'),
(148, '6789689', '2019-02-05 00:12:24', 'GTONE'),
(149, '6789689', '2019-02-05 00:12:31', 'GTONE'),
(150, '2345243523', '2019-02-05 00:15:00', 'GTONE'),
(151, '2345243523', '2019-02-05 00:15:59', 'GTONE'),
(152, '2345243523', '2019-02-05 00:16:04', 'GTONE'),
(153, '2345243523', '2019-02-05 00:16:35', 'GTONE'),
(154, '6789689', '2019-02-05 00:17:13', 'GTONE'),
(155, '2345243523', '2019-02-05 00:25:34', 'GTONE'),
(156, '2345243523', '2019-02-05 00:30:05', 'GTONE'),
(157, '6789689', '2019-02-05 00:31:02', 'GTONE'),
(158, '6789689', '2019-02-05 00:31:17', 'GTONE'),
(159, '2345243523', '2019-02-05 00:39:30', 'GTONE'),
(160, '2345243523', '2019-02-05 00:39:34', 'GTONE'),
(161, '2345243523', '2019-02-05 00:39:47', 'GTONE'),
(162, '2345243523', '2019-02-05 00:40:36', 'GTONE'),
(163, '2345243523', '2019-02-05 00:40:54', 'GTONE');

-- --------------------------------------------------------

--
-- Table structure for table `gate_persondetails`
--

CREATE TABLE `gate_persondetails` (
  `personDetailId` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'UUID primary key for tables',
  `userGivenId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `familyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `givenname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `civilStatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `age` int(3) NOT NULL,
  `categoryId` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_persondetails`
--

INSERT INTO `gate_persondetails` (`personDetailId`, `userGivenId`, `familyname`, `givenname`, `middlename`, `suffix`, `civilStatus`, `gender`, `mobile_number`, `dateOfBirth`, `age`, `categoryId`, `createdBy`, `updateDate`) VALUES
('339dc8b3-19d2-11e9-89f2-ace2d3624318', '567456745675467', 'Miggy Test', 'Miggy Test', 'Miggy Test', '', 'Single', 'Male', NULL, '2001-01-20', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-16 22:03:41'),
('821750ef-24bd-11e9-a60d-ace2d3624318', '2323423444', 'Nanako', 'Test', 'Test', '', 'Single', 'Female', NULL, '2001-01-06', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-30 19:33:16'),
('9d85f8f7-c316-11e8-a587-ace2d3624318', '100010', 'Melina', 'Aron', 'Adols', '', 'Single', 'Male', NULL, '2000-09-22', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-16 23:08:24'),
('aee33dbb-2282-11e9-8c97-ace2d3624318', 'Miller', 'Test', 'Test', 'Test', '', 'Single', 'Female', NULL, '2001-01-09', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-27 23:27:08'),
('c597a67e-19d1-11e9-89f2-ace2d3624318', '567856785678', 'Mario Test', 'Mario Test', 'Mario Test', '', 'Single', 'Male', NULL, '2001-01-10', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-16 22:00:36'),
('d60fa7ff-24bd-11e9-a60d-ace2d3624318', '73456912342', 'Shiki', 'Test', 'Test', '', 'Single', 'Male', NULL, '2001-01-22', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-30 19:35:37'),
('d6216bb5-19d1-11e9-89f2-ace2d3624318', '3453453453453', 'Michiko Test', 'Michiko Test', 'Michiko Test', '', 'Single', 'Female', NULL, '2001-02-27', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-16 22:01:04'),
('f6dde6c0-24d2-11e9-a60d-ace2d3624318', 'SD-234234', 'Valentine', 'Test', 'Test', '', 'Single', 'Female', NULL, '2001-01-23', 18, '77f9afea-c316-11e8-a587-ace2d3624318', 'Admin', '2019-01-30 22:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `gate_personphoto`
--

CREATE TABLE `gate_personphoto` (
  `photoId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `personDetailId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_personphoto`
--

INSERT INTO `gate_personphoto` (`photoId`, `personDetailId`, `image_url`, `createdBy`, `createDate`, `updateDate`) VALUES
('8eb7e98a-1bc9-11e9-85e8-ace2d3624318', '9d85f8f7-c316-11e8-a587-ace2d3624318', 'ui/photo_library/FB_IMG_1533557372598.jpg', 'Admin', '2019-01-19 10:06:51', '2019-01-28 21:20:49'),
('a32d557e-2250-11e9-8952-ace2d3624318', '339dc8b3-19d2-11e9-89f2-ace2d3624318', 'ui/photo_library/wallpaper.jpg', 'Admin', '2019-01-27 17:28:54', '2019-01-31 23:56:37'),
('f6e91ab6-24bd-11e9-a60d-ace2d3624318', 'd60fa7ff-24bd-11e9-a60d-ace2d3624318', 'ui/photo_library/FB_IMG_1537998101099.jpg', 'Admin', '2019-01-30 19:36:32', '2019-01-30 19:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `gate_personstatus`
--

CREATE TABLE `gate_personstatus` (
  `gate_personstatusid` int(11) NOT NULL,
  `card_id` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `campus_status` tinyint(1) DEFAULT NULL,
  `gate_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_personstatus`
--

INSERT INTO `gate_personstatus` (`gate_personstatusid`, `card_id`, `campus_status`, `gate_id`, `updatedate`) VALUES
(1, '6789689', 1, 'GTONE', '2019-02-05 00:37:29'),
(2, '2345243523', 1, 'GTONE', '2019-02-05 00:40:54'),
(3, '4272727227', 0, '', '2019-01-27 23:27:16'),
(4, '4567456213', 0, '', '2019-01-30 19:35:42'),
(5, '8966664456', 0, '', '2019-01-30 22:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `gate_usercategory`
--

CREATE TABLE `gate_usercategory` (
  `categoryId` int(11) NOT NULL,
  `userType` varchar(51) COLLATE utf8_unicode_ci NOT NULL,
  `userCatId` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `userTimeSetting` time NOT NULL,
  `updateDate` datetime NOT NULL,
  `updatedBy` varchar(51) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gate_users`
--

CREATE TABLE `gate_users` (
  `id_user` int(50) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `createdDate` date NOT NULL,
  `createdBy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateDate` date NOT NULL,
  `updatedBy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gate_users`
--

INSERT INTO `gate_users` (`id_user`, `username`, `password`, `createdDate`, `createdBy`, `updateDate`, `updatedBy`) VALUES
(1, 'Admin', 'pass', '2017-09-28', 'Admin', '2017-09-28', 'Admin'),
(2, 'Gate', 'pass', '2017-09-28', 'Admin', '2017-09-28', 'Admin'),
(3, 'SmsAdmin', 'pass', '2017-09-28', 'Admin', '2017-09-28', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `msg_template`
--

CREATE TABLE `msg_template` (
  `messageId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `msg_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdBy` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` datetime NOT NULL,
  `updatedBy` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `msg_template`
--

INSERT INTO `msg_template` (`messageId`, `message_type`, `msg_text`, `createdBy`, `createDate`, `updatedBy`, `updateDate`) VALUES
('75d5ca30-227f-11e9-8c97-ace2d3624318', '1', 'has walked in to the campus premises. This is a system generated message.', 'Admin', '2019-01-27 23:04:04', 'Admin', '2019-01-27 23:04:04'),
('9256ccc3-227f-11e9-8c97-ace2d3624318', '2', 'is now going outside of the campus premises. This is a system generated message.', 'Admin', '2019-01-27 23:04:52', 'Admin', '2019-01-27 23:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `party_stdconnector`
--

CREATE TABLE `party_stdconnector` (
  `id` int(255) NOT NULL,
  `partyId` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `userCatId` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `createdBy` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `isDisabled` int(1) NOT NULL,
  `createDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `personID` int(11) NOT NULL,
  `lastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middleName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suffix` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personCivilStatus` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personReligion` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personNationality` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personDOB` date DEFAULT NULL,
  `personGender` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personAge` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personFamilyIncome` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personPlaceOfBirth` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person_image`
--

CREATE TABLE `person_image` (
  `image_id` int(55) NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partyId` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `smslogid` int(11) NOT NULL,
  `smsTo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `createdby` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` int(11) NOT NULL,
  `ipaddress` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `ipaddress`) VALUES
(1, '34535');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `staffPositionId` int(11) DEFAULT NULL,
  `accountID` int(11) DEFAULT NULL,
  `lastName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middleName` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact1` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact2` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recordStatus` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `personID` int(11) DEFAULT NULL,
  `accountID` int(11) DEFAULT NULL,
  `studentNumber` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yearLevel` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courseID` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `semesterID` int(11) DEFAULT NULL,
  `applicationType` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sectionID` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `studentType` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `studentStatus` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdById` int(11) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `modifiedById` int(11) DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_emergencycontact`
--

CREATE TABLE `user_emergencycontact` (
  `contactId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactRelationship` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createDate` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` datetime NOT NULL,
  `personDetailId` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_emergencycontact`
--

INSERT INTO `user_emergencycontact` (`contactId`, `contactName`, `contactRelationship`, `contactNumber`, `createDate`, `createdBy`, `updateDate`, `personDetailId`) VALUES
('37af7c23-19db-11e9-89f2-ace2d3624318', 'Healer', 'Mutter', '09175573914', '2019-01-16 23:08:13', 'Admin', '2019-01-16 23:08:20', '9d85f8f7-c316-11e8-a587-ace2d3624318'),
('701a9173-225f-11e9-8c97-ace2d3624318', 'Other Guy', 'Uncle', '09175573914', '2019-01-27 19:14:50', 'Admin', '2019-01-27 19:14:50', '339dc8b3-19d2-11e9-89f2-ace2d3624318'),
('ea652835-24bd-11e9-a60d-ace2d3624318', 'De One', 'Uncle', '09175278188', '2019-01-30 19:36:11', 'Admin', '2019-01-30 19:36:11', 'd60fa7ff-24bd-11e9-a60d-ace2d3624318');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_family`
--
ALTER TABLE `applicant_family`
  ADD PRIMARY KEY (`personID`);

--
-- Indexes for table `bulknotification_activities`
--
ALTER TABLE `bulknotification_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactlist`
--
ALTER TABLE `contactlist`
  ADD PRIMARY KEY (`contactlistid`);

--
-- Indexes for table `contactlist_users`
--
ALTER TABLE `contactlist_users`
  ADD PRIMARY KEY (`contactlistuserid`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `fk_collegeID` (`departmentID`);

--
-- Indexes for table `gate_cardassignment`
--
ALTER TABLE `gate_cardassignment`
  ADD PRIMARY KEY (`assignmentId`),
  ADD UNIQUE KEY `assignmentId` (`assignmentId`);

--
-- Indexes for table `gate_categorytype`
--
ALTER TABLE `gate_categorytype`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `categoryId` (`categoryId`);

--
-- Indexes for table `gate_coursetype`
--
ALTER TABLE `gate_coursetype`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `gate_history`
--
ALTER TABLE `gate_history`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `gate_persondetails`
--
ALTER TABLE `gate_persondetails`
  ADD PRIMARY KEY (`personDetailId`),
  ADD UNIQUE KEY `personDetailId` (`personDetailId`);

--
-- Indexes for table `gate_personphoto`
--
ALTER TABLE `gate_personphoto`
  ADD PRIMARY KEY (`photoId`);

--
-- Indexes for table `gate_personstatus`
--
ALTER TABLE `gate_personstatus`
  ADD PRIMARY KEY (`gate_personstatusid`);

--
-- Indexes for table `gate_usercategory`
--
ALTER TABLE `gate_usercategory`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `gate_users`
--
ALTER TABLE `gate_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `partyid` (`id_user`);

--
-- Indexes for table `msg_template`
--
ALTER TABLE `msg_template`
  ADD PRIMARY KEY (`messageId`);

--
-- Indexes for table `party_stdconnector`
--
ALTER TABLE `party_stdconnector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`personID`);

--
-- Indexes for table `person_image`
--
ALTER TABLE `person_image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`smslogid`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `fk_accountID2` (`accountID`),
  ADD KEY `fk_blockID_idx` (`sectionID`),
  ADD KEY `fk_degreeProgramID_idx` (`courseID`);

--
-- Indexes for table `user_emergencycontact`
--
ALTER TABLE `user_emergencycontact`
  ADD PRIMARY KEY (`contactId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulknotification_activities`
--
ALTER TABLE `bulknotification_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contactlist`
--
ALTER TABLE `contactlist`
  MODIFY `contactlistid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactlist_users`
--
ALTER TABLE `contactlist_users`
  MODIFY `contactlistuserid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gate_history`
--
ALTER TABLE `gate_history`
  MODIFY `transaction_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `gate_personstatus`
--
ALTER TABLE `gate_personstatus`
  MODIFY `gate_personstatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gate_usercategory`
--
ALTER TABLE `gate_usercategory`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gate_users`
--
ALTER TABLE `gate_users`
  MODIFY `id_user` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `party_stdconnector`
--
ALTER TABLE `party_stdconnector`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `personID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person_image`
--
ALTER TABLE `person_image`
  MODIFY `image_id` int(55) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `smslogid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
