ALTER TABLE `basic_details` DROP `course`;

ALTER TABLE `basic_details` DROP `faculty`;

ALTER TABLE `basic_details` DROP `courseType`;

ALTER TABLE `academic_details` ADD `lastUpdated` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `academicDetails`, ADD `creationTime` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `lastUpdated`;

ALTER TABLE `advanced_details` ADD `lastUpdated` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `cCity`, ADD `creationTime` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `lastUpdated`;

ALTER TABLE `basic_details` ADD `lastUpdated` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `payment`, ADD `creationTime` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `lastUpdated`;

ALTER TABLE `documents` ADD `lastUpdated` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `documents`, ADD `creationTime` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `lastUpdated`;

ALTER TABLE `merit_details` ADD `lastUpdated` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `totalMeritCount`, ADD `creationTime` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `lastUpdated`;

ALTER TABLE `payment` ADD `creationTime` 
VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `status`;

CREATE TABLE `faculty_course_details` (
  `id` int(11) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `faculty` varchar(500) NOT NULL,
  `courseType` varchar(500) NOT NULL,
  `major1` varchar(2000) NOT NULL,
  `major2` varchar(500) NOT NULL,
  `major3` varchar(500) NOT NULL,
  `major4` varchar(500) NOT NULL,
  `vocationalSubject` varchar(500) NOT NULL,
  `coCurriculum` varchar(500) NOT NULL,
  `lastUpdated` varchar(500) NOT NULL,
  `creationTime` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `faculty_course_details`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `faculty_course_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


ALTER TABLE `faculty_course_details` ADD `vocationalSem1` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `major4`, 
ADD `vocationalSem2` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `vocationalSem1`, ADD `coCurriculumSem1` VARCHAR(500) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `vocationalSem2`, 
ADD `coCurriculumSem2` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci 
NOT NULL AFTER `coCurriculumSem1`;

ALTER TABLE `faculty_course_details` DROP `coCurriculum`;

ALTER TABLE `faculty_course_details` DROP `vocationalSubject`;