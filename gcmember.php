<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(!isset($_SESSION)) { 
	session_start(); 
}
$page_title = "GC Member";
include_once ("header.php");

if (!isset($_SESSION['GC_SESSION_ID']))
	$_SESSION['GC_SESSION_ID'] = $mysqli->query("SELECT session_id FROM sessions WHERE is_active = 1")->fetch_object()->session_id;

?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
	<div id="page">
	<br><br>
	<form name="sessions" action= "reload_session.php" method="post" accept-charset="utf-8">
		<body>
			<select name = "session">
				<?php 
					$stmt = $mysqli->prepare("
						SELECT session_id
						FROM sessions
					");
					$stmt->execute();
					$stmt->bind_result($s);
					
					while ($stmt->fetch()){
						$str = '';
						if ($s == $_SESSION['GC_SESSION_ID'])
							$str = 'selected = "selected"';
						
						
						echo "<option value=\"".$s."\" " . $str . " >Session ".$s."</option>";
					}
				?>
			</select>
			<input type="submit" value="View Data" >
			
		</body>
	</form>
	<section class="gcmemberform cf">	
		<body>				
		  <?php oldGCTable($_SESSION['GC_SESSION_ID'], $mysqli); ?>		  		  
		  
		</body>
	</section>
	</div>
</html>