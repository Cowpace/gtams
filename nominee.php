<?php 
include_once 'includes/db_connect.php';
$page_title = "Nominee";
include_once ("header.php");

?>
<html>
<SCRIPT language="javascript">
	function addRow(tableID, elemName, attrs) {
		/*
			an add row function for an abstract table
			args:
				tableID (HTML id): the table to add a row to
				elemName (String): 
				attrs (2d Array of Strings): [[Label, Type], ...]
				
			note: the HTML attribute array things (i dont know HTML well enough to know what they are)
				for each field of the table are of the form: "<elemName>_<Label[i]>[]"
				
				do a for each on the $_POST var to know how to take the data from the table
				
				Also, if I knew how classes worked in Javascript I would add this to a seperate class
		*/
		var table = document.getElementById(tableID);

		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);

		var cell1 = row.insertCell(0);
		var element1 = document.createElement("input");
		element1.type = "checkbox";
		element1.name="chkbox[]";
		cell1.appendChild(element1);
		
		for (i=0; i < attrs.length; i++){
			var cell = row.insertCell((2*i)+1);
			cell.innerHTML = attrs[i][0] + ": ";
			
			var cell2 = row.insertCell((i*2) + 2);
			var element = document.createElement("input");
			element.type = attrs[i][1];
			element.name = elemName + "_" + attrs[i][0] + "[]";
			cell2.appendChild(element);
		}
		/*
		var cell2 = row.insertCell(1);
		cell2.innerHTML = "Name: ";

		var cell3 = row.insertCell(2);
		var element3 = document.createElement("input");
		element3.type = "text";
		element3.name = "advisor_name[]";
		cell3.appendChild(element3);

		var cell4 = row.insertCell(3);
		cell4.innerHTML = "Start: ";
		
		var cell5 = row.insertCell(4);
		var element4 = document.createElement("input");
		element4.type = "date";
		element4.name = "advisor_start[]";
		cell5.appendChild(element4);
		
		var cell6 = row.insertCell(5);
		cell6.innerHTML = "End: ";
		
		var cell7 = row.insertCell(6);
		var element5 = document.createElement("input");
		element5.type = "date";
		element5.name = "advisor_end[]";
		cell7.appendChild(element5);*/
	}

	function deleteRow(tableID) {
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				table.deleteRow(i);
				rowCount--;
				i--;
			}


		}
		}catch(e) {
			alert(e);
		}
	}

</SCRIPT>
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
		
		
	  <tr><td><label for="phd_table">Previous Ph.D Advisors: </label></td></tr>
	  <tr>
		<td colspan = "2"><input type="button" value="Add Advisor" onclick="addRow('phd_table', 'advisor', [['Name', 'text'], ['Start', 'date'], ['End', 'date']])">
		<input type="button" value="Remove Selected" onclick="deleteRow('phd_table')"></td>
	  </tr>
	  <tr><td colspan = "10">
		<table id = "phd_table"></table>
	  </td></tr>

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
		
	  <tr><td><label for="courses">Graduate level courses completed:</label></td></tr>
	  <tr>
		<td colspan = "2"><input type="button" value="Add Course" onclick="addRow('course_table', 'course', [['Name', 'text'], ['Grade', 'text']])">
		<input type="button" value="Remove Selected" onclick="deleteRow('course_table')"></td>
	  </tr>
	  <tr><td colspan = "10">
		<table id = "course_table"></table>
	  </td></tr>


      <!--Might change this-->
      <tr><td><label for="gpa">G.P.A. for listed courses:</label></td>
      <td><input type="number" step="0.01" name="gpa" min = 0 max = 4 required></td></tr>
		
		
	<tr><td><label for="pub">List of your publications:</label></td></tr>
	  <tr>
		<td colspan = "2"><input type="button" value="Add Publication" onclick="addRow('pub_table', 'pub', [['Title', 'text'], ['Citation', 'text']])">
		<input type="button" value="Remove Selected" onclick="deleteRow('pub_table')"></td>
	  </tr>
	  <tr><td colspan = "10">
		<table id = "pub_table"></table>
	  </td></tr>

      <tr><td><input type="submit" value="Submit"></td></tr>
	  </table></center>
    </body>
</form>
</section>
</html>
