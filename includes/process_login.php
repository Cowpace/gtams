<?php
include_once 'db_connect.php';
include_once 'functions.php';
session_start(); 
if (isset($_POST['username'], $_POST['password'])) {
	$username = $_POST['username'];
    $password = $_POST['password']; 
    if (login($username, $password, $mysqli) == true) {
        // Login success		
		$role = lookup($username, "role",$mysqli);
		$_SESSION["user_ID"] = lookup($username, "id",$mysqli);
		$_SESSION["user_Role"] = $role;
		if($role == "ADMIN"){
			header("Location: ../adduser.php");
			exit;
		}
		elseif($role == "GCMEMBER" || $role == "GCCHAIR"){
			header('Location: ../gcmember.php');
			exit;
		}
		elseif($role == "NOMINATOR"){
			header('Location: ../nominator.php');
			exit;
		}
		else{
			header('Location: ../index.php');	
			exit;	
		}			
				
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}