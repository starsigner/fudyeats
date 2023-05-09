<html>

<head>
	<title>Order Items</title>
	<style>
		<?php include 'project.css'; ?>
	</style>
</head>

<body>

	<!-- Order Item -->
	<!-- Backend: Insert Restaurant into Restaurant1 Table -->
	<h2>Your Order Contains:</h2>
	<?php
	include "functions.php";
	ob_start();
	session_start();
	$my_cart = $_SESSION['my_cart'];
	foreach ($my_cart as $menuItem) {
		echo "Restaurant Name: {$menuItem->r_name}, Restaurant Address: {$menuItem->address}, Menu Item Ordered: {$menuItem->mi_name} <br>";
	}
	$total = round($_SESSION['total_price'] * 1.12, 2);
	echo "The subtotal is {$_SESSION['total_price']} Dollars, the total is {$total} dollars<br>";
	echo "Total Time: {$_SESSION['total_time']} Minutes<br>";
	?>


	<div class="register_account">
		<h3> Fill in with your credentials for ordering </h3>
		<form action="createAccount.php" method="POST">
			<label for="c_name">Customer Name*:</label><br>
			<input type="text" id="c_name" name="c_name" value=""><br><br>
			<label for="c_email">Customer Email*:</label><br>
			<input type="email" id="c_email" name="c_email"><br><br>
			<label for="c_number">Customer Phone Number*:</label><br>
			<input type="number" id="c_number" name="c_number" maxlength="10"><br><br>
			<label for="c_curr_location">Current Location* :</label><br>
			<input type="text" id="c_curr_location" name="c_curr_location" value=""><br><br>
			<label for="c_address">Address*:</label><br>
			<input type="text" id="c_address" name="c_address" value=""><br><br>
			<label for="order_type">Order Type*:</label><br>
			<label>
				<input type="radio" id="order_type" name="order_type" value="Delivery">
				Delivery </label>
			<label><br>
				<input type="radio" id="order_type" name="order_type" value="PickUp">
				PickUp </label>
			<input type="hidden" id="register_account" name="register_account">
			<input type="submit" value="Submit"><br><br>
		</form>
	</div>

	<?php

	$c_name = $_POST["c_name"];
	$c_email = $_POST["c_email"];
	$c_number = $_POST["c_number"];
	$c_curr_location = $_POST["c_curr_location"];
	$order_type = $_POST["order_type"];
	$c_address = $_POST["c_address"];

	$c_id = rand(1000, 9999);
	$order_id = rand(1000, 9999);

	$_SESSION['c_id'] = $c_id;
	$_SESSION['order_id'] = $order_id;

	function handleCreateOrder($order_id)
	{
		if (connectToDB()) {
			global $db_conn;

			$tuple = array(
				":bind1" => $order_id,
				":bind2" => $_SESSION['total_price'],
				":bind3" => $_SESSION['total_price'] * 1.12,
				":bind4" => $_SESSION['r_name'],
				":bind5" => $_SESSION['r_address']
			);

			$alltuples = array(
				$tuple
			);
			executeBoundSQL("insert into Order1 values (:bind1, :bind2, :bind3)", $alltuples);
			executeBoundSQL("insert into Order2 values (:bind1, 'in progress', :bind4, :bind5)", $alltuples);
			OCICommit($db_conn);
			echo "SUCCESS";
			echo $order_id;
		}
	}
	function handleCreateOrderType($order_id, $c_curr_location, $c_address, $type)
	{
		//CHANGE DELIVERY DRIVER ID
		if (connectToDB()) {
			global $db_conn;

			$tuple = array(
				":bind1" => $order_id,
				":bind2" => 0,
				":bind3" => $c_curr_location,
				":bind4" => $c_address
			);

			$alltuples = array(
				$tuple
			);

			if ($type == "Delivery") {
				executeBoundSQL("insert into Delivery values (:bind1, timestamp '2017-10-12 13:00:00', :bind3, null)", $alltuples);
			} else {
				executeBoundSQL("insert into Pickup values (:bind1, timestamp '2017-10-12 13:00:00', :bind4)", $alltuples);
			}

			OCICommit($db_conn);
			echo "SUCCESS";
			echo $order_id;
			echo $type;
		}
	}
	function handleCreateCustomer($c_id, $c_name, $c_address, $c_number, $c_email, $order_id, $c_curr_location)
	{
		if (connectToDB()) {
			global $db_conn;

			$tuple = array(
				":bind1" => $c_id,
				":bind2" => $c_name,
				":bind3" => $c_address,
				":bind4" => $c_number,
				":bind5" => $c_email,
				":bind6" => $order_id,
				":bind7" => $c_curr_location
			);

			$alltuples = array(
				$tuple
			);
			executeBoundSQL("insert into Customer1 values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
			executeBoundSQL("insert into Customer2 values (:bind1, :bind7, :bind6)", $alltuples);
			OCICommit($db_conn);
			echo "SUCCESS";
			echo $c_id;
		}
	}
	function handlePairCartToOrder($order_id)
	{
		if (connectToDB()) {
			global $db_conn;
			$my_cart = $_SESSION['my_cart'];
			foreach ($my_cart as $menuItem) {
				$tuple = array(
					":bind1" => $order_id,
					":bind2" => $menuItem->r_name,
					":bind3" => $menuItem->address,
					":bind4" => $menuItem->mi_name
				);
				$alltuples = array(
					$tuple
				);
				executeBoundSQL("insert into MenuItemHasOrder values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
				echo "SUCCESS";
				echo $menuItem->mi_item;
			}
			OCICommit($db_conn);
		}
	}
	if (isset($_POST['register_account'])) {
		if ($c_name != '' && $c_email != '' && $c_address != '' && $c_email != '' && $c_curr_location != '' && !empty($c_number)) {
			handleCreateOrder($order_id);
			handleCreateOrderType($order_id, $c_curr_location, $c_address, $order_type);
			handleCreateCustomer($c_id, $c_name, $c_address, $c_number, $c_email, $order_id, $c_curr_location);
			handlePairCartToOrder($order_id);
			header('location: order_complete.php');
			session_write_close();
			exit();
		} else {
			echo "<p>Please fill in all the fields</p><br>";
		}

	}


	?>

</body>

</html>