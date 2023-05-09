<html>

<head>
    <title>Order Complete</title>
    <style>
        <?php include 'project.css'; ?>
    </style>
</head>

<body>

    <!-- Order Item -->
    <!-- Backend: Insert Restaurant into Restaurant1 Table -->
    <h2>Order has been placed Successfully</h2>
    <?php
    include "functions.php";
    session_start();
    echo "<h2>Your order contains:</h2>";
    $my_cart = $_SESSION['my_cart'];
    foreach ($my_cart as $menuItem) {
        echo "Restaurant Name: {$menuItem->r_name}, Restaurant Address: {$menuItem->address}, Menu Item Ordered: {$menuItem->mi_name} <br><br>";
    }

    echo "<h2>Your order number is: {$_SESSION['order_id']}</h2><br><br>";
    echo "<h2>Your customer number is: {$_SESSION['c_id']}</h2><br><br>";
    $total = round($_SESSION['total_price'] * 1.12, 2);
	echo "The subtotal is {$_SESSION['total_price']} Dollars, the total is {$total} dollars<br>";
	echo "Total Time: {$_SESSION['total_time']} Minutes<br>";
    ?>

    <p>Please keep this page available to pick up your order. You may need to show this to your
        delivery driver or the front counter for confirmation </p>

    <h3>Thank you for using FÜdy Eats!!! We welcome you to the FÜdy Family!!!</h3>

    <form action="project.php" method="POST">
        <input type="submit" value="Return Back To Landing Page">
    </form>

</body>

</html>