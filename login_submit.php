<?php
include_once 'db_connect.php';
session_start(); 

$message = '';
#check if the users is already logged in
if(isset( $_SESSION['user_ID'] )){ ?>
	<script language="javascript" type="text/javascript">
		alert("User is already logged in");
		window.location = "index.php";
	</script>
<?php }
else
{
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $mysql_hostname = 'localhost';
    $mysql_username = 'user';
    $mysql_password = 'sXR8sCfV37zScW4L';
    $mysql_dbname = 'gtams';
    try
    {
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = a message saying we have connected ***/
        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        /*** prepare the select statement ***/
        $stmt = $dbh->prepare("SELECT user_ID, username, password, user_Role FROM users 
                    WHERE username = :username AND password = :password");
        /*** bind the parameters ***/
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);
        /*** execute the prepared statement ***/
        $stmt->execute();
		
        /*** check for a result ***/
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$user_ID = $row["user_ID"];
		$user_Role = $row["user_Role"];
        /*** if we have no result then fail boat ***/
        if($user_ID == false)
        {?>		
			<script language="javascript" type="text/javascript">
				alert("Incorrect Username or Password");
				window.location = "index.php";
			</script>
		<?php }        
        /*** if we do have a result, all is well ***/
        else
        {
                /*** set the session user_ID and privilege number variable ***/
                $_SESSION["user_ID"] = $user_ID;
				$_SESSION["user_Role"] = $user_Role;
				
                /*** we are logged in, so go to home ***/
				if($_SESSION["user_Role"] == "ADMIN")
				{
					header('Location: adduser.php');
				}
				elseif($_SESSION["user_Role"] == "GCMEMBER")
				{
					header('Location: gcmember.php');
				}
				elseif($_SESSION["user_Role"] == "NOMINATOR")
				{
					header('Location: nominator.php');
				}
				else 
				{
					header('Location: index.php');
				}
        }
    }
    catch(Exception $e)
    {
		file_put_contents("error.txt", $e);
        /*** if we are here, something has gone wrong with the database ***/
        $message = 'We are unable to process your request. Please try again later';
    }
}
echo $message;
?>