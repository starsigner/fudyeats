<html>

<head>
	<title>View Restaurants</title>
	<style>
		<?php include 'project.css'; ?>
	</style>
</head>

<body>
	<h1>FÜdy Eats</h1>
	<h2>Available Restaurants</h2>

	<?php
	include 'functions.php';
	ob_start();
	session_start();
	unset($_SESSION['my_cart']);
	unset($_SESSION['total_price']);
	unset($_SESSION['total_time']);
	$type = $_POST['type'];
	if (isset($_POST['filter_request'])) {
		if (connectToDB()) {
			if ($type == "all") {
				$result = executePlainSQL("SELECT r1.r_name, r1.address, r1.type, r2.rating 
				FROM Restaurant1 r1, Restaurant2 r2 
				WHERE r1.r_name = r2.r_name 
				AND r1.address = r2.address
				ORDER BY r2.rating DESC");
			} else {
				$result = executePlainSQL("SELECT r1.r_name, r1.address, r1.type, r2.rating 
				FROM Restaurant1 r1, Restaurant2 r2 
				WHERE r1.r_name = r2.r_name 
				AND r1.address = r2.address AND LOWER(r1.type) = '{$type}'
				ORDER BY r2.rating DESC");
			}
			printTable($result, ["Restaurant Name", "Address", "Restaurant Type", "FÜdy Eats Rating Score"], "view_table");
			$result2 = executePlainSQL("SELECT r1.type, AVG(r2.rating), COUNT(*)
				FROM Restaurant1 r1, Restaurant2 r2 
				WHERE r1.r_name = r2.r_name 
				AND r1.address = r2.address AND r1.type is not null
				GROUP BY r1.type
				HAVING AVG(r2.rating) > (SELECT AVG(r3.rating) FROM Restaurant2 r3)");
			echo "<h3>FÜdy Eats Good Restaurant Types AVG RATING (more than the average rating)</h3>";
			printTable($result2, ["Restaurant Type", "Average Type Rating", "Type Count"], "table_count");
		}
		disconnectFromDB();
	} else if (isset($_POST['deal_day'])) {
		if (connectToDB()) {
			$result = executePlainSQL("SELECT r1.r_name, r1.address, r1.type, r2.rating 
				FROM Restaurant1 r1, Restaurant2 r2 
				WHERE r1.r_name = r2.r_name 
				AND r1.address = r2.address
				AND NOT EXISTS (SELECT m1.item_name FROM MenuItem1 m1 WHERE m1.price > 50
				MINUS SELECT m2.item_name FROM MenuItem1 m2 WHERE m2.r_name = r1.r_name AND m2.address = r1.address)
				ORDER BY r2.rating DESC");
			printTable($result, ["Restaurant Name", "Address", "Restaurant Type", "FÜdy Eats Rating Score"], "view_table");
		}
		disconnectFromDB();
	}
	?>
	<form method="POST" action="view_restaurant.php">
		<h3>Filter Restaurants By Type</h3>
		<label for="type">Type:</label><br>
		<select id="type" name="type"><br><br>
			<option value="all">All</option>
			<option value="mexican">Mexican</option>
			<option value="cafe">Cafe</option>
			<option value="german">German</option>
			<option value="steakhouse">Steakhouse</option>
			<option value="italian">Italian</option>
			<option value="indian">Indian</option>
			<option value="bar_and_grill">Bar and Grill</option>
			<option value="fast_food">Fast Food</option>
			<option value="steakhouse">Steakhouse</option>
			<option value="indo_chinese">Indo-Chinese</option>
			<option value="sushi">Sushi</option>
			<option value="other">Other</option>
		</select><br><br>
		<input type="hidden" id="filter_request" name="filter_request">
		<input type="submit" value="Filter Menu" name="filterMenu">
	</form>

	<form method="POST" action="view_restaurant.php">
		<h3>Bougie Day!!!</h3>
		<p style="font-size: 14px;">Hmmmmm.... sometimes you just want to have an expensive and exquisite meal, here are
			restaurants that contain all the most luxurious plates greater than 50 bucks</p>
		<input type="hidden" id="deal_day" name="deal_day">
		<input type="submit" value="Click Here For a Surprise!!!" name="deal_day">
	</form>

	<form method="POST" action="view_restaurant.php">
		<h2>View Menu From Restaurant (Click on Restaurant Rows to AutoFill)</h2>
		<label for="r_name">Restaurant Name: </label>
		<input type="text" id="r_name" name="r_name" readonly>
		<br>
		<label for="r_address">Address: </label>
		<input type="text" id="r_address" name="r_address" readonly>
		<br>
		<input type="hidden" id="view_menu_request" name="view_menu_request">
		<input type="submit" value="View Menu" name="viewMenu">
	</form>
	<?php
	function handleViewMenuListener($r_name, $address)
	{
		header("Location: view_menu.php");
		session_write_close();
		exit();
	}

	$_SESSION['r_name'] = $_POST['r_name'];
	$_SESSION['r_address'] = $_POST['r_address'];

	if (isset($_POST['view_menu_request'])) {
		if ($_SESSION['r_name'] != '' && $_SESSION['r_address'] != ''){
			handleViewMenuListener($r_name, $address);
		} else {
			echo "<p>ERROR: Please fill in the View Menu form via AutoFill</p><br>";
		}
	}
	?>

	<script>
		var table = document.getElementById("view_table");
		table.addEventListener("click", (event) => {
			if (event.target.tagName === "TD") {
				var rowParent = event.target.parentNode;
				var rowData0 = rowParent.cells[0].textContent;
				var rowData1 = rowParent.cells[1].textContent;
				document.getElementById("r_name").value = rowData0;
				document.getElementById("r_address").value = rowData1;
			}
		});
	</script>
</body>


</html>