<?php
// Becky Hosman
// CSIS 279 - Murtha
// Unit 10 Project 4
// Searching searching searching, search on!

include("inc_menu.php");

// check to see if the form was submitted
if(isset($_POST["txtSearch"]))
{
	$myCategory = "";
	// if it was, build the SQL statement based on their search
	// check to see if a category was selected
	if($_POST["txtCategory"] != "")
	{
		$MySQL = "SELECT Title, Price, VideoSKU FROM movies " .
				  "WHERE Title LIKE '%" . addslashes($_POST["txtSearch"]) . "%'" .
				  "AND Category ='" . addslashes($_POST["txtCategory"]) . "' " .
				  "ORDER BY Title;";
		$myCategory = $_POST["txtCategory"];
	}
	else
	{
		$MySQL = "SELECT Title, Price, VideoSKU FROM movies " .
				  "WHERE Title LIKE '%" . addslashes($_POST["txtSearch"]) . "%'" .
				  "ORDER BY Title;";	
	}
	// execute the SQL statement
	$QueryResult = $MyDSN -> query($MySQL);

	// if no rows were returned, display a message to the user, if rows were returned
	// display the number of rows returned
	if($QueryResult -> num_rows != 0)
	{
	   // PHP statements here
	   echo "<br>", $QueryResult -> num_rows, " matching ", $myCategory, " record(s) found.<br><br>";
	
		// if rows were returned, display the rows (use a loop)
		while ($row = $QueryResult -> fetch_array())
		{
			echo "<a href=\"detail.php?v=", $row[2], "\">";
			echo "<img src=\"http://www.markmurtha.com/mcc/", $row[2], ".gif\"><br>";
			echo $row[0], "</a><br>"; 
			echo "Price: $", $row[1], "<br><br>";
		}
	}
	else
	{
		echo "<br>Search for something else.<br>";
	}

}

// close the database connection
$MyDSN -> close();


?>
</body>
</html>