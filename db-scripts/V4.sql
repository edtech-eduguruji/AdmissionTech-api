ALTER TABLE `basic_details` ADD `selection` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `courseFee`

ALTER TABLE `basic_details` CHANGE `selection` `selection` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0';

UPDATE basic_details set selection='0'