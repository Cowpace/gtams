<?php
session_start();
$page_title = "GC Member";
include_once ("header.php");
?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
	<div id="page">
	<center><div class="logo"><a href="index.php" style="text-decoration: none; color: #22222;">GTAMS</a></div></center>
	<title>Nominee Info</title>
	<section class="gcmemberform cf">
	<form name="gcmember" action="index_submit" method="get" accept-charset="utf-8">
		<body>
		  <table border="1" style="width:100%">
			<tr>
			  <td>Nominator name</td>
			  <td>Nominee name</td>
			  <td>Ranking</td>
			  <td>New or Existing</td>
			  <td>Score</td>
			  <td>Average</td>
			</tr>
			<tr>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			</tr>
		  </table>
		</body>
	</form>
	</section>
	</div>
</html>