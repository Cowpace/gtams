<?php include_once ("header.php");?>
<html>
<head><link rel="stylesheet" href="styles/main.css" /></head>
<h1>GTASS</h1>
<title>Nominee Info</title>
<section class="nomineeform cf">
<form name="nominee" action="nominee_submit.php" method="post" accept-charset="utf-8">
    <body>
      <p><label for="nominatorName">Nominator name: </label>
      <input type="text" name="nominatorName" required></p>

      <p><label for="phdAdvisor">Current Ph.d advisor: </label>
      <input type="text" name="phdAdvisor" required></p>

      <p><label for="phdAdvisors">Previous Ph.d advisors:</label><br>
      <input type="text" name="phdAdvisors" required>
      Start: <input type="date" name="phdAdvisors">
      End: <input type="date" name="phdAdvisors"></p>

      <p><label for="nomineeName">Nominee name: </label>
      <input type="text" name="nomineeName" required></p>

      <p><label for="nomineePID">Your PID: </label>
      <input type="text" name="nomineePID" required></p>

      <p><label for="nomineeMail">Your email: </label>
      <input type="email" name="nomineeMail" placeholder="name@example.me" required></p>

      <p><label for="nomineeTel">Telephone:</label>
      <input type="tel" name="nomineeTel" required></p>

      <p><label for="phdCheck">Are you currently a Ph.d student in the Department of Computer Science?</label><br>
      <label for="yes1">Yes</label>
      <input type="radio" id="yes1" name="phdCheck" value="yes"><br>
      <label for="no1">No</label>
      <input type="radio" id="no1" name="phdCheck" value="no" ></p>

      <p><label for="gradStudent">Number of semesters as a graduate student: </label>
      <input type="number" name="gradStudent" min="0" required></p>

      <p><label for="speak">Have you passed the SPEAK Test?</label><br>
      <label for="yes2">Yes</label>
      <input type="radio" id="yes2" name="speak" value="yes"><br>
      <label for="no2">No</label>
      <input type="radio" id="no2" name="speak" value="no" ><br>
      <label for="grad2">Graduated from a U.S. institution</label>
      <input type="radio" id="grad2" name="speak" value="grad" ></p>

      <p><label for="GTA">Number of semesters working as a GTA (includes summers): </label>
      <input type="number" name="GTA" min="0" required></p>

      <p><label for="courses">Graduate level courses completed:</label><br>
      Course Name: <input type="text" name="courses" >
      Letter Grade: <input type="text" name="courses" ></p>

      <!--Might change this-->
      <p><label for="gpa">G.P.A. for listed courses:</label>
      <input type="number" step="0.01" name="gpa" min = 0 max = 4 required></p>

      <p><label for="publication">List of your publications:</label><br>
      Publication: <input type="text" name="gpa">
      Citation: <input type="text" name="gpa"></p>

      <p><input type="submit" value="Submit"></p>
    </body>
</form>
</section>
</html>
