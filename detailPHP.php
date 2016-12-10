<?php
// Becky Hosman
// CSIS 279 - Murtha
// Unit 10 Project 5
// this page will display a single video, based on a query string value.

include("inc_menu.php");

// check for v query string name/value pair
if(isset($_GET["v"]))
{
	// addslashes to query string value
	$videoSKU = addslashes($_GET["v"]);
	
	// build the SQL statement
	$mySQL = "SELECT * FROM Movies WHERE VideoSKU='" . $videoSKU . "' ";
	
	// execute the SQL statement
	$QueryResult = $MyDSN -> query($mySQL);
	
	// display an appropriate message if there are no results
	if($QueryResult -> num_rows == 0)
	{
		echo "<br>No videos were found matching your search text.";
	}
	else
	{
		// display the record if results are found
		$row = $QueryResult -> fetch_assoc();
		// assign field values 
		$title = $row["Title"];
		$studio = $row["Studio"];
		$category = $row["Category"];
		$price = $row["Price"];
		$description = $row["Description"];
		?>
		
	<table style="width:500px">
		<form method="post" action="cart.php">
		<tr>
		<th colspan="2"><?php echo $title;?></th>
		</tr>
		<tr>
			<td><img border="0" src="http://www.markmurtha.com/mcc/
			<?php echo $videoSKU;?>.gif"
				alt=<?php echo $title;?>
				title=<?php echo $title;?>>
				<br>
			<strong>Price: $</strong><?php echo $price;?></strong><br>
			</td><td>
			<strong>Studio: </strong><?php echo $studio;?><br>
			<strong>Category: </strong><?php echo $category;?><br>
			<strong>Description: <br></strong><?php echo $description;?><br>
			<strong>Quantity: </strong>
			
			<select name="quantity">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			
			<input type="submit" value="Add to Cart">
			<input type="hidden" name="VideoSKU" value="<?php echo $videoSKU;?>">
			<input type="hidden" name="Title" value="<?php echo $title;?>">
			<input type="hidden" name="Price" value="<?php echo $price;?>">
			</td></form>
		</tr><th colspan=2>
	</th></table>

	<?php	
	}
	
} // end if

// close the database connection
$MyDSN -> close();

?>

</body>
</html>


