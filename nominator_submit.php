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

$temp = $mysqli->query("SELECT session_id FROM sessions WHERE is_active = 1")->fetch_object()->session_id;

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

#query
$stmt = $mysqli->prepare("INSERT INTO nomination (session_id, nominator_name, nominator_email, nominee_name, rank, nominee_PID, nominee_email, is_phd, is_newly_admitted, sent) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('isssissiis', 
	$temp, $nominatorName, $nominatorMail, $nomineeName, $nomineeRank, $nomineePID, $nomineeEmail, $phdCheck, $phdNew, $sent_time);  
$stmt->execute();  

if ($mysqli->errno){
	alert("Query failed with error code = " . $mysqli->errno);
}

$mail_status = mail($to, $subject, $message, $headers);
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

