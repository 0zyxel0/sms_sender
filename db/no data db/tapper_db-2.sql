-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2017 at 12:28 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tapper_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryAbsentTimeline`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryEarlyTimeline`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryLateTimeline`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryReport`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateHistoryTimeline`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateScanningExtract`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GateScanTopUp`()
    NO SQL
SELECT pi.image_url,ps.partyId,gh.createDate,ps.card_id,c.courseCode
FROM gate_history gh
JOIN party_stdconnector ps on ps.card_id = gh.card_id
JOIN person_image pi on pi.partyId = ps.partyId
JOIN student s on s.studentnumber = ps.partyid
LEFT JOIN course c on c.courseID = s.courseID
ORDER BY gh.transaction_id DESC
LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GenerateAllUsers`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GenerateStudentListReport`()
    NO SQL
SELECT distinct 
'<img src=<?php echo base_url()?>'+pi.image_url+'height="42" width="42">' as'image_url',
pi.image_url,s.studentNumber, p.lastname, p.firstname,s.studentType,s.studentstatus, case when pi.image_url is NULL then "N" Else "Y" END AS "Upload"
FROM student s 
left join person p on s.personID = p.personID
left join person_image pi on pi.partyId = s.studentNumber$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GetAllUserCategory`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GetExistingCardUsers`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_getGuardianList`()
    NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_GuardianContactDetails`()
    NO SQL
SELECT 

p.firstName + ' ' + p.lastName as 'Student Name'
,af.guardianFirstName + ' ' + af.guardianLastName as 'Guardian Name'
,af.guardianContact 'Guardian Contact Details' 

FROM person p
left join applicant_family  af on p.personId = af.personId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_ImageGateHistory`()
    NO SQL
select 
pp.image_url AS 'url'
from gate_history gh
left join gate_cardassignment ga on gh.card_id = ga.card_id
left join gate_persondetails gd on gd.persondetailId = ga.partyid
left join gate_personphoto pp on pp.persondetailId = gd.persondetailId
ORDER BY gh.transaction_id DESC
LIMIT 7$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_MsgTemplates`()
    NO SQL
select 
messageId AS 'Id',
message_type AS 'Type',
msg_text AS 'Text',
updatedBy As 'By',
updateDate as 'date'
from msg_template$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fn_StudentAbsentList`()
    NO SQL
    COMMENT 'Generate a List of Students that are absent'
select distinct card_id from gate_history
where cast(createdate as date) = cast(now() as date)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_family`
--

CREATE TABLE IF NOT EXISTS `applicant_family` (
  `personID` int(11) NOT NULL,
  `occupationM` varchar(45) DEFAULT NULL,
  `occupationF` varchar(45) DEFAULT NULL,
  `motherFirstName` varchar(45) DEFAULT NULL,
  `motherLastName` varchar(45) DEFAULT NULL,
  `motherContact` varchar(45) DEFAULT NULL,
  `fatherFirstName` varchar(45) DEFAULT NULL,
  `fatherLastName` varchar(45) DEFAULT NULL,
  `fatherContact` varchar(45) DEFAULT NULL,
  `guardianFirstName` varchar(45) DEFAULT NULL,
  `guardianLastName` varchar(45) DEFAULT NULL,
  `guardianContact` varchar(45) DEFAULT NULL,
  `guardianAddress` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`personID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` int(11) NOT NULL,
  `courseName` varchar(70) DEFAULT NULL,
  `courseCode` varchar(45) DEFAULT NULL,
  `courseType` varchar(45) DEFAULT NULL,
  `departmentID` int(11) DEFAULT NULL,
  `schoolLevel` varchar(20) DEFAULT NULL,
  `courseYears` int(2) DEFAULT NULL,
  `durationMonths` int(5) DEFAULT NULL,
  `dateAdded` date DEFAULT NULL,
  `dateModified` date DEFAULT NULL,
  `recordStatus` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`courseID`),
  KEY `fk_collegeID` (`departmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_cardassignment`
--

CREATE TABLE IF NOT EXISTS `gate_cardassignment` (
  `assignmentId` varchar(255) NOT NULL,
  `partyId` varchar(255) NOT NULL,
  `card_id` varchar(128) NOT NULL,
  `categoryId` varchar(255) NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  `isDisabled` int(2) NOT NULL,
  PRIMARY KEY (`assignmentId`),
  UNIQUE KEY `assignmentId` (`assignmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_categorytype`
--

CREATE TABLE IF NOT EXISTS `gate_categorytype` (
  `categoryId` varchar(255) NOT NULL,
  `categoryType` varchar(20) NOT NULL,
  `categoryName` varchar(100) NOT NULL,
  `gateTimeInSetting` time DEFAULT NULL,
  `gateTimeSettingAbsent` time DEFAULT NULL,
  `createdBy` varchar(255) NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_coursetype`
--

CREATE TABLE IF NOT EXISTS `gate_coursetype` (
  `courseId` varchar(255) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `courseType` varchar(255) NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`courseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_history`
--

CREATE TABLE IF NOT EXISTS `gate_history` (
  `transaction_id` int(255) NOT NULL AUTO_INCREMENT,
  `card_id` varchar(55) NOT NULL,
  `createDate` datetime NOT NULL,
  `gate_id` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gate_persondetails`
--

CREATE TABLE IF NOT EXISTS `gate_persondetails` (
  `personDetailId` varchar(255) NOT NULL DEFAULT '' COMMENT 'UUID primary key for tables',
  `userGivenId` varchar(255) DEFAULT NULL,
  `familyname` varchar(255) NOT NULL,
  `givenname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `civilStatus` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `age` int(3) NOT NULL,
  `categoryId` varchar(128) DEFAULT NULL,
  `createdBy` varchar(255) NOT NULL,
  `updateDate` varchar(255) NOT NULL,
  PRIMARY KEY (`personDetailId`),
  UNIQUE KEY `personDetailId` (`personDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_personphoto`
--

CREATE TABLE IF NOT EXISTS `gate_personphoto` (
  `photoId` varchar(255) NOT NULL,
  `personDetailId` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `createDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_usercategory`
--

CREATE TABLE IF NOT EXISTS `gate_usercategory` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `userType` varchar(51) NOT NULL,
  `userCatId` varchar(4) NOT NULL,
  `userTimeSetting` time NOT NULL,
  `updateDate` datetime NOT NULL,
  `updatedBy` varchar(51) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gate_users`
--

CREATE TABLE IF NOT EXISTS `gate_users` (
  `id_user` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(25) NOT NULL,
  `createdDate` date NOT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updateDate` date NOT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `partyid` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gate_users`
--

INSERT INTO `gate_users` (`id_user`, `username`, `password`, `createdDate`, `createdBy`, `updateDate`, `updatedBy`) VALUES
(1, 'Admin', 'pass', '2017-09-28', 'Admin', '2017-09-28', 'Admin'),
(2, 'Gate', 'pass', '2017-09-28', 'Admin', '2017-09-28', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `msg_template`
--

CREATE TABLE IF NOT EXISTS `msg_template` (
  `messageId` varchar(255) NOT NULL,
  `message_type` varchar(20) NOT NULL,
  `msg_text` varchar(255) NOT NULL,
  `createdBy` varchar(100) NOT NULL,
  `createDate` datetime NOT NULL,
  `updatedBy` varchar(100) NOT NULL,
  `updateDate` datetime NOT NULL,
  PRIMARY KEY (`messageId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `party_stdconnector`
--

CREATE TABLE IF NOT EXISTS `party_stdconnector` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `partyId` varchar(150) NOT NULL,
  `card_id` varchar(55) NOT NULL,
  `userCatId` varchar(4) NOT NULL,
  `createdBy` varchar(150) NOT NULL,
  `isDisabled` int(1) NOT NULL,
  `createDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `personID` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(45) DEFAULT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `middleName` varchar(45) DEFAULT NULL,
  `suffix` varchar(45) DEFAULT NULL,
  `personCivilStatus` varchar(45) DEFAULT NULL,
  `personReligion` varchar(45) DEFAULT NULL,
  `personNationality` varchar(45) DEFAULT NULL,
  `personDOB` date DEFAULT NULL,
  `personGender` varchar(45) DEFAULT NULL,
  `personAge` varchar(45) DEFAULT NULL,
  `personFamilyIncome` varchar(45) DEFAULT NULL,
  `personPlaceOfBirth` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`personID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `person_image`
--

CREATE TABLE IF NOT EXISTS `person_image` (
  `image_id` int(55) NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) NOT NULL,
  `partyId` varchar(55) NOT NULL,
  `updateDate` date DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staffID` int(11) NOT NULL,
  `staffPositionId` int(11) DEFAULT NULL,
  `accountID` int(11) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `middleName` varchar(45) DEFAULT NULL,
  `gender` varchar(7) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact1` varchar(15) DEFAULT NULL,
  `contact2` varchar(15) DEFAULT NULL,
  `recordStatus` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`staffID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `studentID` int(11) NOT NULL,
  `personID` int(11) DEFAULT NULL,
  `accountID` int(11) DEFAULT NULL,
  `studentNumber` varchar(10) DEFAULT NULL,
  `yearLevel` varchar(45) DEFAULT NULL,
  `courseID` varchar(45) DEFAULT NULL,
  `semesterID` int(11) DEFAULT NULL,
  `applicationType` varchar(45) DEFAULT NULL,
  `sectionID` varchar(45) DEFAULT NULL,
  `studentType` varchar(45) DEFAULT NULL,
  `studentStatus` varchar(45) DEFAULT NULL,
  `createdById` int(11) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `modifiedById` int(11) DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  PRIMARY KEY (`studentID`),
  KEY `fk_accountID2` (`accountID`),
  KEY `fk_blockID_idx` (`sectionID`),
  KEY `fk_degreeProgramID_idx` (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_emergencycontact`
--

CREATE TABLE IF NOT EXISTS `user_emergencycontact` (
  `contactId` varchar(255) NOT NULL,
  `contactName` varchar(255) DEFAULT NULL,
  `contactRelationship` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(255) DEFAULT NULL,
  `createDate` datetime NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `updateDate` datetime NOT NULL,
  `personDetailId` varchar(255) NOT NULL,
  PRIMARY KEY (`contactId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
