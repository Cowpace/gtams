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
		
	?>	<html>		
			<input type='button' value="<?php echo $name ?>" onclick="get()">				
		</html>
			<script>
			function get(){
			<?php $file = createPage($nomid); ?>
			window.open('<?php $file ?>','<?php echo $name ?>','height=auto,width=auto,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
			}
			</script>
	<?php
}

function createPage($nomid){
	$filename = "nomination".$nomid.".php";
	$fp = fopen("$filename",'x');
	fwrite($fp, "<?php\n
					echo ".$nomid.";
					?>\n
					<script>\n
					window.onbeforeunload = function(){
						<?php unlink(".$filename."); ?>
					}\n</script>");
    fclose($fp);
	return $filename;
}

function oldGCTable($sessionID,$mysqli){
		?><html>
		<table border="1" style="width:100%">
		  <center>
			<tr>
				<th>Nominator name</th>
				<th>Nominee name</th>
				<th>Ranking</th>
				<th>New or Existing</th>
			<?php 
				$result = $mysqli->query("SELECT realname FROM users WHERE user_Role = 'GCMEMBER' ORDER BY realname");
				$i = 0;
				
				while ($obj = $result->fetch_object()){
					echo "<th>".$obj->realname."</th>";
					$i+=1;
				}
			?>
				<th>Average</th>
				<th>Comment</th>	
				<th>Submit Score</th>
			</tr>
			<?php
				$result = $mysqli->query("SELECT u.realname, n.session_id, n.nominee_name, n.rank, n.is_newly_admitted, n.nomination_id
									FROM nomination n, users u
									WHERE u.user_ID = n.nominator_id
									ORDER BY realname");
				
				while($obj = $result->fetch_object()){
					if($obj->session_id == $sessionID){
						echo "<form action='gcmember_submit.php' method='post'>";
						echo "<tr>";
						echo "<input type='hidden' name='nomination_id' value=".$obj->nomination_id.">";
						echo "<td>".$obj->realname."</td>";
						echo "<td>".$obj->nominee_name."</td>";								
						echo "<td>".$obj->rank."</td>";
						if(!$obj->is_newly_admitted){
							echo "<td>New</td>";
						}
						else{
							echo "<td>Existing</td>";
						}
						$result2 = $mysqli->query("SELECT user_ID, realname FROM users WHERE user_Role = 'GCMEMBER' ORDER BY realname");
						$average = 0;
						$count = 0;
						$flag = false;
						while($obj2 = $result2->fetch_object()){
							$obj2->user_ID;
							$obj->nomination_id;
							$obj3 = $mysqli->query("SELECT Score FROM score WHERE user_ID = ".$obj2->user_ID." AND nomination_id = ".$obj->nomination_id)->fetch_object()->Score;
							$count++;
							$average += $obj3;
							echo "<td>".$obj3."</td>";	
						}
						echo "<td>".$average/$count."</td>";
						$obj3 = $mysqli->query("SELECT Comments FROM score WHERE user_ID = ".$_SESSION['user_ID']." AND nomination_id = ".$obj->nomination_id)->fetch_object()->Comments;
						echo "<td>".$obj3."</td>";
						echo "<td>Nominee already scored</td>";						
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