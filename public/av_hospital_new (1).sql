-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2022 at 01:49 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_checkup` (IN `checkup_type` TEXT)   BEGIN
select * from checkup where type=checkup_type;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registrations` (IN `index1` INT, IN `length` INT, IN `search` TEXT, IN `type` TEXT)   BEGIN

if search is null then
select *    from registration where registration_type=type limit index1 ,length;
end if;

if search!='' then
select *  from registration where registration_type=type and mobile_number LIKE CONCAT('%', search , '%')
 limit index1 ,length;
end if;



End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registrations_total` (IN `type` TEXT, IN `search` TEXT)   BEGIN

if search is null then
select count(*)  as total  from registration where registration_type=type ;
end if;

if search!='' then
select count( *) as total  from registration where registration_type=type and mobile_number LIKE CONCAT('%', search , '%')
 ;
end if;



End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `query_login` (IN `user_name1` TEXT, IN `pwd1` TEXT)   BEGIN
select * from users where user_name=user_name1 and pwd=pwd1;
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
  `days_from_child_birth` int(11) DEFAULT 0,
  `notification_cycle` int(11) DEFAULT 0,
  `first_alert` int(11) DEFAULT 0,
  `second_alert` int(11) DEFAULT 0,
  `third_alert` int(11) DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `updated_on` datetime NOT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkup`
--

INSERT INTO `checkup` (`id`, `name`, `type`, `days_from_child_birth`, `notification_cycle`, `first_alert`, `second_alert`, `third_alert`, `remarks`, `created_on`, `created_by`, `updated_on`, `status`) VALUES
(1, 'polio', 'vaccination', 10, NULL, NULL, NULL, NULL, NULL, '2019-09-09 20:19:29', 'jagadish', '0000-00-00 00:00:00', 'active');

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

--
-- Dumping data for table `registered_for`
--

INSERT INTO `registered_for` (`id`, `registration_id`, `checkup_id`, `checkup`, `created_on`) VALUES
(1, 1, 1, 'polio', '2022-07-28 01:26:52'),
(2, 2, 1, 'polio', '2022-07-28 01:34:31'),
(3, 3, 1, 'polio', '2022-07-28 03:45:37');

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

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `dob`, `mobile_number`, `email_id`, `address`, `pin_code`, `remarks`, `created_on`, `created_by`, `registration_type`, `updated_on`, `status`, `notification_status`, `notification_sent_on`) VALUES
(1, 'null', '0000-00-00', 'null', 'null', 'null', 0, 'null', '2022-07-28 01:26:52', 'jagadish', 'vaccination', NULL, 'active', '0', NULL),
(2, 'Jagadish Kumar TR', '2022-07-28', '9902128649', 'jagu123.indian@gmail.com', 'Raghavendra Nagar,Kuvempu Road', 572102, 'null', '2022-07-28 01:34:31', 'jagadish', 'vaccination', NULL, 'active', '0', NULL),
(3, 'Shoaib H N', '2022-07-28', '9845445455', 'mohammeddshoaib16@gmail.com', '#297,8th cross, Jhbcs Layout, j P Nagar, Bengaluru', 560078, 'null', '2022-07-28 03:45:37', 'jagadish', 'vaccination', NULL, 'active', '0', NULL);

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `pwd`, `mobile_number`, `address`, `role`, `created_on`, `updated_on`, `status`) VALUES
(1, 'surgery', 'jagadish', '12345', '0', '11', 'admin', '2019-09-09 20:19:29', NULL, 'active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `checkup_non_routine`
--
ALTER TABLE `checkup_non_routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_for`
--
ALTER TABLE `registered_for`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
