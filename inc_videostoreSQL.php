<?php
// Becky Hosman
// CSIS 279 - Murtha
// Unit 10 Project 2
// Establish connection to the videostore DB (to include on multiple pages)

// 1. set database connection variable, or display error
$MyDSN = new mysqli("localhost", "root", "", "videostore");
// *****************************************************

// check database connection
if($MyDSN -> connect_errno != 0)
{
	echo "<br>There was a problem connecting to the database.<br>";
	
	// 2. close the database connection
	$MyDSN -> close();
	// *****************************************************
	
	exit;
}

?>


