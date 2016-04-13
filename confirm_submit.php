<?php 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if (!isset($_SESSION)){
	session_start();
}

$stmt = $mysqli->prepare("
	UPDATE nomination
	SET completed = NOW()
	WHERE nomination_id = ?
");
if (!isset($_SESSION['TEMP_NOM_ID'])){
	debug_alert("sheeeit");
}
$id = $_SESSION['TEMP_NOM_ID'];
$stmt->bind_param("i", $id);
$stmt->execute();

if (isset($_SESSION['TEMP_NOM_ID'])){
	unset($_SESSION['TEMP_NOM_ID']);
}
alert("Nomination Completed!");
?>