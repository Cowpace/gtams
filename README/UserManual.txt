# GTAMS TEAM 18
Current as of 04/13/2016

We are currently using Windows Apache MySQL PHP Server (WAMP) client to run both our MySQL server and our Apache interface. Download at:

	http://www.wampserver.com/en/

In order to use the mailing functionality through our interface you need to setup your download the fake mail extension (WAMP only) and setup your sendmail.ini and php.ini files in your WAMP directory. First, download the extension zip from:
	http://www.glob.com.au/sendmail/sendmail.zip
And extract to a folder called "sendmail" in your 'wamp\bin' directory.

Changes required in sendmail.ini:		(We are using gmail)
	smtp_server=smtp.gmail.com
	smtp_port=587
	error_logfile=error.log
	debug_logfile=debug.log
	auth_username=your-gmail-id@gmail.com 	(tverb21@gmail.com)
	auth_password=your-gmail-password		(1234fd5r)
	force_sender=your-gmail-id@gmail.com	(tverb21@gmail.com)

(note the php.ini file is in \bin\apache\apachexxx\bin)
Changes required in php.ini: 
	SMTP=smtp.gmail.com
	smtp_port=587
	sendmail_from = your-gmail-id@gmail.com	(tverb21@gmail.com)
	sendmail_path = "\"C:\wamp\bin\sendmail\sendmail.exe\" -t" (This is the default path for wamp, may be "wamp64 or wamp32" though)


To run the WAMP server run the Wampserver.exe and click on the icon in your toolbar to start services.

Assuming you have not edited your MySQL, the default url to access it will be "localhost" with a default superuser of "root" with no password.

To upload your database to the MySQL server through the apache interface, from the homescreen of "localhost" go to phpmyadmin page and click on import and navigate to the .sql file that contains the instructions for creating your database and click go.

To set up the project files, put the folder that contains your .php files into the "www" directory inside the main WAMP installation folder. The folder name should be able to be seen on the homescreen of the WAMP server (localhost), to navigate to your folder use the url "localhost/xxx" where xxx is the name of your .php folder.
**The .php folder for this project is "gtams"


**Please note that if you are using OSX or a Linux machine you can use LAMP instead of WAMP, the instructions are similar and you can download at:
	https://bitnami.com/stack/lamp/installer
**


------------------------------------------------------------------------------------------------------------------------------------
The following instructions are deprecated but can still be used if WAMP fails or if you prefer not to use it.
------------------------------------------------------------------------------------------------------------------------------------

To run the MySQL server we are currently using XAMPP for ease of use.
	https://www.apachefriends.org/download.html

To code our database interactions we are using Notepad++ (or your favorite text editor)
	https://notepad-plus-plus.org/download/v6.9.1.html

After installing XAMPP you can freely run a MySQL server through the GUI interface (as long as the ports are unblocked)

The setup of loading your .sql file to the server is the same as the WAMP instructions and instead of the www folder you would put your .php containing folder in the "htdocs" directory in your XAMPP installation.


--------------------------------------------------------------------------------------------------------------------------------------
File Functionalities
--------------------------------------------------------------------------------------------------------------------------------------

GTAMS main directory:

"adduser.php"
	Front-end component of the admin page, displays Adduser and Session creation html.
	Calls to adduser_submit.php for user creation and session_submit.php for session creation.

"adduser_submit.php"
	Back-end component that processes information in adduser fields and inserts new user into DB

"confirm.php"
	Front-end component that is generated from a certain nomination row in the database for a nominator
	user to confirm

"confirm_submit.php"
	Back-end component that completes a nomination that the nominator user confirmed

"footer.php"
	Footer html for each page
	
"gcmember.php"
	Front-end component that dynamically creates active session table of nominees for GC members to score

"gcmember_submit.php"
	Back-end component that takes in score and comment for a nominee and updates DB and GC member table.

"gtams.sql"
	This file contains the SQL calls that create the GTAMS DB

"header.php"
	This file is called early in every main page to title the page and enable the navbar

"index.php"
	The main "home" page of the project, where you login

"logout.php"
	Deletes the session and moves you back to index.php

"navbar.php"
	Allows for click navigation to home page or to logout

"nominator.php"
	Front-end component that allows a nominator to nominate a nominee and confirm nominees
	
"nominator_submit.php"
	Back-end component to create a new nomination with partial nominee info in DB	
	Emails nominee through sendmail interface
	Creates new entry in score table for each GC member that is part of this session

"nominee.php"
	Front-end component for the nominee to add the nominee's information to the nomination table

"nominee_submit.php"
	Submits nominee's info to the ListGradCourse, ListPublication and Nominations tables in DB
	Allows for nominator to confirm the nominee after submission

"session_submit.php"
	Adds a session to the sessions table based on Admin input and sets the session to be active
	and deactivates the previous session

GTAMS/includes directory

"db_connect.php"
	Sets up the connection to the database and sets the $mysqli variable for later use

"functions.php"
	Variety of functions for use in main pages, inlcudes:
		login - verifies user is in DB
		lookup - looks up information from DB about a user
		error - prints out an error message to directory
		alert - formal alert to create popup message
		debug_alert - informal alert to create popup message
		popper - pops up a new window to display a page
		createPage - creates a page to display nominee info		
		
"process_login.php"
	Sets up login functionality and dictates which page to load to based on user
	
"psl_config.php"
	Basic information for server login (host: "localhost" user: "root" password: "")



