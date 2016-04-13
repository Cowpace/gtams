<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(!isset($_SESSION)) { 
	session_start(); 
}

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


$obj = $mysqli->query("SELECT session_id, nom_init_deadline FROM sessions WHERE is_active = 1")->fetch_object();
$temp = $obj->session_id;
$deadline = $obj->nom_init_deadline;
if (strcmp(date("Y.m.d"), $deadline) > 0){
	alert("Deadline has passed to initiate a nomination");
	exit;
}

$nominator_id = $_SESSION['user_ID'];
if (!($nominator_id > 0)){
	alert("failed to grab user_ID (".$nominator_id.") of user logged in");
	exit();
}

//if the admin did not specify a name, update the database
$stmt = $mysqli->prepare("
		UPDATE users
		SET realname = ?
		WHERE user_ID = ? and realname IS NULL"
	);
$stmt->bind_param('si', $nominatorName, $nominator_id);
$stmt->execute();

#Email function
//Recipient(s)
$to  = $nomineeEmail; #. ', '; // note the comma
#$nomineeEmail .= 'wez@example.com';

//Subject
$subject = 'You have been nominated!';

// message
$message = '
<html>
<head>
  <title>GTAMS Nomination</title>
</head>
<body>
  <p>
	Follow this <a href="localhost/gtams/nominee.php">link</a>
  </p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$nomineeName.' <'.$nomineeEmail.'>' . "\r\n";
$headers .= 'From: '.$nominatorName.' <gtams@cop4710.com>' . "\r\n";
$headers .= 'Cc:' . "\r\n";
$headers .= 'Bcc:' . "\r\n";
$mail_status = mail($to, $subject, $message, $headers);

#query
$stmt = $mysqli->prepare("INSERT INTO nomination (session_id, nominator_id, nominee_name, rank, nominee_PID, nominee_email, is_phd, is_newly_admitted, sent) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('iisissiis', 
	$temp, $nominator_id, $nomineeName, $nomineeRank, $nomineePID, $nomineeEmail, $phdCheck, $phdNew, $sent_time);  
$stmt->execute();  

if ($mysqli->errno){
	alert("Query failed with error code = " . $mysqli->errno);
}

$result2 = $mysqli->query("SELECT user_ID FROM users WHERE user_Role = 'GCMEMBER'");
$y = $mysqli->query("SELECT nomination_id FROM nomination ORDER BY nomination_id DESC LIMIT 1")->fetch_object()->nomination_id;

while($obj = $result2->fetch_object()){
	$stmt2 = $mysqli->prepare("INSERT INTO `score` (`user_id`, `nomination_id`) VALUES (?,?)");
	$stmt2->bind_param('ii', $obj->user_ID, $y);
	$stmt2->execute();
	if ($mysqli->errno){
		alert("Query failed with error code = " . $mysqli->errno." ".$obj->user_ID." ".$y);
	}
}

if($mail_status){
	alert("Message Sent to " . $nomineeEmail);

}
else {
    alert("Message failed. Please, send an email to gordon@template-help.com");
}
?>