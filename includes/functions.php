<?php
include_once 'psl-config.php';

//Secure login
function login($username, $password, $mysqli) {  
    if ($stmt = $mysqli->prepare("SELECT user_id, password 
        FROM users
		WHERE username = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $username);  
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $db_password);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {     
			// Check if the password in the database matches
			// the password the user submitted. We are using
			// the password_verify function to avoid timing attacks.
			if ($password == $db_password) {
				// Password is correct!
				// Login successful.
				return true;
			} else {
				// Password is not correct
				// We record this attempt in the database
				$now = time();
				$mysqli->query("INSERT INTO login_attempts(user_id, time)
								VALUES ('$user_id', '$now')");
				return false;
			}		
        } else {
            // No user exists.					
            return false;
        }
    }
}
//Query for user info
function lookup($username, $parameter, $mysqli){
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare("SELECT user_id, user_Role, user_Email, reg_date FROM users WHERE username = ?");
	$stmt->bind_param('s',$username);
    $stmt->execute();  
	$stmt->bind_result($id, $role, $email, $date);   
	$stmt->fetch();
	
	switch($parameter){
		case "role":
			return $role;
		case "email":
			return $email;
		case "id":
			return $id;
		default:
			return $date;
	}
}
//Print to file
function error($message){
	file_put_contents("error.txt",$message);
}
//Alert
function alert($message) {
	?>	<script>
			alert(" <?php echo $message ?> ");
			history.back();
		</script>
	<?php
}

function debug_alert($message) {
	?>	<script>
			alert(" <?php echo $message ?> ");
		</script>
	<?php
}

function popper($name,$nomid){		
	?>	
			<script>
			function get(){	
			window.open('<?php echo 'nomination'.$nomid.'.php' ?>','<?php echo $name ?>','height=auto,width=auto,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
			}
			</script>
	<?php
}

function createPage($name,$nomid,$mysqli){
	$filename = "nomination".$nomid.".php";
	$content = "<?php
include_once 'includes/db_connect.php';

if(!isset(\$_SESSION)) { 
	session_start(); 
}
\$page_title = '".$name."';
include_once ('header.php');
\$file = '".$filename."';
?>

<html>
	<head>
	     <link rel='stylesheet' href='styles/main.css' />
	</head>
	<div id='page'>
	<br><br>
	<body><center>
			<?php
				\$result = \$mysqli->query('SELECT * FROM nomination WHERE nomination_id = ".$nomid."')->fetch_object();
				\$result2 = \$mysqli->query('SELECT * FROM ListGradCourse WHERE nomination_id = ".$nomid."');
				\$result3 = \$mysqli->query('SELECT * FROM ListPublication WHERE nomination_id = ".$nomid."');
				\$result4 = \$mysqli->query('SELECT * FROM ListAdvisor WHERE nomination_id = ".$nomid."' );
			?>
			<br>
			<table>
			<caption>".$name."'s Info</caption>
			<tr><td>Nominee Name</td><td><?php echo \$result->nominee_name; ?></td></tr>
			<tr><td>Session ID</td><td><?php echo \$result->session_id; ?></td></tr>
			<tr><td>Nominee PID</td><td><?php echo \$result->nominee_PID; ?></td></tr>
			<tr><td>Nominee Email</td><td><?php echo \$result->nominee_email; ?></td></tr>
			<tr><td>Phone Number</td><td><?php echo \$result->phone_number; ?></td></tr>
			<tr><td>GPA</td><td><?php echo \$result->GPA; ?></td></tr>
			<tr><td>Is a PHD student</td><td><?php echo \$result->is_phd; ?></td></tr>
			<tr><td>Current Advisor</td><td><?php echo \$result->nominee_advisor; ?></td></tr>
			<tr><td>Graduate Semesters</td><td><?php echo \$result->graduate_semesters; ?></td></tr>
			<tr><td>SPEAK Test Status</td><td><?php echo \$result->SPEAK_test; ?></td></tr>
			<tr><td>GTA semesters</td><td><?php echo \$result->GTA_semesters; ?></td></tr>
			<?php if(\$result->completed){
			?>	<tr><td>Nomination Completed</td></tr>
			<?php } elseif(\$result->replied) {
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
				while(\$obj = \$result2->fetch_object()){ ?>
					<tr><td><?php echo \$obj->Course_Name; ?></td>
					<td><?php echo \$obj->Course_Grade; ?></td></tr>
				<?php } ?>			
			</table>
			<table>
			<caption>Publications</caption>
			<th>Publication Name</th>
			<th>Publication Citation</th>
			<?php
				while(\$obj = \$result3->fetch_object()){ ?>
					<tr><td><?php echo \$obj->Publication_Name; ?></td>
					<td><?php echo \$obj->Publication_Citation; ?></td></tr>
			<?php } ?>				
			</table>		
			<table>
			<caption>Past Advisors</caption>
			<th>Advisor Name</th>
			<th>Start Date</th>
			<th>End Date</th>
			<?php
				while(\$obj = \$result4->fetch_object()){ ?>
					<tr><td><?php echo \$obj->advisor_name; ?></td>
					<td><?php echo \$obj->startdate; ?></td>
					<td><?php echo \$obj->enddate; ?></td></tr>
			<?php } ?>				
			</table>						
	</center></body>
	<br>
</html>
";
    file_put_contents($filename, $content);
	return $filename;
}

function oldGCTable($sessionID,$mysqli){
		?><script>
	function popup(mylink, windowname)
	{
		if (! window.focus)return true;
		var href;
		if (typeof(mylink) == 'string')
		   href=mylink;
		else
		   href=mylink.href;
		window.open(href, windowname, 'width=auto,height=auto,scrollbars=yes');
		return false;
	}
	
</script><html>
		<table border="1" style="width:100%">
		  <center>
			<tr>
				<th>Nominator name</th>
				<th>Nominee name</th>
				<th>Ranking</th>
				<th>New or Existing</th>
			<?php 
				$result = $mysqli->query(
 				"SELECT u.realname 
 				FROM users u
 				WHERE u.user_Role = 'GCMEMBER' and
 				EXISTS (SELECT * FROM session_users WHERE session_id = " . $sessionID . " and user_id = u.user_ID)
 				ORDER BY u.realname"
 				);
				$i = 0;
				
				while ($obj = $result->fetch_object()){
					echo "<th>".$obj->realname."</th>";
					$i+=1;
				}
			?>
				<th>Average</th>
				<th>Comment</th>	
				<th>Submit Score</th>
				<th>Response?</th>
 				<th>Confirmed?</th>
			</tr>
			<?php
				$result = $mysqli->query("SELECT u.realname, n.session_id, n.nominee_name, n.rank, n.is_newly_admitted, n.nomination_id, n.replied, n.completed
  									FROM nomination n, users u
  									WHERE u.user_ID = n.nominator_id
  									ORDER BY realname");
				
				while($obj = $result->fetch_object()){
					if($obj->session_id == $sessionID){
						echo "<form action='gcmember_submit.php' method='post'>";
						echo "<tr>";
						echo "<input type='hidden' name='nomination_id' value=".$obj->nomination_id.">";
						echo "<td>".$obj->realname."</td>";
						echo "<td><A HREF='".createPage($obj->nominee_name,$obj->nomination_id,$mysqli)."' onClick='return popup(this,true)';>".$obj->nominee_name."</A></td>";						
						echo "<td>".$obj->rank."</td>";
						if(!$obj->is_newly_admitted){
							echo "<td>New</td>";
						}
						else{
							echo "<td>Existing</td>";
						}
						$result2 = $mysqli->query("
 						SELECT u.user_ID, u.realname 
 						FROM users u
 						WHERE u.user_Role = 'GCMEMBER' and
 						EXISTS(SELECT * FROM session_users WHERE session_id = ". $sessionID ." and user_id = u.user_ID)
 						ORDER BY u.realname");
						$average = 0;
						$count = 0;
						$flag = false;
						while($obj2 = $result2->fetch_object()){
							$obj3 = $mysqli->query("SELECT Score FROM score WHERE user_ID = ".$obj2->user_ID." AND nomination_id = ".$obj->nomination_id)->fetch_object()->Score;
							$count++;
							$average += $obj3;
							echo "<td>".$obj3."</td>";	
						}
						if ($count != 0)
 							echo "<td>".$average/$count."</td>";
 						else
 							echo "<td>Undefined</td>";
 						$obj3 = $mysqli->query("SELECT Comments FROM score WHERE user_ID = ".$_SESSION['user_ID']." AND nomination_id = ".$obj->nomination_id)->fetch_object();
 						if ($obj3)
 							$obj3 = $obj3->Comments;
 						else
 							$obj3 = "";
						echo "<td>".$obj3."</td>";
						echo "<td>Nominee already scored</td>";	
						if ($obj->replied != NULL)
 							echo "<td>Yes</td>";
 						else
 							echo "<td>No</td>";
 						if ($obj->completed != NULL)
 							echo "<td>Yes</td>";
 						else
 							echo "<td>No</td>";						
					echo "</tr>";
					echo "</form>";
					}
				}
			?>
		  </center>
		  </table>
		  </html>
		  <?php
}
?>