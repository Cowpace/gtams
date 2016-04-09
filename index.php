<?php
if(!isset($_SESSION)) { 
	session_start(); 
}
$page_title = "Login";
include_once("header.php");?>
<!DOCTYPE html>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
	<body>
	<div id="page">
		<br><br>
		<?php if(!isset($_SESSION['user_ID'])): ?>		
			<center><p class="body">
				<h3>Login Below</h3>
				<form action="includes/process_login.php" method="post">
					<fieldset>
						<p>
							<label for="username">Username:</label>
							<input type="text" id="username" name="username" value="" maxlength="20" />
						</p>
						<p>
							<label for="password">Password:</label>
							<input type="password" id="password" name="password" value="" maxlength="20" />
						</p>
						<p>
							<input type="submit" value="Login" />
						</p>
					</fieldset>
				</form>
			</p></center>					
			</p>			
		<?php else: ?>		
			<center><p class="body">					
				<?php if(isset($_SESSION['user_Role']) && $_SESSION['user_Role'] == "ADMIN"): ?>
					<div id="navbar">
						<h4>Please sign-in again<br><a href="logout.php">Logout</a></a></h4>
					</div>
				<?php else: ?>					
					<h4><a href="logout.php">Logout</a>, Session Error</h4>					
				<?php endif; ?>				
			</p>			
		<?php endif; ?>	
	</div>
</body>
</html>
<?php include_once("footer.php");?>