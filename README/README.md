# gtams

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
	auth_password=your-gmail-password	(1234fd5r)
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

To use your .php files, put the folder that contains your .php files into the "www" directory inside the main WAMP installation folder. The folder name should be able to be seen on the homescreen of the WAMP server (localhost), to navigate to your folder use the url "localhost/xxx" where xxx is the name of your .php folder.

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
