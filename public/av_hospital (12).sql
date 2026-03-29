-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2022 at 10:44 AM
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
-- Database: `av_hospital`
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
set @send_alerts_before=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].send_alerts_before'));

insert into checkup(name,type,days_from_child_birth,notification_cycle,first_alert,second_alert,third_alert,remarks,created_on,created_by,send_alerts_before) VALUES(@name,@type,@days_from_child_birth,@notification_cycle,@first_alert,@second_alert,@third_alert,@remarks,@created_on,@created_by,@send_alerts_before);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_checkups_history` (IN `input_data` JSON)   BEGIN

set @checkup_date=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].checkup_date'));
set @doctor_name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].doctor_name'));
set @remarks=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].remarks'));
set @registration_id=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].registration_id'));
set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_on'));
set @checkup=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].checkup'));

set @created_by=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].created_by'));

insert into checkups_history(checkup_date,doctor_name,remarks,registration_id,checkup,created_on,created_by) VALUES(@checkup_date,@doctor_name,@remarks,@registration_id,@checkup,@created_on,@created_by);



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

set @is_unique=(select count(*) from users where user_name= @user_name);
select @is_unique as is_unique;
if @is_unique<>1 THEN
insert into users(name,user_name,pwd,mobile_number,address,role,created_on) VALUES(@name,@user_name,@pwd,@mobile_number,@address,@role,@created_on);
end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `check_for_unique_checkup` (IN `input_data` JSON, IN `checkup_non_routine` JSON)   BEGIN
DECLARE i INT DEFAULT 0;
DECLARE count INT DEFAULT 0;
DECLARE id INT DEFAULT 0;
set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].name'));
set @type=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].type'));
set count=(select count(*) as count from checkup where  name=@name);
select count;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `check_for_unique_checkup_id` (IN `input_data` JSON)   BEGIN

DECLARE count INT DEFAULT 0;

set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.name'));
set @type=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.type'));
set @ids=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.ids'));
set count=(select count(*) as count from checkup where id<>@ids and name=@name);
SELECT count;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_checkup` (IN `id1` INT)   BEGIN
DELETE from checkup where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_checkups_history` (IN `id1` INT)   BEGIN
delete from checkups_history where id=id1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_registration` (IN `id1` TEXT)   BEGIN
DELETE from registration where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_users` (IN `id1` INT)   BEGIN
DELETE from users where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `disable_checkup` (IN `id1` INT, IN `status1` TEXT)   BEGIN
update checkup set status=status1 where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `disable_registration` (IN `id1` TEXT, IN `status1` TEXT)   BEGIN
update registration set status=status1 where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `disable_users` (IN `id1` INT, IN `status1` TEXT)   BEGIN
update users set status=status1 where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_checkup` (IN `checkup_type` TEXT)   BEGIN
select * from checkup where type=checkup_type and status="active";
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_checkup_other` (IN `checkup_type` TEXT)   BEGIN
select * from checkup where type!=checkup_type and STATUS="active";
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_routine_non_routine` (IN `id1` INT)   BEGIN
select checkup_non_routine.* from checkup join checkup_non_routine where checkup.id=checkup_non_routine.parent_id and checkup.id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_menus` ()   BEGIN
select * from menus;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_users` (IN `term` TEXT)   BEGIN
select * from users where role<>"admin" and name  LIKE CONCAT('%', term , '%') ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_checkups_history` (IN `index1` INT, IN `length` INT, IN `search` TEXT, IN `id1` INT)   BEGIN

if search is null then
select count(*)  as total  from checkups_history where registration_id=id1 ;
end if;

if search<>'' then
select count( *) as total  from checkups_history where registration_id=id1 and (checkup LIKE CONCAT('%', search , '%') or doctor_name LIKE CONCAT('%', search , '%') or checkup_date LIKE CONCAT('%', search , '%') or 
created_by LIKE CONCAT('%', search , '%'))
 ;
end if;

 if search is null then
select checkups_history.*,checkup.name as checkup    from checkups_history join checkup where registration_id=id1 and checkup.id=checkups_history.checkup  order by id desc limit index1 ,length;
end if;

if search<>'' then


select checkups_history.* ,checkup.name as checkup  from checkups_history join checkup where checkups_history.checkup=checkup.id and  registration_id=id1 and (name LIKE CONCAT('%', search , '%') or doctor_name LIKE CONCAT('%', search , '%') or checkup_date LIKE CONCAT('%', search , '%') or 
checkups_history.created_by LIKE CONCAT('%', search , '%'))  order by id desc
 limit index1 ,length;
end if;



End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_checkups_history_cron` (IN `id1` INT, IN `chk_id` INT)   BEGIN
select * from checkups_history where registration_id=id1 and checkup=chk_id order by id desc limit 1; 


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_checkup_cron` (IN `id1` TEXT)   BEGIN

select chkp.* from checkup chkp JOIN registered_for rf where chkp.id=rf.checkup_id and rf.registration_id=id1; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_checkup_non_routine_cron` (IN `id1` INT)   BEGIN

select chkp_non.*,chkp.type,chkp.name from checkup chkp JOIN registered_for rf 
join checkup_non_routine chkp_non where chkp.id=rf.checkup_id and rf.registration_id=id1 and chkp_non.parent_id=chkp.id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_master_vaccination` (IN `index1` INT, IN `length` INT, IN `search` TEXT, IN `type1` TEXT)   BEGIN
if type1 ="vaccination" then
if search is null then
select *    from checkup where type=type1  order by id desc limit index1 ,length;
end if;

if search!='' then
select *  from checkup where type=type1 and name LIKE CONCAT('%', search , '%')  order by id desc
 limit index1 ,length;
end if;
end if;

if type1 <>"vaccination" then
if search is null then
select *    from checkup where type<>"vaccination" order by id desc limit index1 ,length;
end if;

if search!='' then
select *  from checkup where type<>"vaccination" and name LIKE CONCAT('%', search , '%')
 order by id desc limit index1 ,length;
end if;
end if;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_master_vaccination_id` (IN `id1` INT)   BEGIN
select * from checkup where id=id1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_master_vaccination_total` (IN `type1` TEXT, IN `search` TEXT)   BEGIN
if type1 ="vaccination" then
if search is null then
select count(*)  as total  from checkup where type=type1 ;
end if;

if search!='' then
select count( *) as total  from checkup where type=type1 and name LIKE CONCAT('%', search , '%')
 ;
end if;
end if;

if type1 <>"vaccination" then
if search is null then
select count(*)  as total  from checkup where type<>"vaccination" ;
end if;

if search!='' then
select count( *) as total  from checkup where type<>"vaccination" and name LIKE CONCAT('%', search , '%')
 ;
end if;
end if;
End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registrations` (IN `index1` INT, IN `length` INT, IN `search` TEXT, IN `type` TEXT)   BEGIN

if search is null then
select *    from registration where registration_type=type order by id desc limit index1 ,length;
end if;

if search!='' then
select *  from registration where registration_type=type and (mobile_number LIKE CONCAT('%', search , '%') or name LIKE CONCAT('%', search , '%'))
 order by id desc limit index1 ,length;
end if;



End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registrations_id` (IN `id1` TEXT)   BEGIN
 SELECT * from registration where id=id1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registrations_total` (IN `type` TEXT, IN `search` TEXT)   BEGIN

if search is null then
select count(*)  as total  from registration where registration_type=type ;
end if;

if search!='' then
select count( *) as total  from registration where registration_type=type and (mobile_number LIKE CONCAT('%', search , '%') or name LIKE CONCAT('%', search , '%'))
 ;
end if;



End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registration_cron` ()   BEGIN
   SELECT * from registration where STATUS="active";


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_registration_for_id` (IN `id1` TEXT)   BEGIN
SELECT checkup.*
from registered_for join checkup where checkup.id=registered_for.checkup_id and registration_id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sms_details` ()   BEGIN
select * from sms_settings;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_smtp_settings` ()   BEGIN
select * from smtp_settings;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_users` (IN `index1` INT, IN `length` INT, IN `search` TEXT)   BEGIN

if search is null then
select count(*)  as total  from users where role<>'admin' ;
end if;

if search<>'' then
select count( *) as total  from users where role<>'admin' and user_name LIKE CONCAT('%', search , '%')
 ;
end if;

if search is null then
select *    from users where role<>'admin'  order by id desc limit index1 ,length;
end if;

if search<>'' then
select *  from users where role<>'admin' and user_name LIKE CONCAT('%', search , '%')  order by id desc
 limit index1 ,length;
end if;



End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_users_id` (IN `id1` INT)   BEGIN
SELECT * from users where id=id1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_for_menu` (IN `id` TEXT)   BEGIN
SELECT * from users where user_name=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `query_login` (IN `user_name1` TEXT, IN `pwd1` TEXT)   BEGIN
select * from users where user_name=user_name1 and pwd=pwd1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `revert_sms_status_cron` ()   BEGIN

update registration set sms_status="active" where status="active";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sms_update` (IN `input_data` JSON)   BEGIN
DECLARE success INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;

set @text=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.text'));
set @url=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.url'));

set @ids=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.ids'));
set @checkup_text=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.checkup_text'));

update sms_settings set checkup_text=@checkup_text, text=@text,url=@url where id=@ids;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `smtp_update` (IN `input_data` JSON)   BEGIN
DECLARE success INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;

set @host=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.host'));
set @port=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.port'));

set @ids=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.ids'));

set @user_name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.user_name'));
set @password=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.password'));
update smtp_settings set host=@host,port=@port,password=@password,user_name=@user_name  where id=@ids;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `test` (IN `input_data` TEXT)  NO SQL BEGIN
select * from checkup;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_checkup` (IN `input_data` JSON, IN `checkup_non_routine` JSON)   BEGIN
DECLARE success INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;

set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.name'));
set @type=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.type'));
set @days_from_child_birth=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.days_from_child_birth'));
set @notification_cycle=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.notification_cycle'));
set @first_alert=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.first_alert'));
set @second_alert=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.second_alert'));
set @third_alert=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.third_alert'));
set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.created_on'));
set @created_by=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.created_by'));
set @remarks=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.remarks'));
set @send_alerts_before=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.send_alerts_before'));
set @ids=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.ids'));

update checkup set name=@name,days_from_child_birth=@days_from_child_birth,
send_alerts_before=@send_alerts_before,remarks=@remarks where id=@ids;
set success=1;
select success;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_checkup_routine` (IN `input_data` JSON, IN `checkup_non_routine` JSON)   BEGIN
DECLARE i INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;

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
set @send_alerts_before=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].send_alerts_before'));
set @ids=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].ids'));

if @type ="routine" then

update checkup set name=@name,first_alert=@first_alert, second_alert=@second_alert,
third_alert=@third_alert,
notification_cycle=@notification_cycle,
updated_on=@created_on,
type=@type,
remarks=@remarks where id=@ids;
DELETE from checkup_non_routine where parent_id=@ids;
end if;
SET @parent_id=@ids;

SET @value='non_routine';
IF @type = @value 
THEN
update checkup set name=@name,
updated_on=@created_on,
type=@type,
remarks=@remarks where id=@ids;
SET @details =checkup_non_routine;
SET @details_length = JSON_LENGTH(@details);
DELETE from checkup_non_routine where parent_id=@ids;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_registration` (IN `checkup` JSON, IN `input_data` JSON)   BEGIN
DECLARE i INT DEFAULT 0;

DECLARE id1 int;

set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].name'));
set @dob=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].dob'));
set @mobile_number=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].mobile_number'));
set @email_id=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].email_id'));
set @address=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].address'));
set @pin_code=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].pin_code'));
set @remarks=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].remarks'));
set @updated_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].updated_on'));
set id1=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$[0].ids'));
SET @registration_id=id1;
update registration set name=@name,dob=@dob,mobile_number=@mobile_number,email_id=@email_id,address=@address,pin_code=@pin_code,remarks=@remarks,updated_on =@updated_on where id=id1;



delete from registered_for where registration_id=id1;

SET @details =checkup;
SET  @details_length = JSON_LENGTH(@details);

WHILE i < @details_length DO
    SET @id = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].id')));
    SET @name = JSON_UNQUOTE(JSON_EXTRACT(@details, CONCAT('$[',i,'].name')));
    insert into registered_for(registration_id,checkup_id,checkup,created_on)
    values(@registration_id,@id,@name,@updated_on);
    SELECT i + 1 INTO i;
END WHILE;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_send_notification_cron` (IN `id1` INT, IN `date` TEXT)   BEGIN
update registration set notification_sent_on=date where id=id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_sms_status_cron` (IN `id1` INT)   BEGIN
update registration set sms_status="disabled" where id=id1;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_users` (IN `input_data` JSON)   BEGIN
DECLARE success INT DEFAULT 0;
DECLARE registration_id INT DEFAULT 0;

set @name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.name'));
set @role=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.role'));
set @pwd=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.pwd'));
set @user_name=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.user_name'));
set @address=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.address'));
set @mobile_number=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.mobile_number'));

set @created_on=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.created_on'));
set @ids=JSON_UNQUOTE(JSON_EXTRACT(input_data,'$.ids'));
set @count=(select count(*) from users where user_name=@user_name and id<>@ids);
select @count as is_unique;

if @count<1 then

update users set name=@name,pwd=@pwd,updated_on=@created_on,
user_name=@user_name,mobile_number=@mobile_number,address=@address where id=@ids;
end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `user_accessibility_update` (IN `data` JSON, IN `user` TEXT)   BEGIN
UPDATE users set accessibility=data where user_name=user; 
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
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `send_alerts_before` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkup`
--

INSERT INTO `checkup` (`id`, `name`, `type`, `days_from_child_birth`, `notification_cycle`, `first_alert`, `second_alert`, `third_alert`, `remarks`, `created_on`, `created_by`, `updated_on`, `status`, `send_alerts_before`) VALUES
(3, 'Surgery', 'non_routine', NULL, 90, 0, 0, 0, 'null', '2022-08-08 11:34:59', 'jagadish', '0000-00-00 00:00:00', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `checkups_history`
--

CREATE TABLE `checkups_history` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `doctor_name` varchar(200) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `checkup` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `checkup_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkups_history`
--

INSERT INTO `checkups_history` (`id`, `registration_id`, `doctor_name`, `created_on`, `created_by`, `checkup`, `remarks`, `updated_on`, `checkup_date`) VALUES
(1, 2, '1', '2022-08-08 11:35:19', 'jagadish', 3, '1', NULL, '2022-08-08'),
(2, 3, 'null', '2022-08-08 12:07:10', 'jagadish', 3, 'null', NULL, '2022-08-08');

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

--
-- Dumping data for table `checkup_non_routine`
--

INSERT INTO `checkup_non_routine` (`id`, `parent_id`, `check_up_days`, `first_alert`, `second_alert`, `third_alert`, `created_on`) VALUES
(1, 3, 0, 0, 0, 0, '2022-08-08 11:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu`) VALUES
(1, 'Dashboard'),
(2, 'Vaccination Registration'),
(3, 'Routine checkup'),
(4, 'Routine Check-up Registration'),
(5, 'Infant Vaccination'),
(6, 'Routine Check-up'),
(7, 'Users'),
(8, 'SMS'),
(9, 'SMTP');

-- --------------------------------------------------------

--
-- Table structure for table `registered_for`
--

CREATE TABLE `registered_for` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `checkup_id` int(11) NOT NULL,
  `checkup` varchar(200) DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registered_for`
--

INSERT INTO `registered_for` (`id`, `registration_id`, `checkup_id`, `checkup`, `created_on`) VALUES
(2, 2, 3, NULL, '2022-08-08 11:35:08'),
(3, 3, 3, NULL, '2022-08-08 12:07:00');

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
  `notification_sent_on` datetime DEFAULT NULL,
  `sms_status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `dob`, `mobile_number`, `email_id`, `address`, `pin_code`, `remarks`, `created_on`, `created_by`, `registration_type`, `updated_on`, `status`, `notification_status`, `notification_sent_on`, `sms_status`) VALUES
(2, 'Jagadish Kumar TR', '0000-00-00', '9902128649', 'jagu123.indian@gmail.com', 'Raghavendra Nagar,Kuvempu Road', 572102, 'null', '2022-08-08 11:35:08', 'jagadish', 'checkup', NULL, 'active', '0', NULL, 'disabled'),
(3, 'Jagadish Kumar TR', '0000-00-00', '9902128649', 'jagu123.indian@gmail.com', 'Raghavendra Nagar,Kuvempu Road', 572102, 'null', '2022-08-08 12:07:00', 'jagadish', 'checkup', NULL, 'active', '0', NULL, 'disabled');

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
  `updated_on` datetime DEFAULT NULL,
  `checkup_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `text`, `url`, `created_by`, `created_on`, `updated_on`, `checkup_text`) VALUES
(1, 'Dear Parent, your child\'s {#var#} vaccination is due by {#var#}. For appointment please call {#var#}. AV Multispeciality Hospital', 'http://login.redsms.in/api/smsapi?key=b27765340d7e5c797d5f754ce22f1254&route=2&sender=AVHSPT&number={#number}&sms={#message}&templateid=DLT_Templateid', '', '2022-08-03 14:51:26', NULL, 'Dear {#var#}, your {#var#} Checkup is due by {#var#}. For appointment please call {#var#}. AV Multispeciality Hospital');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(11) NOT NULL,
  `host` varchar(300) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `host`, `port`, `user_name`, `password`) VALUES
(1, 'smtp.zoho.com', 587, 'admin', '12345');

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
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `accessibility` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`accessibility`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `pwd`, `mobile_number`, `address`, `role`, `created_on`, `updated_on`, `status`, `accessibility`) VALUES
(1, 'Admin', 'admin', '12345', '0', '11', 'admin', '2019-09-09 20:19:29', NULL, 'active', NULL),
(8, 'Jagadish Kumar TR', 'jagadish', '12345', '99021286491', 'Raghavendra Nagar,Kuvempu Road\r\nNear Settihalli Gate TUMKUR-572149', 'admin', '2022-08-03 02:57:09', '2022-08-03 02:57:25', 'active', '[{\"menu\": \"Dashboard\"}, {\"menu\": \"Vaccination Registration\"}, {\"menu\": \"Routine checkup\"}, {\"menu\": \"Routine Check-up Registration\"}]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkup`
--
ALTER TABLE `checkup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `checkups_history`
--
ALTER TABLE `checkups_history`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkup_id` (`checkup_id`),
  ADD KEY `registered_for_ibfk_1` (`registration_id`);

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
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkup`
--
ALTER TABLE `checkup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `checkups_history`
--
ALTER TABLE `checkups_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checkup_non_routine`
--
ALTER TABLE `checkup_non_routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registered_for`
--
ALTER TABLE `registered_for`
  ADD CONSTRAINT `registered_for_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registration` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `registered_for_ibfk_2` FOREIGN KEY (`checkup_id`) REFERENCES `checkup` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
