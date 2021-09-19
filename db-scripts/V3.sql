
ALTER TABLE `basic_details` CHANGE `registrationNo` `registrationNo` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `vaccinated` `vaccinated` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `nameTitle` `nameTitle` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `dob` `dob` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `gender` `gender` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `religion` `religion` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `caste` `caste` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `category` `category` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `subCategory` `subCategory` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `personalMobile` `personalMobile` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `aadharNo` `aadharNo` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `email` `email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `creationTime` `creationTime` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `basic_details` CHANGE `lastUpdated` `lastUpdated` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `basic_details` CHANGE `submitted` `submitted` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `payment` `payment` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `wrn` `wrn` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `basic_details` CHANGE `mediumOfInstitution` `mediumOfInstitution` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `basic_details` DROP INDEX `basicDetailIndex`, ADD INDEX `basicDetailIndex` (`id`, `registrationNo`, `lastUpdated`, `creationTime`) USING BTREE;



ALTER TABLE `academic_details` CHANGE `lastUpdated` `lastUpdated` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `academic_details` CHANGE `creationTime` `creationTime` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `academic_details` DROP PRIMARY KEY, ADD INDEX `academicDetails` (`id`, `registrationNo`) USING BTREE;


ALTER TABLE `advanced_details` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `registrationNo` `registrationNo` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `fatherName` `fatherName` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `motherName` `motherName` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `parentsOccupation` `parentsOccupation` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `guardianName` `guardianName` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `relationOfApplicant` `relationOfApplicant` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `houseNo` `houseNo` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `street` `street` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `pincode` `pincode` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `postOffice` `postOffice` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `state` `state` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `city` `city` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `cHouseNo` `cHouseNo` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `cStreet` `cStreet` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `cPincode` `cPincode` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `cPostOffice` `cPostOffice` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `cState` `cState` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `cCity` `cCity` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lastUpdated` `lastUpdated` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `creationTime` `creationTime` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `advanced_details` DROP PRIMARY KEY, ADD INDEX `advanceDetails` (`id`, `registrationNo`) USING BTREE;



ALTER TABLE `documents` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, 
CHANGE `registrationNo` `registrationNo` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `lastUpdated` `lastUpdated` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `creationTime` `creationTime` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `documents` DROP PRIMARY KEY, ADD INDEX `documentDetail` (`id`, `registrationNo`) USING BTREE;



ALTER TABLE `faculty_course_details` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, 
CHANGE `registrationNo` `registrationNo` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `faculty` `faculty` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `courseType` `courseType` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `vocationalSem1` `vocationalSem1` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `vocationalSem2` `vocationalSem2` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `coCurriculumSem1` `coCurriculumSem1` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `coCurriculumSem2` `coCurriculumSem2` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `lastUpdated` `lastUpdated` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `creationTime` `creationTime` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `faculty_course_details` DROP PRIMARY KEY, ADD INDEX `facultyCouseDetail` (`id`, `registrationNo`) USING BTREE;



ALTER TABLE `merit_details` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, 
CHANGE `registrationNo` `registrationNo` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `nationalCompetition` `nationalCompetition` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `otherCompetition` `otherCompetition` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `ncc` `ncc` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `roverRanger` `roverRanger` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `bcom` `bcom` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `other` `other` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `totalMeritCount` `totalMeritCount` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, 
CHANGE `lastUpdated` `lastUpdated` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `creationTime` `creationTime` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


ALTER TABLE `merit_details` DROP PRIMARY KEY, ADD INDEX `mertiDetail` (`id`, `registrationNo`) USING BTREE;


ALTER TABLE `payment` DROP PRIMARY KEY, ADD INDEX `paymentDetail` (`id`, `registrationNo`) USING BTREE;


ALTER TABLE `users_info` DROP PRIMARY KEY, ADD INDEX `userDetail` (`id`, `user_id`, `user_name`, `password`) USING BTREE;


ALTER TABLE `payment` ADD `RefundStatus` VARCHAR(100) NOT NULL AFTER `checksum`, 
ADD `TotalRefundAmount` VARCHAR(100) NOT NULL AFTER `RefundStatus`, ADD `LastRefundDate` VARCHAR(100) NOT NULL AFTER `TotalRefundAmount`, 
ADD `LastRefundRefNo` VARCHAR(100) NOT NULL AFTER `LastRefundDate`, ADD `updatedTime` VARCHAR(100) NOT NULL AFTER `LastRefundRefNo`;


ALTER TABLE `faculty_course_details` ADD `admissionYear` 
VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `courseType`;

ALTER TABLE `faculty_course_details` CHANGE `admissionYear` `admissionYear` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1';


ALTER TABLE `basic_details` ADD `courseFee` INT(2) NOT NULL DEFAULT '0' AFTER `creationTime`;

ALTER TABLE `payment` ADD `courseFee` VARCHAR(2) NOT NULL DEFAULT '0' AFTER `TxnDate`;