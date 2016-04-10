<?php 
if(!isset($_SESSION)) { 
	session_start(); 
}

$page_title = "Nominator";
include_once ("header.php");
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
	<section class="nominationform cf">
	<br><br>	
		<div align=center>
		<h3>Start a new Nomination</h3>
		<form name="nomination" action="nominator_submit.php" method="post" accept-charset="utf-8">
			<body>
			<table>
			  <tr><td><label for="nominatorName">Nominator name</label></td>
			  <td><input type="text" name="nominatorName" required></td></tr>
			  
			  <tr><td><label for="nominatorMail">Nominator email</label></td>
			  <td><input type="email" name="nominatorMail" placeholder="name@example.me" required></td></tr>

			  <tr><td><label for="nomineeName">Nominee name</label></td>
			  <td><input type="text" name="nomineeName" required></td></tr>

			  <tr><td><label for="nomineeRank">Nominee rank</label></td>
			  <td><input type="number" name="nomineeRank" required></td></tr>

			  <tr><td><label for="nomineePID">Nominee PID</label></td>
			  <td><input type="text" name="nomineePID" required></p></td></tr>

			  <tr><td><label for="nomineeEmail">Nominee email</label>
			  <td><input type="email" name="nomineeEmail" placeholder="name@example.me" required></td></tr>

			  <tr><td colspan = "2"><label for="phdCheck">Is the nominee currently a Ph.d student in the Department of Computer Science?</label></td></tr>
			  <td><label for="yes1">Yes</label>
			  <input type="radio" id="yes1" name="phdCheck" value="yes"></td>
			  <td><label for="no1">No</label>
			  <input type="radio" id="no1" name="phdCheck" value="no" checked></td></tr>

			  <tr><td colspan = "2"><label for="phdNew">Is the nominee currently a newly admitted Ph.d student?</label></td></tr>
			  <td><label for="yes2">Yes</label>
			  <input type="radio" id="yes2" name="phdNew" value="yes"></td>
			  <td><label for="no2">No</label>
			  <input type="radio" id="no2" name="phdNew" value="no" checked></td>

			  <tr><td style="text-align: center;" colspan = "2"><input type="submit" value="Submit" ></td></tr>
			  </table>
			</body>
		</form>
		</div>
	</section>
	<div align=center>
	<h3>Confirm nominee</h3>
	<form name="nomination" action= "confirm.php" method="post" accept-charset="utf-8">
		<body>
			<select name = "nominees">
				<?php 
					$stmt = $mysqli->prepare("
						SELECT n.nomination_id, n.nominee_name
						FROM nomination n, users u
						WHERE u.user_ID = n.nominator_id and u.user_ID = ? and n.replied IS NOT NULL and n.completed IS NULL
					");
					$id = $_SESSION['user_ID'];
					$v = $stmt->bind_param("i", $id);
					$stmt->execute();
					$stmt->bind_result($nom_id, $nominee_name);
					
					$i = 0;
					while ($stmt->fetch()){
						echo "<option value=\"".$nom_id."\">" . $nominee_name . "</option>";
						$i+=1;
					}
				?>
			</select>
			<input type="submit" value="View Data" >
			
		</body>
	</form>
	</div>

</html>
<?php include_once ("footer.php");?>