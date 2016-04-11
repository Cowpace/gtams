<?php
include_once 'includes/db_connect.php';
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
	<form name="gcmember" action="index_submit" method="get" accept-charset="utf-8">
		<body>
		<center>
		<form action="gcmember_submit.php" method="post">
		  <table border="1" style="width:100%">
			<tr>
				<th>Nominator name</th>
				<th>Nominee name</th>
				<th>Ranking</th>
				<th>New or Existing</th>
			<?php 
				$result = $mysqli->query("SELECT user_id, realname FROM users WHERE user_Role = 'GCMEMBER' ORDER BY realname");
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
				$result = $mysqli->query("SELECT u.realname, n.session_id, n.nominee_name, n.rank, n.is_newly_admitted 
									FROM nomination n, users u
									WHERE u.user_ID = n.nominator_id
									ORDER BY realname");
				$result2 = $mysqli->query("SELECT u.realname, u.user_ID, s.Score
									FROM users u, score s
									WHERE u.user_Role = 'GCMEMBER' AND
									u.user_ID = s.user_ID
									ORDER BY realname");
				
				while($obj = $result->fetch_object()){
					if($obj->session_id == 1){
					echo "<tr>";
						echo "<td>".$obj->realname."</td>";
						echo "<td>".$obj->nominee_name."</td>";
						echo "<td>".$obj->rank."</td>";
						if($obj->is_newly_admitted){
							echo "<td>New</td>";
						}
						else{
							echo "<td>Existing</td>";
						}
						$average = 0;
						$count = 0;
						$flag = false;
						while($obj2 = $result2->fetch_object()){
							if($_SESSION['user_ID'] == $obj2->user_ID && $obj2->Score == 0){
								echo "<td><input type='number' id='score' name='score[]' min='1' max='100'></td>";
								$flag = true;
							}
							else{
								$count++;
								$average += $obj2->Score;
								echo "<td>".$obj2->Score."</td>";	
							}
	
						}
						echo "<td>".$average/$count."</td>";						
						if($flag){
							echo "<td><input type='text' id='comment' name='comment[]'></td>";
							echo "<td><input type='submit' value='Score Nominee' /></td>";
						}
						else{
							echo "<td>Nominee already scored</td>";
							echo "<td>Nominee already scored</td>";
						}
						
					echo "</tr>";
					}
				}
			?>
		  </table>
		  
		  </form>
		  </center>
		</body>
	</form>
	</section>
	</div>
</html>