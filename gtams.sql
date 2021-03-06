#Creates and populates MySQL database
#Delete database if it exists
DROP DATABASE IF EXISTS gtams;
#Create gtams database
CREATE DATABASE gtams; 
#Switch to the created DB
USE gtams;

#Create TABLES
###########################

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
	FOREIGN KEY (`user_id`) REFERENCES users (`user_ID`)
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
	foreign key (`session_id`) references `sessions`(`session_id`),
	foreign key (`nominator_id`) references `users`(`user_id`)
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
CREATE TABLE `score` (
  `user_ID` INT(11) NOT NULL,
  `nomination_id` INT(11) NOT NULL,
  `Score` INT(3) DEFAULT 0,
  `ScoredOn` DATETIME,
  `Comments` VARCHAR(512),
  PRIMARY KEY (`user_ID`, `nomination_id`),
  FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_id`),
  FOREIGN KEY (`nomination_id`) REFERENCES `nomination` (`nomination_id`)
);

#Fill Tables
################################################
#Generate default logins for three accepted users
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('ADMIN','admin','password','admin@god.me',NOW(), "MODS = GODS");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('GCCHAIR','gcchair','password','gcchair@chair.me',NOW(), "The Chair");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('GCMEMBER','gcmember','password','gcmember@pleb.me',NOW(), "A Member");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('GCMEMBER','gcmember2','password','gcmember2@pleb.me',NOW(), "An Member");
INSERT INTO `users` (`user_Role`,`username`,`password`,`user_Email`,`reg_date`, `realname`) VALUES ('NOMINATOR','nominator','password','nominator@nom.me',NOW(), "Arup Guha");

#Generate session
INSERT INTO `sessions` (`app_deadline`, `nom_init_deadline`, `nom_respond_deadline`, `nom_complete_deadline`, `is_active`) VALUES ('2099.1.1', '2099.1.1', '2099.1.1', '2099.1.1', 1);
INSERT INTO `sessions` (`app_deadline`, `nom_init_deadline`, `nom_respond_deadline`, `nom_complete_deadline`, `is_active`) VALUES ('2099.1.2', '2099.1.2', '2099.1.2', '2099.1.2', 0);

#Generate session_users
INSERT INTO `session_users` (`session_id`,`user_id`) VALUES (1,3);
INSERT INTO `session_users` (`session_id`,`user_id`) VALUES (1,4);
INSERT INTO `session_users` (`session_id`,`user_id`) VALUES (2,3);

#Generate nomination
INSERT INTO nomination (`session_id`, `nominator_id`, `nominee_name`, `rank`, `nominee_PID`, `nominee_email`, `nominee_advisor`,`is_phd`, `is_newly_admitted`, `phone_number`,`SPEAK_test`,`GTA_semesters`,`GPA`,`graduate_semesters`,`sent`) VALUES (1, 5,'Fedora',5,'F2345678','fed.dora@reddit.com','Kien Hua',1,0,'9543211234',2,3,3.9,5,NOW());
INSERT INTO nomination (`session_id`, `nominator_id`,`nominee_name`, `rank`, `nominee_PID`, `nominee_email`,`nominee_advisor`, `is_phd`, `is_newly_admitted`,`phone_number`, `SPEAK_test`,`GTA_semesters`,`GPA`,`graduate_semesters`,`sent`) VALUES (2, 5,'Fedorad',3,'F2545678','fed.dorad@reddit.com','Kien Hua',0,1,'9543211235',3,1,3.3,3,NOW());

#Generate three default courses
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (1, 'Database Systems','A');
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (1, 'Programming 101','B+');
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (1, 'Memes Study','D');
INSERT INTO `ListGradCourse` (`nomination_id`, `Course_Name`, `Course_Grade`) VALUES (2, 'Database Systems','A');

#Generate advisors
INSERT INTO `ListAdvisor` (`nomination_id`,`advisor_name`,`startdate`,`enddate`) VALUES (1,'Carl Hassle', '2015.1.2','2015.2.3');
INSERT INTO `ListAdvisor` (`nomination_id`,`advisor_name`,`startdate`,`enddate`) VALUES (2,'Arup Guha', '2015.1.2','2015.2.3');

#Generate three default publications
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (1, 'PHP and MySQL','Wikipedia');
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (1, 'The Effect of Dynamic Code','UCF Code Handbook');
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (1, 'Memes Case Study','Reddit.com');
INSERT INTO `ListPublication` (`nomination_id`, `Publication_Name`,`Publication_Citation`) VALUES (2, 'PHP and MySQL','Wikipedia');

#Generate score
INSERT INTO `score` (`user_ID`,`nomination_id`,`Score`,`ScoredOn`,`Comments`) VALUES (3,1,100,NOW(),'A real swell fella.');
INSERT INTO `score` (`user_ID`,`nomination_id`,`Score`,`ScoredOn`,`Comments`) VALUES (4,1,50,NOW(),'Needs work');
INSERT INTO `score` (`user_ID`,`nomination_id`,`Score`,`ScoredOn`,`Comments`) VALUES (3,2,66,NOW(),'Not exceptional');

#Test Tables
################################################