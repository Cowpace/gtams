<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
session_start();

$nominatorName = filter_var($_POST['nominatorName'], FILTER_SANITIZE_STRING);
$PID = filter_var($_POST['nomineePID'], FILTER_SANITIZE_STRING);

$stmt = $mysqli->prepare("
	SELECT n.nomination_id 
	FROM nomination n, users u
	WHERE u.realname = ? and n.nominee_PID = ? and u.user_ID = n.nominator_id"
);
$stmt->bind_param('ss', $nominatorName, $PID);
$stmt->execute();
$stmt->bind_result($nom_id);
if (!$stmt->fetch()){
	alert("Failed to grab nomination_id");
	exit();
}
else if ($stmt->num_rows > 1){
	alert("More than one match was found for nomination_id");
}
$stmt->close();
$map = array("yes" => 1, "no" => 2, "grad" => 3);

$phdAdvisor = filter_var($_POST['phdAdvisor'], FILTER_SANITIZE_STRING);
$gradStudent = filter_var($_POST['gradStudent']);
$nominatorName = filter_var($_POST['nominatorName'], FILTER_SANITIZE_STRING);
$GTA = filter_var($_POST['GTA']);
$gpa = filter_var($_POST['gpa']);
$tel = filter_var($_POST['nomineeTel'], FILTER_SANITIZE_STRING);
$speak = filter_var($map[$_POST['speak']]);

$stmt = $mysqli->prepare("
	UPDATE nomination 
	SET nominee_advisor = ?, graduate_semesters = ?, phone_number = ?, SPEAK_test = ?, GTA_semesters = ?, GPA = ?, replied = NOW() 
	WHERE nomination_id = ?"
);
$stmt->bind_param('sisiidi', $phdAdvisor, $gradStudent, $tel, $speak, $GTA, $gpa, $nom_id);
$stmt->execute();

if ($mysqli->errno){
	alert("Query failed with error code = " . $mysqli->errno);
} else {
	alert("Reply Successful");
}
?>