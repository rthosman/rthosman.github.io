<?php
// Becky Hosman
// CSIS 279 - Murtha
// Unit 10 Project 7
// The Cart is Here, shopping cart module of the video store

include("inc_menu.php");

// 1. create new shoppingCart object called $cart
$cart = new shoppingCart();
// ***************************************

if(isset($_GET["remove"]))
{
	// 2. remove an item from the cart, based on the "remove" query string item
	$cart -> removeItem(addslashes($_GET["remove"]), $MyDSN);
	// ***************************************
}
else if(isset($_POST["VideoSKU"]) && isset($_POST["quantity"]))
{
	// 3. add an item to the cart, based on the VideoSKU and quantity fields that were posted
	$cart -> addItem(addslashes($_POST["VideoSKU"]), addslashes($_POST["quantity"]), $MyDSN);
	// ***************************************
}

if(!isset($_GET["LogIn"]) && isset($_SESSION["OrderID"]))
{
	// 4. display the shopping cart, based on the OrderID session variable
	$cart -> display($_SESSION["OrderID"], $MyDSN);
	// ***************************************
}

class shoppingCart
{
	public function display($orderID, $MyDSN)
	{
		$MySQL = "SELECT * FROM movies M, orders O, orderitems I WHERE O.OrderID = " . $orderID . " AND O.OrderID = I.OrderID AND I.VideoSKU = M.VideoSKU;";
		$QueryResult = $MyDSN -> query($MySQL);
		if($QueryResult -> num_rows == 0)
		{
			// the cart is empty, so display an appropriate message
			echo "<h2>Your shopping cart is empty.</h2>";
		}
		else
		{
			// display all of the items in the cart
			echo "<h2>Your Shopping Cart</h2>";
			while($row = $QueryResult -> fetch_assoc())
			{
				echo "<img src=\"http://www.markmurtha.com/mcc/", $row["VideoSKU"], ".gif\"><br>";
				echo $row["Title"], " (quantity: ", $row["quantity"], ")<br>";
				echo "<a href=\"cart.php?remove=", $row["orderItemID"], "\">Remove</a><br><br>";
			}
		}
	}
	
	public function addItem($videoSKU, $quantity, $MyDSN)
	{
		// check to see if the order has been created ($_SESSION["OrderID"]), and create a new order if necessary
		if(!isset($_SESSION["OrderID"]))
		{
			// insert a record into the orders table, and then add the item to the orderitems table
			$MySQL = "INSERT INTO orders(UserIPAddress) VALUES('" . $_SERVER["REMOTE_ADDR"] . "');";
			$QueryResult = $MyDSN -> query($MySQL);
			
			// retrieve the new orderID
			$MySQL = "SELECT MAX(OrderID) FROM orders WHERE UserIPAddress = '" . $_SERVER["REMOTE_ADDR"] . "'";
			$QueryResult = $MyDSN -> query($MySQL);
			$row = $QueryResult -> fetch_row();
	
			// set orderID session variable
			$_SESSION["OrderID"] = $row[0];	
		}
		
		// insert a record into the orderitems table
		$MySQL = "INSERT INTO orderitems(orderID, videoSKU, quantity) VALUES(" . $_SESSION["OrderID"] . ", '" . $videoSKU . "', " . $quantity . ");";
		$QueryResult = $MyDSN -> query($MySQL);

	}
	
	public function removeItem($orderItemID, $MyDSN)
	{
		$MySQL = "DELETE FROM orderitems WHERE OrderItemID = " . $orderItemID . ";";
		$QueryResult = $MyDSN -> query($MySQL);
	}

} // end class shoppingCart

// 5. close the database connection
	$MyDSN -> close();
// ***************************************
?>
