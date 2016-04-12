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

function popper($name){
	?>	<html>		
			<input type='button' value="<?php echo $name ?>" onclick="get()">				
		</html>
			<script>
			function get(){
			window.open('http://www.google.com','<?php echo $name ?>','height=auto,width=auto,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
			}
			</script>
	<?php
}
?>