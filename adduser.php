<?php
include_once 'includes/db_connect.php';
if(!isset($_SESSION)) { 
	session_start(); 
}
$page_title = "Administration";

$form_token = md5( uniqid('auth', true) );
$_SESSION['form_token'] = $form_token;
include_once("header.php"); ?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
		<div id="page">	
		<br><br>		
		<center><p class="body">
			<h3>Register new user</h3>
			<form action="adduser_submit.php" method="post">
				<fieldset>
					<table>
						<tr><td> <label for="username">Username:</label> </td>
						<td> <input type="text" id="username" name="username" value="" maxlength="20" required> </td></tr>
					
						<tr><td> <label for="password">Password:</label> </td>
						<td> <input type="password" id="password" name="password" value="" maxlength="20" required> </td></tr>
						
						<tr><td> <label for="Name">Name:</label> </td>
						<td> <input type="text" id="Name" name="Name" value="" maxlength="20"> </td></tr>
					
						<tr><td> <label for="email">Email:</label> </td>
						<td> <input type="email" id="email" name="email" value="" maxlength="40"> </td></tr>
						
						<tr><td><label for="selection" style="font-weight: bold;">Select role:</label></td></tr>
							<td style="text-align: center;">
								<label for="GCMEMBER">GC MEMBER</label>
								<input type="radio" id="GCMEMBER" name="selection" value="GCMEMBER" checked>
							</td>
							<td style="text-align: center;">
								<label for="GCCHAIR">GC CHAIR</label>
								<input type="radio" id="GCCHAIR" name="selection" value="GCCHAIR" >
							</td>
							<td style="text-align: center;">
								<label for="GCCHAIR">NOMINATOR</label>
								<input type="radio" id="GCCHAIR" name="selection" value="NOMINATOR" >
							</td>
										
						<tr><td> 
						<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />						
						<input type="submit" value="Register" /> 
						</td></tr>
					</table>
				</fieldset>
			</form>
			<h3>Start new session</h3>
			<form action="session_submit.php" method="post">
				<fieldset>
					<table>
					<!--Research to query and display gc members for selection-->
					<tr>
						<td><label for="members">Choose gc members for this session:</label></td>
						<td><select multiple name="members[]" size=auto style='height: 100%;'>
						<?php 
						$result = $mysqli->query("SELECT user_id, realname FROM users WHERE user_Role = 'GCMEMBER'");
						$i = 0;
						while ($obj = $result->fetch_object()){
							echo "<option value=\"" . $obj->user_id . "\">" . $obj->realname . "</option>";
							$i+=1;
						}
						?>
						</select></td>
					</tr>
					<!--Similar but for chairs-->
					<tr>
						<td><label for="chair">Choose gc chair for this session:</label></td>
						<td><select name="chair">
						<?php 
						$result = $mysqli->query("SELECT u.user_id, u.realname FROM users u WHERE u.user_Role = 'GCCHAIR'");
						$i = 0;
						while ($obj = $result->fetch_object()){
							echo "<option value=\"".$obj->user_id."\">" . $obj->realname . "</option>";
							$i+=1;
						}
						?>
						</select></td>
					</tr>
					<!--User name and password for each selected members-->
					<tr>
						<td><label for="app_deadline">Choose a deadline for application:</label></td>
						<td><input type="date" name="app_deadline"></td>
					</tr>
					<tr>
						<td><label for="initiateDate">Choose a deadline for initiation:</label></td>
						<td><input type="date" name="initiateDate"></td>
					</tr>
					<tr>
						<td><label for="nomineeDate">Choose a deadline for nominee response:</label></td>
						<td><input type="date" name="nomineeDate"></td>
					</tr>
					<tr>
						<td><label for="nominateDate">Choose a deadline for nomination:</label></td>
						<td><input type="date" name="nominateDate"></td>
					</tr>
					<tr>
						<td>
						<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
						<input type="submit" value="Setup Session" /> 
						</td>
					</tr>
					</table>
				</fieldset>
			</form>
		</p></center>		
		<br>		
		<center><p class="body">			
		</p>		
	</div>
</body>
</html>
<?php include_once("footer.php"); ?>