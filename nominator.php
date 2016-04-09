<?php 
session_start(); 

$page_title = "Nominator";
include_once ("header.php");
?>
<html>
	<head>
	     <link rel="stylesheet" href="styles/main.css" />
	</head>
	
	<center><div class="logo"><a href="index.php" style="text-decoration: none; color: #22222;">GTAMS</a></div></center>

	<section class="nominationform cf">
		<form name="nomination" action="nominator_submit.php" method="post" accept-charset="utf-8">
			<body>
			  <p><label for="nominatorName">Nominator name</label>
			  <input type="text" name="nominatorName" required></p>

			  <p><label for="nominatorMail">Nominator email</label>
			  <input type="email" name="nominatorMail" placeholder="name@example.me" required></p>

			  <p><label for="nomineeName">Nominee name</label>
			  <input type="text" name="nomineeName" required></p>

			  <p><label for="nomineeRank">Nominee rank</label>
			  <input type="number" name="nomineeRank" required></p>

			  <p><label for="nomineePID">Nominee PID</label>
			  <input type="text" name="nomineePID" required></p>

			  <p><label for="nomineeEmail">Nominee email</label>
			  <input type="email" name="nomineeEmail" placeholder="name@example.me" required></p>

			  <p><label for="phdCheck">Is the nominee currently a Ph.d student in the Department of Computer Science?</label><br>
			  <label for="yes1">Yes</label>
			  <input type="radio" id="yes1" name="phdCheck" value="yes"><br>
			  <label for="no1">No</label>
			  <input type="radio" id="no1" name="phdCheck" value="no" ></p>

			  <p><label for="phdNew">Is the nominee currently a newly admitted Ph.d student?</label><br>
			  <label for="yes2">Yes</label>
			  <input type="radio" id="yes2" name="phdNew" value="yes"><br>
			  <label for="no2">No</label>
			  <input type="radio" id="no2" name="phdNew" value="no" ></p>

			  <p><input type="submit" value="Submit"></p>
			</body>
		</form>
	</section>
	
</html>
<?php include_once ("footer.php");?>