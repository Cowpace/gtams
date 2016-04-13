<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
session_start();

$obj = $mysqli->query("SELECT session_id, nom_respond_deadline FROM sessions WHERE is_active = 1")->fetch_object();
$session_id = $obj->session_id;
$deadline = $obj->nom_respond_deadline;

if (strcmp(date("Y.m.d"), $deadline) > 0){
	alert("Deadline has passed to respond to a nomination");
	exit;
}

$nominatorName = filter_var($_POST['nominatorName'], FILTER_SANITIZE_STRING);
$PID = filter_var($_POST['nomineePID'], FILTER_SANITIZE_STRING);

$stmt = $mysqli->prepare("
	SELECT n.nomination_id, n.replied
	FROM nomination n, users u
	WHERE u.realname = ? and n.nominee_PID = ? and u.user_ID = n.nominator_id and n.session_id = ?"
);
$stmt->bind_param('ssi', $nominatorName, $PID, $session_id);
$stmt->execute();
$stmt->bind_result($nom_id, $reply_date);
$stmt->fetch();
if ($nom_id == null){
	alert("Nominator not found (".$nom_id.")");
	exit;
}
else if ($stmt->num_rows > 1){
	alert("More than one match was found for nomination_id");
	exit;
} else if ($reply_date != null){
	alert("You have already replied to this nomination");
	exit;
}
$stmt->close();
//Get POST data
$map = array("yes" => 1, "no" => 2, "grad" => 3);

$phdAdvisor = filter_var($_POST['phdAdvisor'], FILTER_SANITIZE_STRING);
$gradStudent = filter_var($_POST['gradStudent']);
$nominatorName = filter_var($_POST['nominatorName'], FILTER_SANITIZE_STRING);
$GTA = filter_var($_POST['GTA']);
$gpa = filter_var($_POST['gpa']);
$tel = filter_var($_POST['nomineeTel'], FILTER_SANITIZE_STRING);
$speak = filter_var($map[$_POST['speak']]);

$adv_name = array();
$adv_start = array();
$adv_end = array();
$course_name = array();
$course_grade = array();
$pub_titles = array();
$pub_citations = array();

if (isset($_POST['advisor_Name'])){
	$adv_name = $_POST['advisor_Name'];
	$adv_start = $_POST['advisor_Start'];
	$adv_end = $_POST['advisor_End'];
}

if (isset($_POST['course_Name'])){
	$course_name = $_POST['course_Name'];
	$course_grade = $_POST['course_Grade'];
}

if (isset($_POST['pub_Title'])){
	$pub_titles = $_POST['pub_Title'];
	$pub_citations = $_POST['pub_Citation'];
}

//update nomination form
$stmt = $mysqli->prepare("
	UPDATE nomination 
	SET nominee_advisor = ?, graduate_semesters = ?, phone_number = ?, SPEAK_test = ?, GTA_semesters = ?, GPA = ?, replied = NOW() 
	WHERE nomination_id = ?"
);
$stmt->bind_param('sisiidi', $phdAdvisor, $gradStudent, $tel, $speak, $GTA, $gpa, $nom_id);
$stmt->execute();

if (count($adv_name) != count($adv_start) || count($adv_start) != count($adv_end) || count($adv_name) != count($adv_end)){
	throw new Exception("ERROR, advisor arrays differ in size");
}
for($i=0; $i < count($adv_name); $i++){
	$stmt = $mysqli->prepare("
		INSERT INTO ListAdvisor 
		(nomination_id, advisor_name, startdate, enddate)
		VALUES (?,?,?,?)"
	);
	$stmt->bind_param('isss', $nom_id, $adv_name[$i], $adv_start[$i], $adv_end[$i]);
	$stmt->execute();
}

if (count($course_name) != count($course_grade)){
	throw new Exception("ERROR, course arrays differ in size");
}
for($i=0; $i < count($course_name); $i++){
	$stmt = $mysqli->prepare("
		INSERT INTO ListGradCourse 
		(nomination_id, Course_Name, Course_Grade)
		VALUES (?,?,?)"
	);
	$stmt->bind_param('iss', $nom_id, $course_name[$i], $course_grade[$i]);
	$stmt->execute();
}

if (count($pub_titles) != count($pub_citations)){
	throw new Exception("ERROR, publication arrays differ in size");
}
for($i=0; $i < count($pub_titles); $i++){
	$stmt = $mysqli->prepare("
		INSERT INTO ListPublication 
		(nomination_id, Publication_Name, Publication_Citation)
		VALUES (?,?,?)"
	);
	$stmt->bind_param('iss', $nom_id, $pub_titles[$i], $pub_citations[$i]);
	$stmt->execute();
}

if ($mysqli->errno){
	alert("Query failed with error code = " . $mysqli->errno);
} else {
	$stmt = $mysqli->prepare("
		SELECT u.user_Email
		FROM nomination n, users u
		WHERE n.nomination_id = ? and u.user_ID = n.nominator_id"
	);
	$stmt->bind_param('i', $nom_id);
	$stmt->execute();
	$stmt->bind_result($email);
	$stmt->fetch();
	
	$subject = "Confirm Nominee";
	$headers = 'From: GTAMS <gtams@cop4710.com>' . "\r\n";
	$body_message = "Please log into your GTAMS account and confirm the nominee information";
	$mail_status = mail($email, $subject, $body_message, $headers);
	if ($mail_status)
		alert("Reply Successful");
	else
		alert("Insert Success, Email Failed to send");
}
?>