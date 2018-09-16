-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema healthcare
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `healthcare` ;

-- -----------------------------------------------------
-- Schema healthcare
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `healthcare` DEFAULT CHARACTER SET latin1 ;
USE `healthcare` ;

-- -----------------------------------------------------
-- Table `healthcare`.`debug`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`debug` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`debug` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `error` TEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`distrct_record`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`distrct_record` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`distrct_record` (
  `aadhar_id` INT(10) UNSIGNED NOT NULL,
  `disease_name` VARCHAR(100) NOT NULL,
  `remark` TEXT NOT NULL,
  `doctor_id` VARCHAR(10) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `primary_center_id` VARCHAR(45) NOT NULL,
  `reffered_headquarter` ENUM('YES', 'NO') NOT NULL,
  `data recorded` ENUM('YES', 'NO') NOT NULL,
  `number_of_recrded_data` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `operation_detail` ENUM('YES', 'NO') NOT NULL,
  `operation_id` VARCHAR(45) NULL DEFAULT NULL,
  UNIQUE INDEX `doctor_id_UNIQUE` (`doctor_id` ASC),
  UNIQUE INDEX `primary_center_id_UNIQUE` (`primary_center_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`district_data_store`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`district_data_store` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`district_data_store` (
  `aadhar_id` BIGINT(20) NOT NULL,
  `patient_data` BLOB NOT NULL,
  `remark` TEXT NOT NULL,
  `doctor_id` BIGINT(20) NOT NULL,
  `upload_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`district_surgery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`district_surgery` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`district_surgery` (
  `aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  `operation_remark` TEXT NOT NULL,
  `operation_verify` ENUM('YES', 'NO') NOT NULL,
  `operation_doctor_id` VARCHAR(45) NOT NULL,
  `forward_to_headquarter` ENUM('YES', 'NO') NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`doctor_authentication`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`doctor_authentication` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`doctor_authentication` (
  `aadhar_id` BIGINT(20) NOT NULL,
  `password` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `mobile_no` INT(10) UNSIGNED NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `s_ques_1` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `s_ques_2` VARCHAR(45) NOT NULL,
  `doctor_detail_aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `mobile_no_UNIQUE` (`mobile_no` ASC),
  UNIQUE INDEX `email_id_UNIQUE` (`email_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`doctor_registration_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`doctor_registration_detail` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`doctor_registration_detail` (
  `aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  `d_name` VARCHAR(50) NOT NULL,
  `pan_no` BIGINT(20) UNSIGNED NOT NULL,
  `phone_no` INT(10) UNSIGNED NOT NULL,
  `father_name` VARCHAR(50) NOT NULL,
  `gender` ENUM('male', 'female', 'others') NOT NULL,
  `education_qualify` VARCHAR(100) NOT NULL,
  `experience` TEXT NULL DEFAULT NULL,
  `date_of_birth` DATE NOT NULL,
  `house_no` VARCHAR(45) NOT NULL,
  `address1` VARCHAR(45) NULL DEFAULT NULL,
  `address2` VARCHAR(45) NULL DEFAULT NULL,
  `district` VARCHAR(45) NOT NULL,
  `state` ENUM('Andaman and Nicobar', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'New Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'J&K', 'Jharkhand', 'Karnataka', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal') NOT NULL,
  `pincode` INT(6) NOT NULL,
  `security_code` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `doctor_pic` BLOB NOT NULL,
  `position` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `pan_no_UNIQUE` (`pan_no` ASC),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `phone_no_UNIQUE` (`phone_no` ASC),
  UNIQUE INDEX `emailiid_UNIQUE` (`email_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`doctor_registration_detail_backup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`doctor_registration_detail_backup` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`doctor_registration_detail_backup` (
  `aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  `d_name` VARCHAR(50) NOT NULL,
  `pan_no` BIGINT(20) UNSIGNED NOT NULL,
  `phone_no` INT(10) UNSIGNED NOT NULL,
  `father_name` VARCHAR(50) NOT NULL,
  `gender` ENUM('male', 'female', 'others') NOT NULL,
  `eduction_qualify` VARCHAR(100) NOT NULL,
  `experience` TEXT NULL DEFAULT NULL,
  `date_of_birth` DATE NOT NULL,
  `house_no` VARCHAR(45) NOT NULL,
  `address1` VARCHAR(45) NULL DEFAULT NULL,
  `address2` VARCHAR(45) NULL DEFAULT NULL,
  `district` VARCHAR(45) NOT NULL,
  `state` ENUM('Andaman and Nicobar', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'New Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'J&K', 'Jharkhand', 'Karnataka', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal') NOT NULL,
  `pincode` INT(6) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `doctor_pic` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `pan_no_UNIQUE` (`pan_no` ASC),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `phone_no_UNIQUE` (`phone_no` ASC),
  UNIQUE INDEX `email_id_UNIQUE` (`email_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`headquarter_data_store`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`headquarter_data_store` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`headquarter_data_store` (
  `aadhar_id` BIGINT(20) NOT NULL,
  `patient_data` BLOB NOT NULL,
  `remark` TEXT NOT NULL,
  `doctor_id` BIGINT(20) NOT NULL,
  `upload_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`headquarter_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`headquarter_detail` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`headquarter_detail` (
  `aadhar_id` INT(10) UNSIGNED NOT NULL,
  `disease_name` VARCHAR(100) NOT NULL,
  `remark` TEXT NOT NULL,
  `doctor_id` VARCHAR(10) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `primary_center_id` VARCHAR(45) NOT NULL,
  `data recorded` ENUM('YES', 'NO') NOT NULL,
  `number_of_recrded_data` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `operation_detail` ENUM('YES', 'NO') NOT NULL,
  `operation_remark` TEXT NULL DEFAULT NULL,
  UNIQUE INDEX `doctor_id_UNIQUE` (`doctor_id` ASC),
  UNIQUE INDEX `primary_center_id_UNIQUE` (`primary_center_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`patient_verify_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`patient_verify_detail` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`patient_verify_detail` (
  `aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  `pan_no` BIGINT(20) UNSIGNED NOT NULL,
  `p_name` VARCHAR(50) NOT NULL,
  `phone_no` INT(10) UNSIGNED NOT NULL,
  `gender` ENUM('male', 'female', 'others') NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `pincode` INT(10) UNSIGNED NOT NULL,
  `security_code` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `patient_pic` BLOB NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `pan_no_UNIQUE` (`pan_no` ASC),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `phone_no_UNIQUE` (`phone_no` ASC),
  UNIQUE INDEX `email_id_UNIQUE` (`email_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`patient_authentication`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`patient_authentication` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`patient_authentication` (
  `aadhar_id` BIGINT(20) NOT NULL,
  `password` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `mobile_no` INT(10) UNSIGNED NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `s_ques_1` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `s_ques_2` VARCHAR(45) NOT NULL,
  `patient_verify_detail_aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `mobile_no_UNIQUE` (`mobile_no` ASC),
  UNIQUE INDEX `email_id_UNIQUE` (`email_id` ASC),
  INDEX `fk_patient_authentication_patient_verify_detail1_idx` (`patient_verify_detail_aadhar_id` ASC),
  CONSTRAINT `fk_patient_authentication_patient_verify_detail1`
    FOREIGN KEY (`patient_verify_detail_aadhar_id`)
    REFERENCES `healthcare`.`patient_verify_detail` (`aadhar_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`patient_detail_entry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`patient_detail_entry` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`patient_detail_entry` (
  `aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  `p_name` VARCHAR(50) NOT NULL,
  `pan_no` BIGINT(20) NOT NULL,
  `phone_no` INT(10) UNSIGNED NOT NULL,
  `father_name` VARCHAR(50) NOT NULL,
  `gender` ENUM('MALE', 'FEMALE', 'OTHERS') NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `house_no` VARCHAR(45) NOT NULL,
  `town/vill` VARCHAR(45) NOT NULL,
  `address1` VARCHAR(60) NULL DEFAULT NULL,
  `address2` VARCHAR(60) NULL DEFAULT NULL,
  `district` VARCHAR(45) NOT NULL,
  `state` ENUM('Andaman and Nicobar', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'New Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'J&K', 'Jharkhand', 'Karnataka', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal') NOT NULL,
  `pincode` INT(6) NOT NULL,
  `medical_assistant` ENUM('yes', 'no') NOT NULL,
  `entry_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `security_code` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `patient_pic` BLOB NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `phone_no_UNIQUE` (`phone_no` ASC),
  UNIQUE INDEX `pan_no_UNIQUE` (`pan_no` ASC),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `email_id_UNIQUE` (`email_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`patient_detail_entry_backup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`patient_detail_entry_backup` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`patient_detail_entry_backup` (
  `aadhar_id` BIGINT(20) UNSIGNED NOT NULL,
  `p_name` VARCHAR(50) NOT NULL,
  `pan_no` BIGINT(20) NOT NULL,
  `phone_no` INT(10) UNSIGNED NOT NULL,
  `father_name` VARCHAR(50) NOT NULL,
  `gender` ENUM('MALE', 'FEMALE', 'OTHERS') NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `house_no` VARCHAR(45) NOT NULL,
  `town/vill` VARCHAR(45) NOT NULL,
  `address1` VARCHAR(60) NULL DEFAULT NULL,
  `address2` VARCHAR(60) NULL DEFAULT NULL,
  `district` VARCHAR(45) NOT NULL,
  `state` ENUM('Andaman and Nicobar', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'New Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'J&K', 'Jharkhand', 'Karnataka', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal') NOT NULL,
  `pincode` INT(6) NOT NULL,
  `medical_assistant` ENUM('yes', 'no') NOT NULL,
  `entry_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `email_id` VARCHAR(45) CHARACTER SET 'latin1' NOT NULL,
  `patient_pic` BLOB NOT NULL,
  PRIMARY KEY (`aadhar_id`),
  UNIQUE INDEX `phone_no_UNIQUE` (`phone_no` ASC),
  UNIQUE INDEX `pan_no_UNIQUE` (`pan_no` ASC),
  UNIQUE INDEX `aadhar_id_UNIQUE` (`aadhar_id` ASC),
  UNIQUE INDEX `email_id_UNIQUE` (`email_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`primary_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`primary_data` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`primary_data` (
  `aadhar_id` INT(10) UNSIGNED NOT NULL,
  `disease_name` VARCHAR(100) NOT NULL,
  `remark` TEXT NOT NULL,
  `reffer` ENUM('YES', 'NO') NULL DEFAULT NULL,
  `reffer_to` ENUM('distcare', 'headcare') NULL DEFAULT NULL,
  `doctor_id` VARCHAR(10) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `primary_center_id` VARCHAR(45) NOT NULL,
  UNIQUE INDEX `doctor_id_UNIQUE` (`doctor_id` ASC),
  UNIQUE INDEX `primary_center_id_UNIQUE` (`primary_center_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `healthcare`.`surgery_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare`.`surgery_details` ;

CREATE TABLE IF NOT EXISTS `healthcare`.`surgery_details` (
  `aadhar_id` BIGINT(20) NOT NULL,
  `operation_remark` TEXT NOT NULL,
  `operated_verify` ENUM('YES', 'NO') NOT NULL,
  `operated_doctor_id` VARCHAR(45) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
USE `healthcare`;

DELIMITER $$

USE `healthcare`$$
DROP TRIGGER IF EXISTS `healthcare`.`doctor_registration_detail_AFTER_INSERT` $$
USE `healthcare`$$
CREATE
DEFINER=`myuser`@`localhost`
TRIGGER `healthcare`.`doctor_registration_detail_AFTER_INSERT`
AFTER INSERT ON `healthcare`.`doctor_registration_detail`
FOR EACH ROW
BEGIN
insert into doctor_detail values(new.aadhar_id,new.d_name,new.pan_no,new.phone_no,
new.gender,new.date_of_birth,new.education_qualify,new.experience,new.pincode,new.security_code,new.email_id,new.doctor_pic);
END$$


USE `healthcare`$$
DROP TRIGGER IF EXISTS `healthcare`.`doctor_registration_detail_AFTER_UPDATE` $$
USE `healthcare`$$
CREATE
DEFINER=`myuser`@`localhost`
TRIGGER `healthcare`.`doctor_registration_detail_AFTER_UPDATE`
AFTER UPDATE ON `healthcare`.`doctor_registration_detail`
FOR EACH ROW
BEGIN
update doctor_detail set d_name=new.d_name,pan_no=new.pan_no,phone_no=new.phone_no,gender=new.gender,
date_of_birth=new.date_of_birth,education_qualify=new.education_qualify,experience=new.experience,pincode=new.pincode,
security_code=new.security_code,email_id=new.email_id,doctor_pic=new.doctor_pic where aadhar_id=old.aadhar_id;
END$$


USE `healthcare`$$
DROP TRIGGER IF EXISTS `healthcare`.`doctor_registration_detail_BEFORE_DELETE` $$
USE `healthcare`$$
CREATE
DEFINER=`myuser`@`localhost`
TRIGGER `healthcare`.`doctor_registration_detail_BEFORE_DELETE`
BEFORE DELETE ON `healthcare`.`doctor_registration_detail`
FOR EACH ROW
BEGIN
insert into doctor_registration_detail_backup select * from doctor_registration_detail where aadhar_id=old.aadhar_id;
END$$


USE `healthcare`$$
DROP TRIGGER IF EXISTS `healthcare`.`patient_detail_entry_AFTER_INSERT` $$
USE `healthcare`$$
CREATE
DEFINER=`myuser`@`localhost`
TRIGGER `healthcare`.`patient_detail_entry_AFTER_INSERT`
AFTER INSERT ON `healthcare`.`patient_detail_entry`
FOR EACH ROW
BEGIN
insert into patient_verify_detail VALUES
(new.aadhar_id,new.pan_no,new.p_name,new.phone_no,new.gender,new.date_of_birth,
new.pincode,new.security_code,new.email_id,new.patient_pic);
END$$


USE `healthcare`$$
DROP TRIGGER IF EXISTS `healthcare`.`patient_detail_entry_AFTER_UPDATE` $$
USE `healthcare`$$
CREATE
DEFINER=`myuser`@`localhost`
TRIGGER `healthcare`.`patient_detail_entry_AFTER_UPDATE`
AFTER UPDATE ON `healthcare`.`patient_detail_entry`
FOR EACH ROW
BEGIN
update patient_verify_detail 
set pan_no=new.pan_no,p_name=new.p_name,phone_no=new.phone_no,gender=new.gender,
date_of_birth=new.date_of_birth,pincode=new.pincode,security_code=new.security_code,email_id=new.email_id,
patient_pic=new.patient_pic
 where aadhar_id=new.aadhar_id;
END$$


USE `healthcare`$$
DROP TRIGGER IF EXISTS `healthcare`.`patient_detail_entry_BEFORE_DELETE` $$
USE `healthcare`$$
CREATE
DEFINER=`myuser`@`localhost`
TRIGGER `healthcare`.`patient_detail_entry_BEFORE_DELETE`
BEFORE DELETE ON `healthcare`.`patient_detail_entry`
FOR EACH ROW
BEGIN
insert into patient_detail_entry_backup  select * from patient_detail_entry where aadhar_id=old.aadhar_id;
END$$


DELIMITER ;
