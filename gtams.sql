#Creates and populates MySQL database
#Delete database if it exists
DROP DATABASE IF EXISTS gtams;
#Create gtams database
CREATE DATABASE gtams; 
#Switch to the created DB
USE gtams;

#Create TABLES
###########################
#create table for the session database
CREATE TABLE `sessions` (
	`session_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`app_deadline` VARCHAR(20) NOT NULL,
	`nom_init_deadline` VARCHAR(20) NOT NULL,
	`nom_respond_deadline` VARCHAR(20) NOT NULL,
	`nom_complete_deadline` VARCHAR(20) NOT NULL,
	`is_active` BIT NOT NULL
);

CREATE TABLE `session_users` (
	`session_user_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`session_id` INT(11) ,
	`user_id` INT(11),
	FOREIGN KEY (`session_id`) REFERENCES sessions (`session_id`),
	FOREIGN KEY (`user_id`) REFERENCES sessions (`session_id`)
);


#Create table for users
CREATE TABLE `users` (
  `user_ID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_Role` VARCHAR(20) NOT NULL COMMENT 'user Role can be ADMIN, GCMEMBER, GCCHAIR, NOMINATOR, NOMINEE',
  `username` VARCHAR(20) NOT NULL COMMENT 'user Login',
  `password` VARCHAR(10) NOT NULL COMMENT 'user Password',
  `user_Email` VARCHAR(100) NOT NULL COMMENT 'Email',
  `reg_date` TIMESTAMP,
  `realname` VARCHAR(30),
  UNIQUE KEY username (`username`)
);

#Create table for the nomination process
CREATE TABLE `nomination` (
	`nomination_id` INT (11) NOT NULL AUTO_INCREMENT,
	`session_id` INT(11) NOT NULL COMMENT 'the id for the session the Admin set up',
	`nominator_id` INT(11) NOT NULL COMMENT 'the user_id for the nominator',
	`nominee_name` VARCHAR(40),
	`rank` int(11),
	`nominee_PID` VARCHAR(40),
	`nominee_email` VARCHAR(40),
	`is_phd` INT(11),
	`is_newly_admitted` INT (11) COMMENT "",
	`nominee_advisor` VARCHAR(40),
	`graduate_semesters` INT (11),
	`phone_number` VARCHAR(20),
	`SPEAK_test` INT(11) COMMENT '1, 2, 3 = yes, no, graduated from US school',
	`GTA_semesters` INT(11),
	`GPA` float(10),
	`sent` TIMESTAMP COMMENT 'when the nomination was sent to the user',
	`replied` TIMESTAMP COMMENT 'when the nomination was replied to by the nominee',
	`completed` TIMESTAMP COMMENT 'when the nominee form was confirmed by the nominator',
	primary key (`nomination_id`),
	foreign key (`session_id`) references `sessions`(`session_id`)
);

#Create table for grad courses
CREATE TABLE `ListGradCourse` (
  `ListGradCourse_ID` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomination_id` INT(11) NOT NULL,
  `Course_Name` VARCHAR(45) NOT NULL,
  `Course_Grade` VARCHAR(2) NOT NULL,
  foreign key (`nomination_id`) references `nomination`(`nomination_id`)
);

#Create table for publications
CREATE TABLE `ListPublication` (
  `ListPublication_ID` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomination_id` INT(11) NOT NULL,
  `Publication_Name` VARCHAR(48) NOT NULL,
  `Publication_Citation` VARCHAR(512) NOT NULL,
  foreign key (`nomination_id`) references `nomination`(`nomination_id`)
);

#Create table for advisors
CREATE TABLE `ListAdvisor` (
  `ListAdvisor_ID` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomination_id` INT(11) NOT NULL,
  `advisor_name` VARCHAR(48) NOT NULL,
  `startdate` VARCHAR(512) NOT NULL,
  `enddate` VARCHAR(512) NOT NULL,
  foreign key (`nomination_id`) references `nomination`(`nomination_id`)
);


#Fill Tables
################################################
INSERT INTO `sessions` (`app_deadline`, `nom_init_deadline`, `nom_respond_deadline`, `nom_complete_deadline`, `is_active`) VALUES ('1/1/11', '1/1/12', '1/1/13', '1/1/14', 1);

#Your original insert was wrong, Auto-Increment starts at 1, not 0.
INSERT INTO nomination (`session_id`, `nominator_id`, `nominee_name`, `rank`, `nominee_PID`, `nominee_email`, `is_phd`, `is_newly_admitted`, `sent`) VALUES (1, 4,'Fedora',99,'F2345678','fed.dora@reddit.com',1,0,NOW());

#Generate default logins for three accepted users
INSERT INTO `users` (`user_Role`, `username`, `password`, `user_Email`, `reg_date`, `realname`) VALUES ('ADMIN','admin','password','admin@god.me',NOW(), "MODS = GODS");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('GCCHAIR','gcchair','password','gcchair@chair.me',NOW(), "The Chair");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('GCMEMBER','gcmember','password','gcmember@pleb.me',NOW(), "A Member");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('NOMINATOR','nominator','password','nominator@nom.me',NOW(), "Arup Guha");

#Generate three default courses
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (1, 'Database Systems','A');
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (1, 'Programming 101','B+');
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (1, 'Memes Study','D');

#Generate three default publications
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (1, 'PHP and MySQL','Wikipedia');
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (1, 'The Effect of Dynamic Code','UCF Code Handbook');
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (1, 'Memes Case Study','Reddit.com');

#
#INSERT INTO `ApplicationForm` () VALUES ();

#Generate Application Scores
#INSERT INTO `ApplicationScore` (`GCMember_ID`,`Score`,`ScoredOn`) VALUES (1,30,NOW());

#Test Tables
################################################
