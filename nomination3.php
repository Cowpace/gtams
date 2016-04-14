<?php
include_once 'includes/db_connect.php';

if(!isset($_SESSION)) { 
	session_start(); 
}
$page_title = 'John Smith';
include_once ('header.php');
$file = 'nomination3.php';
?>

<html>
	<head>
	     <link rel='stylesheet' href='styles/main.css' />
	</head>
	<div id='page'>
	<br><br>
	<body><center>
			<?php
				$result = $mysqli->query('SELECT * FROM nomination WHERE nomination_id = 3')->fetch_object();
				$result2 = $mysqli->query('SELECT * FROM ListGradCourse WHERE nomination_id = 3');
				$result3 = $mysqli->query('SELECT * FROM ListPublication WHERE nomination_id = 3');
			?>
			<br>
			<table>
			<caption>John Smith's Info</caption>
			<tr><td>Nominee Name</td><td><?php echo $result->nominee_name; ?></td></tr>
			<tr><td>Session ID</td><td><?php echo $result->session_id; ?></td></tr>
			<tr><td>Nominee PID</td><td><?php echo $result->nominee_PID; ?></td></tr>
			<tr><td>Nominee Email</td><td><?php echo $result->nominee_email; ?></td></tr>
			<tr><td>Phone Number</td><td><?php echo $result->phone_number; ?></td></tr>
			<tr><td>GPA</td><td><?php echo $result->GPA; ?></td></tr>
			<tr><td>Is a PHD student</td><td><?php echo $result->is_phd; ?></td></tr>
			<tr><td>Advisor</td><td><?php echo $result->nominee_advisor; ?></td></tr>
			<tr><td>Graduate Semesters</td><td><?php echo $result->graduate_semesters; ?></td></tr>
			<tr><td>SPEAK Test Status</td><td><?php echo $result->SPEAK_test; ?></td></tr>
			<tr><td>GTA semesters</td><td><?php echo $result->GTA_semesters; ?></td></tr>
			<?php if($result->completed){
			?>	<tr><td>Nomination Completed</td></tr>
			<?php } elseif($result->replied) {
			?>	<tr><td>Waiting for nomination confirmation</td></tr>
			<?php } else {
			?>	<tr><td>Nominee messaged</td></tr>
			<?php } ?>
			</table>
			<table>
			<caption>Graduate Courses</caption>
			<th>Course Name</th>
			<th>Course Grade</th>
			<?php
				while($obj = $result2->fetch_object()){ ?>
					<tr><td><?php echo $obj->Course_Name; ?></td>
					<td><?php echo $obj->Course_Grade; ?></td></tr>
				<?php } ?>			
			</table>
			<table>
			<caption>Publications</caption>
			<th>Publication Name</th>
			<th>Publication Citation</th>
			<?php
				while($obj = $result3->fetch_object()){ ?>
					<tr><td><?php echo $obj->Publication_Name; ?></td>
					<td><?php echo $obj->Publication_Citation; ?></td></tr>
			<?php } ?>				
			</table>				
	</center></body>
</html>
