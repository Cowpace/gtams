<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
if(!isset($_SESSION)) { 
	session_start(); 
}
	$user_id = $_SESSION['user_id'];
	$score = $_POST['score'];
	$comment = $_POST['comment'];
	$ScoredOn = date("Y-m-d H:i:s");
	
	$x = 0;
	foreach($score as $s)
	$stmt = $mysqli->prepare("INSERT INTO score (user_ID, nomination_id, Score, ScoredOn, Comments) VALUES (?,?,?,?,?)");
	$stmt->bind_param('sssss', $user_id, $password, $email, $role, $reg_date, $name);  
	$stmt->execute();  
	
	if($mysqli->errno){
		$message = "Scores not submitted";
	}
	else{
		$message = 'Scores submitted';
	}
alert($message);
?>