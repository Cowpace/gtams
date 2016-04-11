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
		  <table border="1" style="width:100%">
			<tr>
			  <th>Nominator name</th>
			  <th>Nominee name</th>
			  <th>Ranking</th>
			  <th>New or Existing</th>
			<?php 
				$result = $mysqli->query("SELECT user_id, realname FROM users WHERE user_Role = 'GCMEMBER'");
				$i = 0;
				
				while ($obj = $result->fetch_object()){
					echo "<th>".$obj->realname."</th>";
					$i+=1;
				}
			?>
			  <th>Average</th>
			</tr>
			<?php
				$result = $mysqli->query("SELECT u.realname, n.session_id, n.nominee_name, n.rank, n.is_newly_admitted 
									FROM nomination n, users u
									WHERE u.user_ID = n.nominator_id
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
						$t = $i;
						while ($t > 0){
							echo "<td>"."</td>";
							$t--;
						}
						echo "<td>"."</td>";
						echo "</tr>";
					}
				}
			?>
		  </table>
		  </center>
		</body>
	</form>
	</section>
	</div>
</html>