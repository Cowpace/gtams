<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();



$to_binary = array("yes" => 1, "no" => 0);

#post to table
$nominatorName = filter_var($_POST['nominatorName'], FILTER_SANITIZE_STRING);
$nominatorMail = filter_var($_POST['nominatorMail'], FILTER_SANITIZE_STRING);
$nomineeName = filter_var($_POST['nomineeName'], FILTER_SANITIZE_STRING);
$nomineePID = filter_var($_POST['nomineePID'], FILTER_SANITIZE_STRING);
$nomineeEmail = filter_var($_POST['nomineeEmail'], FILTER_SANITIZE_STRING);
$phdCheck = filter_var($to_binary[$_POST['phdCheck']]);
$phdNew = filter_var($to_binary[$_POST['phdNew']]);
$nomineeRank = filter_var($_POST['nomineeRank']);
$sent_time = date("Y-m-d H:i:s");

$temp = $mysqli->query("SELECT session_id FROM sessions WHERE is_active = 1")->fetch_object()->session_id;

#Email function
$subject = "You've been nominated!";
$headers = "From: ".$nominatorName;
$body_message = "Follow this link to access: localhost/gtams/nominee.php\n";

#query
$stmt = $mysqli->prepare("INSERT INTO nomination (session_id, nominator_name, nominator_email, nominee_name, rank, nominee_PID, nominee_email, is_phd, is_newly_admitted, sent) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('isssissiis', 
	$temp, $nominatorName, $nominatorMail, $nomineeName, $nomineeRank, $nomineePID, $nomineeEmail, $phdCheck, $phdNew, $sent_time);  
$stmt->execute();  

if ($mysqli->errno){
	alert("Query failed with error code = " . $mysqli->errno);
}

$mail_status = mail($nomineeEmail, $subject, $body_message, $headers);
if($mail_status){
	alert("Message Sent to " . $nomineeEmail);
	//header('Location: ../gtams/nominator.php');
	//echo '<script language="javascript" type="text/javascript">
	//	alert("Sent message");
	//	//window.location = "nominator.php";
	//</script>';
}
else {
    alert("Message failed. Please, send an email to gordon@template-help.com");
}
?>

