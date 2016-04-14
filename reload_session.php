<?php
	
	session_start();
	
	$_SESSION['GC_SESSION_ID'] = $_POST['session'];
	header("Location: gcmember.php");
?>