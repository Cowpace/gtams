<?php 
include_once 'includes/db_connect.php';
$page_title = "Nominee";
include_once ("header.php");
?>
<html>
<head><link rel="stylesheet" href="styles/main.css" /></head>
<br><br>
<section class="nomineeform cf">
<form name="nominee" action="nominee_submit.php" method="post" accept-charset="utf-8">
    <body><center>
	<table >
      <tr><td><label for="nominatorName">Nominator name: </label></td>
      <td><input type="text" name="nominatorName" required></td></tr>

      <tr><td><label for="phdAdvisor">Current Ph.d advisor: </label></td>
      <td><input type="text" name="phdAdvisor" required></td></tr>

      <tr><td><label for="phdAdvisors">Previous Ph.d advisors:</label></td>
      <td><input type="text" name="phdAdvisors" required></td>
      <td>Start: <input type="date" name="phdAdvisors"></td>
      <td>End: <input type="date" name="phdAdvisors"></td></tr>

      <tr><td><label for="nomineeName">Nominee name: </label></td>
      <td><input type="text" name="nomineeName" required></td></tr>

      <tr><td><label for="nomineePID">Your PID: </label></td>
      <td><input type="text" name="nomineePID" required></td></tr>

      <tr><td><label for="nomineeMail">Your email: </label></td>
      <td><input type="email" name="nomineeMail" placeholder="name@example.me" required></td></tr>

      <tr><td><label for="nomineeTel">Telephone:</label></td>
      <td><input type="tel" name="nomineeTel" required></td></tr>

      <tr><td><label for="phdCheck">Are you currently a Ph.d student in the Department of Computer Science?</label></td>
      <td><label for="yes1">Yes</label>
      <input type="radio" id="yes1" name="phdCheck" value="yes"></td>
      <td><label for="no1">No</label>
      <input type="radio" id="no1" name="phdCheck" value="no" checked></td></tr>

      <tr><td><label for="gradStudent">Number of semesters as a graduate student: </label></td>
      <td><input type="number" name="gradStudent" min="0" required></td></tr>

      <tr><td><label for="speak">Have you passed the SPEAK Test?</label>
      <td><label for="yes2">Yes</label>
      <input type="radio" id="yes2" name="speak" value="yes"></td>
      <td><label for="no2">No</label>
      <input type="radio" id="no2" name="speak" value="no" checked></td>
      <td><label for="grad2">Graduated from a U.S. institution</label>
      <input type="radio" id="grad2" name="speak" value="grad" ></td></tr>

      <tr><td><label for="GTA">Number of semesters working as a GTA (includes summers): </label></td>
      <td><input type="number" name="GTA" min="0" required></td></tr>

      <tr><td><label for="courses">Graduate level courses completed:</label></td>
      <td>Course Name: <input type="text" name="courses" ></td>
      <td>Letter Grade: <input type="text" name="courses" ></td></tr>

      <!--Might change this-->
      <tr><td><label for="gpa">G.P.A. for listed courses:</label></td>
      <td><input type="number" step="0.01" name="gpa" min = 0 max = 4 required></td></tr>

      <tr><td><label for="publication">List of your publications:</label></td>
      <td>Publication: <input type="text" name="gpa"></td>
      <td>Citation: <input type="text" name="gpa"></td></tr>

      <tr><td><input type="submit" value="Submit"></td></tr>
	  </table></center>
    </body>
</form>
</section>
</html>
