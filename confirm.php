<?php 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$page_title = "Confirm Nominee";
include_once ("header.php");

if (!isset($_SESSION)){
	session_start();
}
if (!isset($_POST['nominees'])){
	alert("No Nominee selected");
	exit;
}

$deadline = $mysqli->query("
	SELECT nom_complete_deadline 
	FROM sessions 
	WHERE is_active = 1
")->fetch_object()->nom_complete_deadline;

if (strcmp(date("Y.m.d"), $deadline) > 0){
	alert("Deadline has passed to confirm to a nomination");
	exit;
}
$nom_id = $_POST['nominees'];

$stmt = $mysqli->prepare("
	SELECT 
		u.realname, n.nominee_name, n.rank, n.nominee_PID, 
		n.nominee_email, n.is_phd, n.is_newly_admitted, n.nominee_advisor, 
		n.graduate_semesters, n.phone_number, n.SPEAK_test, n.GTA_semesters, n.GPA
	FROM nomination n, users u
	WHERE n.nomination_id = ? and u.user_ID = n.nominator_id
");
$id = $nom_id;
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result(
	$nominator_name, $nominee_name, $nominee_rank, $pid, $nominee_email, $is_phd, 
	$is_new, $nominee_adv, $grad_semesters, $phone, $speak, $gta_semesters, $gpa
);
$stmt->fetch();

$mapping = array(
	"Nominator name: " => $nominator_name, 
	"Nominee name: " => $nominee_name, 
	"Rank: " => $nominee_rank, 
	"Nominee PID: " => $pid, 
	"Nominee Email: " => $nominee_email, 
	"Is the Nominee a Ph.D Student? " => $is_phd, 
	"Is the Nominee a new student? " => $is_new, 
	"Current Nominee Advisor: " => $nominee_adv, 
	"Number of semesters as a graduate student: " => $grad_semesters, 
	"Nominee Phone Number: " => $phone, 
	"Passed SPEAK test: " => $speak, 
	"Semesters as GTA: " => $gta_semesters, 
	"Nominee GPA: " => $gpa
);

$other_tables = array(
	"courses" => array(),
	"pub" => array(),
	"adv" => array()
);
$stmt->close();
$stmt = $mysqli->prepare("
	SELECT 
		c.Course_Name, c.Course_Grade
	FROM ListGradCourse c, nomination n
	WHERE n.nomination_id = ? and n.nomination_id = c.nomination_id
");
if (!$stmt){
	debug_alert("fuck");
}
$id = $nom_id;
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($name, $grade);


while ($stmt->fetch()){
	$other_tables['courses'][] = $name;
	$other_tables['courses'][] = $grade;
}

$stmt = $mysqli->prepare("
	SELECT 
		c.Publication_Name, c.Publication_Citation
	FROM ListPublication c, nomination n
	WHERE n.nomination_id = ? and n.nomination_id = c.nomination_id
");
$id = $nom_id;
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($name, $cit);

while ($stmt->fetch()){
	$other_tables['pub'][] = $name;
	$other_tables['pub'][] = $cit;
}

$stmt = $mysqli->prepare("
	SELECT 
		c.advisor_name, c.startdate, c.enddate
	FROM ListAdvisor c, nomination n
	WHERE n.nomination_id = ? and n.nomination_id = c.nomination_id
");
$id = $nom_id;
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($name, $start, $end);

while ($stmt->fetch()){
	$other_tables['adv'][] = $name;
	$other_tables['adv'][] = $start;
	$other_tables['adv'][] = $end;
}

$_SESSION['TEMP_NOM_ID'] = $nom_id;
?>

<html>
<head><link rel="stylesheet" href="styles/main.css" /></head>
<br><br>
<section class="confirm cf">
<form name="nominee" action="confirm_submit.php" method="post" accept-charset="utf-8">
    <body><center>
	<table >
		<?php 
			foreach ($mapping as $desc => $v){
				echo "
					<tr><td><label>".$desc."</label></td>
				";
				echo "
					<td><label>".$v."</label></td></tr>
				";
			}
			$i=0;
			echo "<tr><td colspan = '2'><label>Courses Taken</label></td></tr>";
			echo "<tr><td><label>Name</label></td><td><label>Grade</label></td></tr>";
			foreach ($other_tables['courses'] as $v){
				if ($i % 2 == 0){
					echo "
						<tr><td><label>".$v."</label></td>
					";
				} else {
					echo "
						<td><label>".$v."</label></td></tr>
					";
				}
				$i++;
			}
			
			$i=0;
			echo "<tr><td colspan = '2'><label>Publications</label></td></tr>";
			echo "<tr><td><label>Name</label></td><td><label>Citation</label></td></tr>";
			foreach ($other_tables['pub'] as $v){
				if ($i % 2 == 0){
					echo "
						<tr><td><label>".$v."</label></td>
					";
				} else {
					echo "
						<td><label>".$v."</label></td></tr>
					";
				}
				$i++;
			}
			
			$i=0;
			echo "<tr><td colspan = '3'><label>Previous Advisors</label></td></tr>";
			echo "<tr><td><label>Name</label></td><td><label>Start Date</label></td><td><label>End Date</label></td></tr>";
			foreach ($other_tables['adv'] as $v){
				if ($i % 3 == 0){
					echo "
						<tr><td><label>".$v."</label></td>
					";
				} else if ($i % 3 == 1){
					echo "
						<td><label>".$v."</label></td>
					";
				} else {
					echo "
						<td><label>".$v."</label></td></tr>
					";
				}
				$i++;
			}
		?>
      

      <tr><td><input type="submit" value="CONFIRM"></td></tr>
	  </table></center>
    </body>
</form>
</section>
</html>