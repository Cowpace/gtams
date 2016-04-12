<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(!isset($_SESSION)) { 
	session_start(); 
}
$page_title = "GC Member";
include_once ("header.php");
?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
	<div id="page">
	<br><br>
	<title>Nominee Info</title>
	<section class="gcmemberform cf">	
		<body>
		<center>		
		  <table border="1" style="width:100%">
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
					if($obj->session_id == 1){
						echo "<form action='gcmember_submit.php' method='post'>";
						echo "<tr>";
						echo "<input type='hidden' name='nomination_id' value=".$obj->nomination_id.">";
						echo "<td>".$obj->realname."</td>";
						echo "<td><input type='button' value=".$obj->nominee_name." onclick=\"window.open('http://www.google.com','popUpWindow','height=auto,width=auto,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');\"></td>";
						
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
							$obj3 = $mysqli->query("SELECT Score FROM score WHERE user_ID = ".$obj2->user_ID." AND nomination_id = ".$obj->nomination_id)->fetch_object()->Score;
							if($_SESSION['user_ID'] == $obj2->user_ID && $obj3 == 0){
								echo "<td><input type='number' id='score' name='score' min='1' max='100'></td>";
								$flag = true;
							}
							else{
								$count++;
								$average += $obj3;
								echo "<td>".$obj3."</td>";	
							}
	
						}
						echo "<td>".$average/$count."</td>";						
						if($flag){
							echo "<td><input type='text' id='comment' name='comment'></td>";
							echo "<td><input type='submit' value='Score Nominee' /></td>";
						}
						else{
							echo "<td>Nominee already scored</td>";
							echo "<td>Nominee already scored</td>";
						}
						
					echo "</tr>";
					echo "</form>";
					}
				}
			?>
		  </table>		  		  
		  </center>
		</body>
	</section>
	</div>
</html>