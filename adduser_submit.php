<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
if(!isset($_SESSION)) { 
	session_start(); 
}
#Check that both the username, password and form token have been sent
if(!isset( $_POST['username'], $_POST['password'], $_POST['form_token']))
{
    $message = 'Please enter a valid username and password';
}
#check the form token is valid
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $message = 'Invalid form submission';
}
else
{
    #If we are here the data is valid and we can insert it into database
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
	$role = filter_var($_POST['selection'], FILTER_SANITIZE_STRING);
	$name = filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
	if ($name == "")
		$name = NULL;

	$reg_date = date("Y-m-d H:i:s");
	$stmt = $mysqli->prepare("INSERT INTO users (username, password, user_Email, user_Role, reg_date, realname) VALUES (?,?,?,?,?,?)");
	$stmt->bind_param('ssssss', $username, $password, $email, $role, $reg_date, $name);  
	$stmt->execute();   
	
	unset( $_SESSION['form_token'] );
	
	if($mysqli->errno){
		$message = "Username already exists";
	}
	else{
		$message = 'New user added';
	}
    

}
alert($message);
?>