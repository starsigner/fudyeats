<html>

<head>
    <title>View Menu</title>
    <style>
        <?php include 'project.css'; ?>
    </style>
</head>

<body>
    <h1>FÜdy Eats</h1>
    <h2>Available Menu Item in Restaurant</h2>

    <?php
    include 'functions.php';
    session_start();
    $r_name = $_SESSION['r_name'];
    $address = $_SESSION['r_address'];

    if (connectToDB()) {
        $result = executePlainSQL("SELECT DISTINCT m1.item_name, m2.cooking_time, m1.price
        FROM MenuItem1 m1, MenuItem2 m2
        WHERE m1.r_name = '{$r_name}'
        AND m1.address = '{$address}'
        AND m1.r_name = m2.r_name 
        AND m1.address = m2.address
        AND m1.item_name = m2.item_name
        ORDER BY m1.price");
        printTable($result, ["Item Name", "Cooking Time", "Price"], "view_menu");
    }

    disconnectFromDB();
    ?>

    <form method="POST" action="view_menu.php">
        <h2>Add MenuItems to Order (Click on Menu Item Rows to AutoFill)</h2>
        <label for="mi_name">Menu Item Name: </label>
        <input type="text" id="mi_name" name="mi_name" readonly>
        <br>
        <label for="mi_time">Time: </label>
        <input type="text" id="mi_time" name="mi_time" readonly>
        <br>
        <label for="mi_price">Price: </label>
        <input type="text" id="mi_price" name="mi_price" readonly>
        <br>
        <input type="hidden" id="add_menu_request" name="add_menu_request">
        <input type="submit" value="Add Menu Item to Order" name="viewMenu">
    </form>

    <h2>My Cart</h2>
    <?php
    session_start();
    $mi_name = $_POST['mi_name'];
    $mi_time = $_POST['mi_time'];
    $mi_price = $_POST['mi_price'];
    if (!isset($_SESSION['total_price'])) {
        $_SESSION['total_price'] = 0;
        $_SESSION['total_time'] = 0;
        echo "Total Cost: {$_SESSION['total_price']} Dollars<br>";
        echo "Total Time: {$_SESSION['total_time']} Minutes<br>";
    }
    if (!isset($_SESSION['my_cart'])) {
        $_SESSION['my_cart'] = array();
        echo "Cart Is Empty <br><br><br>";
    } else if (isset($_POST['add_menu_request'])) {
        if ($mi_name != '') {
            handleAddCartListener($mi_name, $mi_price, $mi_time);
            foreach ($_SESSION['my_cart'] as $menuItem) {
                echo "Restaurant Name: {$menuItem->r_name}, Restaurant Address: {$menuItem->address}, Menu Item Ordered: {$menuItem->mi_name} <br>";
            }
            echo "Total Cost: {$_SESSION['total_price']} Dollars<br>";
            echo "Total Time: {$_SESSION['total_time']} Minutes<br>";
        } else {
            echo "<p>Please select a menu item from the table above</p><br>";
        }

    } else if (isset($_POST['delete_cart'])) {
        unset($_SESSION['my_cart']);
        $_SESSION['total_price'] = 0;
        $_SESSION['total_time'] = 0;
        echo "Cart has been deleted <br>";
    }

    function handleAddCartListener($mi_name, $mi_price, $mi_time)
    {
        $newCartObject = (object) [
            'r_name' => $_SESSION['r_name'],
            'address' => $_SESSION['r_address'],
            'mi_name' => $mi_name
        ];
        if (!in_array($newCartObject, $_SESSION['my_cart'])) {
            $_SESSION['my_cart'][] = $newCartObject;
            $_SESSION['total_price'] += $mi_price;
            $_SESSION['total_time'] += $mi_time;
            echo "Added {$_SESSION['r_name']}, {$_SESSION['r_address']}, {$mi_name} <br><br>";
        } else {
            echo "<p>The item has already been added to the list</p><br><br>";
        }
    }
    ?>
    <form method="POST" action="view_menu.php">
        <input type="hidden" id="delete_cart" name="delete_cart">
        <p><input type="submit" value="Clear the Cart" name="delete_cart"></p>
    </form>
    <form method="POST" action="createAccount.php">
        <input type="hidden" id="makeOrder" name="makeOrder">
        <p><input type="submit" value="Make the Order" name="makeOrder"></p>
    </form>

    <script>
        var menuTable = document.getElementById("view_menu");
        menuTable.addEventListener("click", (event) => {
            if (event.target.tagName === "TD") {
                var rowParent = event.target.parentNode;
                var rowData0 = rowParent.cells[0].textContent;
                var rowData1 = rowParent.cells[1].textContent;
                var rowData2 = rowParent.cells[2].textContent;
                document.getElementById("mi_name").value = rowData0;
                document.getElementById("mi_time").value = rowData1;
                document.getElementById("mi_price").value = rowData2;
            }
        });
    </script>
</body>


</html>