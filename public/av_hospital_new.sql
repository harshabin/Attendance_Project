-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2022 at 06:10 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `av_hospital_new`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_checkup` (IN `input_data` JSON, IN `checkup_non_routine` JSON)   BEGIN
DECLARE i INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;
DECLARE id INT DEFAULT 0;
set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].name'));
set @type=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].type'));
set @days_from_child_birth=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].days_from_child_birth'));
set @notification_cycle=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].notification_cycle'));
set @first_alert=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].first_alert'));
set @second_alert=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].second_alert'));
set @third_alert=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].third_alert'));
set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_on'));
set @created_by=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_by'));
set @remarks=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].remarks'));

insert into checkup(name,type,days_from_child_birth,notification_cycle,first_alert,second_alert,third_alert,remarks,created_on,created_by) VALUES(@name,@type,@days_from_child_birth,@notification_cycle,@first_alert,@second_alert,@third_alert,@remarks,@created_on,@created_by);
SET @parent_id=LAST_INSERT_ID();

SET @value='non_routine';
IF @type = @value 
THEN
SET @details =checkup_non_routine;
SET @details_length = JSON_LENGTH(@details);

WHILE i < @details_length DO
    SET @check_up_days = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].check_up_days')));
    SET @first_alert = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].first_alert')));
    SET @second_alert = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].second_alert')));
    SET @third_alert = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].third_alert')));
    
    insert into checkup_non_routine(parent_id,check_up_days,first_alert,second_alert,third_alert,created_on)
    values(@parent_id,@check_up_days,@first_alert,@second_alert,@third_alert,@created_on);
    SELECT i + 1 INTO i;
END WHILE;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_registration` (IN `checkup` JSON, IN `input_data` JSON)   BEGIN
DECLARE i INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;
DECLARE id INT DEFAULT 0;
set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].name'));
set @dob=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].dob'));
set @mobile_number=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].mobile_number'));
set @email_id=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].email_id'));
set @address=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].address'));
set @pin_code=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].pin_code'));
set @remarks=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].remarks'));
set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_on'));
set @created_by=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_by'));
set @registration_type=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].registration_type'));

insert into registration(name,dob,mobile_number,email_id,address,pin_code,remarks,created_on,created_by,registration_type) VALUES(@name,@dob,@mobile_number,@email_id,@address,@pin_code,@remarks,@created_on,@created_by,@registration_type);
SET registration_id=LAST_INSERT_ID();



SET @details =checkup;
SET @details_length = JSON_LENGTH(@details);
select @details_length;
WHILE i < @details_length DO
    SET @id = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].id')));
    SET @name = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].name')));
    insert into registered_for(registration_id,checkup_id,checkup,created_on)
    values(registration_id,@id,@name,@created_on);
    SELECT i + 1 INTO i;
END WHILE;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_sms_settings` (IN `input_data` JSON)   BEGIN
DECLARE i INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;
DECLARE id INT DEFAULT 0;
set @text=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].text'));
set @url=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].url'));
set @created_by=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_by'));
set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_on'));

insert into sms_settings(text,url,created_by,created_on) VALUES(@text,@url,@created_by,@created_on);


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_users` (IN `input_data` JSON)   BEGIN
DECLARE i INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;
DECLARE id INT DEFAULT 0;
set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].name'));
set @user_name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].user_name'));
set @pwd=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].pwd'));
set @mobile_number=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].mobile_number'));
set @address=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].address'));
set @role=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].role'));
set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_on'));

insert into users(name,user_name,pwd,mobile_number,address,role,created_on) VALUES(@name,@user_name,@pwd,@mobile_number,@address,@role,@created_on);


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `checkup`
--

CREATE TABLE `checkup` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` enum('vaccination','routine','non_routine') NOT NULL,
  `days_from_child_birth` int(11) NOT NULL DEFAULT 0,
  `notification_cycle` int(11) NOT NULL DEFAULT 0,
  `first_alert` int(11) NOT NULL DEFAULT 0,
  `second_alert` int(11) NOT NULL DEFAULT 0,
  `third_alert` int(11) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `updated_on` datetime NOT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `checkup_non_routine`
--

CREATE TABLE `checkup_non_routine` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `check_up_days` int(11) NOT NULL DEFAULT 0,
  `first_alert` int(11) NOT NULL DEFAULT 0,
  `second_alert` int(11) NOT NULL DEFAULT 0,
  `third_alert` int(11) NOT NULL DEFAULT 0,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registered_for`
--

CREATE TABLE `registered_for` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `checkup_id` int(11) NOT NULL,
  `checkup` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `pin_code` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `registration_type` enum('vaccination','checkup') NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `notification_status` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `notification_sent_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `url` text NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `role` enum('admin','receptionist') NOT NULL DEFAULT 'receptionist',
  `created_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkup`
--
ALTER TABLE `checkup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkup_non_routine`
--
ALTER TABLE `checkup_non_routine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_for`
--
ALTER TABLE `registered_for`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkup`
--
ALTER TABLE `checkup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkup_non_routine`
--
ALTER TABLE `checkup_non_routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_for`
--
ALTER TABLE `registered_for`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
