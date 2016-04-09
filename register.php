<?php
include_once 'includes/db_connect.php';
if(!isset($_SESSION)) { 
	session_start(); 
}
$page_title = "Registration";

$form_token = md5( uniqid('auth', true) );
$_SESSION['form_token'] = $form_token;
include_once("header.php"); ?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
		<div id="page">
		<br>	
		<br>		
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
						</tr>					
						<tr><td> 
						<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />						
						<input type="submit" value="Register" /> 
						</td></tr>
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