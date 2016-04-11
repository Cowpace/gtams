<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
if(!isset($_SESSION)) { 
	session_start(); 
}
	$user_id = $_SESSION['user_ID'];
	$nomination_id = $_POST['nomination_id'];
	$score = $_POST['score'];
	$comment = $_POST['comment'];
	$ScoredOn = date("Y-m-d H:i:s");
	
	$stmt = $mysqli->prepare("UPDATE score SET Score=?, ScoredOn=?, Comments=? WHERE user_ID=? && nomination_id=?");
	$stmt->bind_param('issii', $score, $ScoredOn, $comment, $user_id, $nomination_id);  
	$stmt->execute();  
	
	if($mysqli->errno){
		$message = 'Score not submitted';
	}
	else{
		$message = 'Score submitted';
	}
alert($message);
?>