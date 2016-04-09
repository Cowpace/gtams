<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(!isset($_SESSION)) { 
	session_start(); 
}

$members = $_POST['members'];
$chair_id = $_POST['chair'];
$app_deadline = filter_var($_POST['app_deadline'], FILTER_SANITIZE_STRING);
$initiateDate = filter_var($_POST['initiateDate'], FILTER_SANITIZE_STRING);
$nomineeDate = filter_var($_POST['nomineeDate'], FILTER_SANITIZE_STRING);
$nominateDate = filter_var($_POST['nominateDate'], FILTER_SANITIZE_STRING);
$temp = 1;

$mysqli->query("UPDATE sessions SET is_active = 0 WHERE is_active = 1"); //disable all active sessions

$stmt = $mysqli->prepare("INSERT INTO sessions (app_deadline, nom_init_deadline, nom_respond_deadline, nom_complete_deadline, is_active) VALUES (?, ?, ?, ?, 1)");
$stmt->bind_param("ssss", $app_deadline, $initiateDate, $nomineeDate, $nominateDate);
$stmt->execute();
$stmt->close();

$new_id = $mysqli->query("SELECT MAX(session_id) FROM sessions")->fetch_row()[0];

//insert GCMEMBERS
foreach($members as $k => $v){
	$stmt = $mysqli->prepare("INSERT INTO session_users (session_id, user_id) VALUES (?, ?)");
	$stmt->bind_param("ii", $new_id, $v);
	$stmt->execute();
	$stmt->close();
}
//insert gcchair
$stmt = $mysqli->prepare("INSERT INTO session_users (session_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $new_id, $chair_id);
$stmt->execute();
$stmt->close();

//email users involved
$stmt = $mysqli->prepare("SELECT u.user_Role, u.user_Email, u.username, u.password FROM users u, session_users su WHERE u.user_ID = su.user_id and su.session_id = ? and (u.user_Role = 'GCMEMBER' or u.user_Role = 'GCCHAIR')");
$stmt->bind_param("i", $new_id);
$stmt->execute();
$stmt->bind_result($role, $email, $username, $password);

$subject = "Your GTAMS login and password";
$headers = "From: Admin of GTAMS";
while ($stmt->fetch()){
	$body_message = "You have been selected as a ".$role."!\nYour User name is: ".$username."\nYour Password is: ".$password;
	$mail_status = mail($email, $subject, $body_message, $headers);
}

$stmt->close();

alert("Session set up, old session ended!");
?>