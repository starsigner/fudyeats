<html>

<head>
    <title>Restaurant Menu</title>
    <style>

        body {
            background: linear-gradient(45deg, #FC466B, #3F5EFB);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 100vmin;
            height: 100vmin;
            /* overflow: hidden; */
        }

        h1 {
            position: absolute;
            left: 40%;
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }

        .menu {
            position: absolute;
            left: 27%;
            top: 6%;
        }

        .order {
            position: absolute;
            left: 50%;
            top: 6%;
        }

        .coupon_title {
            position: absolute;
            left: 50%;
            bottom: 20%;
        }

        .analytics_title {
            position: absolute;
            left: 20%;
            bottom: 20%;
        }

        .restaurant_menu_items {
            background: rgba(255, 255, 255, 0.3);
            padding: 3em;
            height: 300px;
            width: 500px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: absolute;
            left: 7%;
            top: 17%;
            transition: all 0.2s ease-in-out;
        }

        .restaurant_add_menu_items {
            background: rgba(45deg, #FC466B, #3F5EFB);
            position: absolute;
            padding: 3em;
            left: 31%;
            top: 17%;
            height: 250px;
            width: 130px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
            color: #fff;
            opacity: 0.7;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-top: 0;
            margin-bottom: 60px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .order_panel {
            background: rgba(255, 255, 255, 0.3);
            padding: 3em;
            height: 300px;
            width: 500px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: absolute;
            left: 50%;
            top: 17%;
            transition: all 0.2s ease-in-out;
        }

        .coupon_panel {
            background: rgba(255, 255, 255, 0.3);
            padding: 3em;
            height: 50px;
            width: 250px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: top;
            position: absolute;
            left: 34%;
            bottom: 3%;
            transition: all 0.2s ease-in-out;
        }

        .add_coupon_panel {
            background: rgba(255, 255, 255, 0.3);
            padding: 3em;
            height: 50px;
            width: 300px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: top;
            position: absolute;
            left: 60%;
            bottom: 3%;
            transition: all 0.2s ease-in-out;
        }

        .statistics_panel {
            background: rgba(255, 255, 255, 0.3);
            padding: 3em;
            height: 50px;
            width: 300px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: top;
            position: absolute;
            left: 3%;
            bottom: 3%;
            transition: all 0.2s ease-in-out;
        }

        .deleteRestaurant {
            position: absolute;
            left: 80%;
            top: 10%;
        }

        tr:hover {
        background-color: #e6e6e6;
        color: black;
        border: 1px solid black;
        }

    </style>
</head>

<body>
    <h1>Restaurant Dashboard</h1>


    <!-- MENU TITLE -->
    <div class="Menu">
        <h1 id="Menu">Menu</h1>
    </div>

    <!-- MENU LIST -->
    <div id="restaurant_menu_list" class="restaurant_menu_items">
        <form method="POST" id="viewMenuItems">
            <input type="submit" value="View Menu" id="view" name = "view">
        </form>
        <?php
include 'functions.php';


// Retrieve login information 
$r_name = $_GET['r_name'];
$r_address = $_GET['address'];



// DASHBOARD ENABLED ONCE RESTAURANT LOGS IN
if (isset($_POST['view'])) {
    // display Menu Items 
    $result = displayMenuItems($r_name, $r_address);
    printTableBasic($result, ["Item Name", "Cook Time (mins)", "Price ($)"]);
}


?> 

        
        <!-- DELETE MENU ITEM -->
        <form method="POST" id="deleteItem" name="deleteItem">
                    <input type="text" id="delete_item_name" name="delete_item_name" value="Item Name" size="15">
                    <input type="submit" id="submit-button" name="submit-button" value="Delete Item">
            </form>

        <?php
            $r_name = $_GET['r_name'];
            $r_address = $_GET['address'];
            $item_name = $_POST['delete_item_name'];

            if (isset($_POST['delete_item_name'])) {
                        // Delete item 
                        $result = handleDeleteMenuItem($r_name, $r_address, $item_name);
                        if ($result == "exists") {
                        echo ("Item was deleted.");
                        }
                        else {
                        echo ("That is not a valid item. Please try again.");
                        }
                    }

        ?>
        
        
    </div>

    <div class="restaurant_add_menu_items">
        <form method="POST" id="addMenuItem" name="addMenuItem">
            <label for="item_name">Item Name*:</label><br>
            <input type="text" id="item_name" name="item_name" value="" size="15"><br><br>
            <label for="price">Price*:</label><br>
            <input type="text" id="price" name="price" value="" size="15"><br><br>
            <label for="cooking_time">Estimated Cooking Time (mins)*:</label><br>
            <select id="cooking_time" name="cooking_time"><br><br>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="60">60</option>
            </select><br><br>
            <input type="submit" id="submit-button" name="submit-button" value="Add Menu Item">
    </form>

    <?php

        $item_name = $_POST['item_name'];
        $cook_time = $_POST['cooking_time'];
        $price = $_POST['price'];
        $stripped_price = str_replace(".", "0", $price);

        if (isset($_POST['item_name']) && strlen($item_name) <= 20 && $item_name != "") {
            if (isset($_POST['price']) && ctype_digit($stripped_price)) {
                if (isset($_POST['cooking_time'])) {
                    // display Menu Items 
                    $result = handleCreateMenuItem($r_name, $r_address, $item_name, $cook_time, $price);
                    if ($result == "exists") {
                        echo ("Item already exists.");
                    }
                    else {
                    echo ("Item was added.");
                    }
                }
            }
            else if (isset($_POST['price'])) {
                echo ("Price must be numeric.");
            }
        }
        else if (isset($_POST['item_name']) && strlen($item_name) > 20) {
                echo ("Item name is too many characters.");
        }
        else if (isset($_POST['item_name']) && $item_name == "") {
                echo ("Item name is required.");
        }

?>

    </div>

     <!-- ORDER TITLE -->
     <div class="order">
        <h1 id="order">Orders</h1>
    </div>

     <!-- ORDER PANEL -->
    <div id="order_panel" class="order_panel">
        <form method="POST" id="viewDeliveryOrders">
            <input type="submit" value="View Delivery Orders" id="viewDeliveryOrders" name = "viewDeliveryOrders">
        </form>
        <form method="POST" id="viewPickUpOrders">
            <input type="submit" value="View Pickup Orders" id="viewPickupOrders" name = "viewPickupOrders">
        </form>
        <form method="POST" id="managePickupOrders">
            <input type="submit" value="Complete Order" id="managePickupOrders" name = "managePickupOrders">
            <input type="text" id="order_no" name="order_no" value="" size="5">
            <label for="order_no">num</label><br>
        </form>
        
        <?php

        // VIEW DELIVERY ORDERS 
        $r_name = $_GET['r_name'];
        $r_address = $_GET['address'];

        if (isset($_POST['viewDeliveryOrders'])) {
        $result = displayDeliveryOrders($r_name, $r_address);
        printTableBasic($result, ["Order Num", "Subtotal", "Total", "Status"]);
        }

        // VIEW PICKUP ORDERS
        if (isset($_POST['viewPickupOrders'])) {
            $result = displayPickupOrders($r_name, $r_address);
            printTableBasic($result, ["Order Num", "Subtotal", "Total", "Status"]);
            }

        $order_no = $_POST['order_no'];
        

        // MANAGE PICKUP ORDERS 
        if (isset($_POST['order_no']) && ctype_digit($order_no) && $order_no != "") {
              $result = setOrderComplete($order_no);  
              if ($result == "exists") {
              echo ("Order was updated");
              }
              else {
                  echo ("Invalid order.");
              }
            }
        else if (isset($_POST['order_no']) && $order_no == "") {
            echo("Input required.");
        }
        else if (isset($_POST['order_no'])) {
            echo("Order number must be numeric.");
        }
        ?>

<form method="POST" id="orderIssuesNotif">
            <p>Contact the customer about their order (ie. delays, updates, or no-show pickup)</p>
            <label for="orderIssuesNotif">Enter order num:</label><br>
            <input type="text" id="ordernumber" name="ordernumber" value="" size="5">
            <input type="submit" value="Get Contact Info" id="orderIssuesNotif" name = "orderIssuesNotif">
        </form>

        <?php

        $order_no = $_POST['ordernumber'];
        if (isset($_POST['ordernumber']) && ctype_digit($order_no)) {
            $result_contact = getContactInfo($order_no);
            printTableBasic($result_contact, ["Telephone", "Email"]);
            }
            else if (isset($_POST['ordernumber'])) {
                echo ("Order num must be numeric");
            }     

        ?>

    </div>

     <!-- COUPON HEADER -->
    <h1 class="coupon_title"> Coupons </h1>

    <!-- COUPON PANEL -->
    <div id="coupon_panel" class="coupon_panel">
        <form method="POST" id="viewCoupons">
            <input type="submit" value="View Coupons" id="coupon_offers" name = "coupon_offers">
        </form>

    <?php
    // VIEW COUPONS 
    $r_name = $_GET['r_name'];
    $r_address = $_GET['address'];

    if (isset($_POST['coupon_offers'])) {
        $result = displayCoupons($r_name, $r_address);
        printTableBasic($result, ["Coupon Id", "Value", "Valid Until"]);
        }        

    ?>

    </div>

          <!-- ADD COUPON PANEL -->
          <div id="add_coupon_panel" class="add_coupon_panel">
        <form method="POST" id="addCoupon">
            <label for="coupon_value">Value ($)*:</label>
            <input type="text" id="coupon_value" name="coupon_value" value="" size="4"><br>
            <label for="valid_until">Valid Until (YYYY-MM-DD) *:</label>
            <input type="text" id="valid_until" name="valid_until" value="" size="15"><br>
            <input type="submit" value="Add Coupon" id="add_coupon" name = "add_coupon">
        </form>

        <?php
            // VIEW COUPONS 
            $r_name = $_GET['r_name'];
            $r_address = $_GET['address'];
            $coupon_value = $_POST['coupon_value'];
            $valid_until = $_POST['valid_until'];


            if (isset($_POST['coupon_value']) && ctype_digit($coupon_value) && $coupon_value != "") {
                if (isset($_POST['valid_until']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $valid_until))
                 {
                    handleCreateCoupon($r_name, $r_address, $coupon_value, $valid_until);
                    echo ("Coupon created.");
                }
                else {
                    echo ("Invalid date format");
                }       
            }
            else if (isset($_POST['coupon_value']) && $coupon_value == "") {
                echo ("Please enter a coupon value.");
            } 
            else if (isset($_POST['coupon_value'])) {
                echo ("Value must be numeric.");
            }

    ?>
    </div>


    <!-- ANALYTICS HEADER -->
        <h1 class="analytics_title"> Your Analytics </h1>

     <!-- ANALYTICS SECTION -->
   <div id="statistics_panel" class="statistics_panel">
        <form method="POST" id="analytics">
        <input type="submit" name="analytics" value="View Breakdown and Statistics">
        </form>


        <?php
        // Get Analytics 
        $r_name = $_GET['r_name'];
        $r_address = $_GET['address'];


        if (isset($_POST['analytics'])) {
        

            $result_cook = getCookTimeWithLowPrice($r_name, $r_address); 

            echo($r_name . " is on track to hit record profits for the upcoming month."); 
            echo("Your rating and customer satisfaction has increased by 20%.<br>
            Typically, orders were placed with greatest frequency on Saturday evenings. 
            The <b>cook time</b> associated, on average, with the <b>lowest price</b> point is ");
            printResult($result_cook);
            echo(" mins");
        }

        ?>
    </div>

    <!-- DELETE RESTAURANT -->
    <div class="deleteRestaurant">
        <form method="POST" id="delete_restaurant">
        <input type="submit" name="delete_restaurant" value="Delete Account">
        </form>

    <?php 
     if (isset($_POST['delete_restaurant'])) {
        $r_name = $_GET['r_name'];
        $r_address = $_GET['address'];
         handleDeleteRestaurant($r_name, $r_address);
         echo ("Account deleted.");
    }
    ?>

</body>
</html>  