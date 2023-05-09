<?php
// ADAPTED FROM oracle-test.php 

$success = True;
$db_conn = NULL;
$show_debug_alert_messages = False;

function debugAlertMessage($message)
{
    global $show_debug_alert_messages;

    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}

// ExecutePlainSQL 

function executePlainSQL($cmdstr)
{
    global $db_conn, $success;

    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement);
        echo htmlentities($e['message']);
        $success = False;
    }

    return $statement;
}

function executeBoundSQL($cmdstr, $list) {

    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            OCIBindByName($statement, $bind, $val);
            unset ($val);
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); 
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    }
}


// PrintResult Method 

function printResult($result)
{
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0];
    }
}

//Prints a Table given an array
function printTable($result, $header, $id){
    echo "<table id = '{$id}'>";
    echo '<thead><tr>';
    foreach ($header as $head) {
        echo '<th>'. $head . "</th>";
    }
    echo '</tr></thead>';
    echo '<tbody>';
    while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
        foreach ($row as $col) {
            $colName = $col;
            if ($col == null) {
                $colName = '&nbsp';
            }
            echo '<td style="text-align: center">'. $colName . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}

function printActiveOrders($result, $header){
    echo '<table id = "view_table">';
    echo '<thead><tr>';
    foreach ($header as $head) {
        echo '<th style="padding: 15px">'. $head . "</th>";
    }
    echo '</tr></thead>';
    echo '<tbody>';
    while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
        echo '<tr>';
        foreach ($row as $col) {
            $colName = $col;
            if ($col == null) {
                $colName = '&nbsp';
            }
            echo '<td style="text-align:center">'. $colName . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}


function printTableBasic($result, $header){
        echo '<table id = "view_table">';
        echo '<thead><tr>';
        foreach ($header as $head) {
            echo '<th>'. $head . "</th>";
        }
        echo '</tr></thead>';
        echo '<tbody>';
        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            foreach ($row as $col) {
                $colName = $col;
                if ($col == null) {
                    $colName = '&nbsp';
                }
                echo '<td style="text-align: center">'. $colName . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }


// Connect to Database 

function connectToDB()
{
    global $db_conn;

    $db_conn = OCILogon("ora_dharab", "a89810626", "dbhost.students.cs.ubc.ca:1522/stu");

    if ($db_conn) {
        debugAlertMessage("Database is Connected");
        return true;
    } else {
        debugAlertMessage("Cannot connect to Database");
        $e = OCI_Error();
        echo htmlentities($e['message']);
        return false;
    }
}

// Disconnect from Database 

function disconnectFromDB()
{
    global $db_conn;

    debugAlertMessage("Disconnect from Database");
    OCILogoff($db_conn);
}

// QUERY HANDLING 

function handleInsertRequest()
{ // inserting customers into table?? i'll figure this out tmrw
    global $db_conn;

    //Getting the values from user and insert data into the table
    $tuple = array(
        ":bind1" => $_POST['insNo'],
        ":bind2" => $_POST['insName']
    );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("insert into demoTable values (:bind1, :bind2)", $alltuples);
    OCICommit($db_conn);
}

function handleSelectRestaurant()
{
    if (connectToDB()) {
    global $db_conn;

    $result = executePlainSQL("SELECT * FROM Restaurant1");
    printResult($result);
    }

    disconnectFromDB();
}

function getContactInfo($order_num) {
    {
        if (connectToDB()) {
        global $db_conn;
    
        $result = executePlainSQL("SELECT c1.telephone, c1.email
        FROM Customer1 c1, Customer2 c2
        WHERE c1.customer_id = c2.customer_id
        AND c2.order_num = '$order_num'"
        );
        }
        disconnectFromDB();
        return $result;
    }

}


function getCookTimeWithLowPrice($r_name, $r_address) {
    
        if (connectToDB()) {
        global $db_conn;
        $tempStorage = "TempVariable";

        //Create variable to store Menu1 x Menu2 join 
        executePlainSQL("CREATE VIEW $tempStorage AS SELECT m1.item_name, m2.cooking_time, m1.price
        FROM MenuItem1 m1, MenuItem2 m2
        WHERE m1.r_name = '$r_name'
        AND m1.address = '$r_address'
        AND m1.r_name = m2.r_name 
        AND m1.address = m2.address
        AND m1.item_name = m2.item_name");


        $result = executePlainSQL("WITH temp AS (SELECT M.cooking_time, AVG (M.price) 
        AS avgPrice FROM $tempStorage M GROUP BY M.cooking_time)
        SELECT cooking_time, avgPrice FROM temp WHERE avgPrice = (SELECT MIN(avgPrice) from temp)");

        executePlainSQL("drop VIEW $tempStorage");

        }

        disconnectFromDB();
        return $result;
}

function handleCreateRestaurant($r_name, $r_type, $r_address) 
{
    if (connectToDB()) {
    global $db_conn; 

        $result = executePlainSQL("SELECT r_name FROM Restaurant1 WHERE r_name = '$r_name' AND address = '$r_address'");
        $row = OCI_Fetch_Array($result, OCI_BOTH);
        if ($row[0] != "") {
            $result = "exists";
        }
        else {
        $result = "not exists";
        $tuple = array(
            ":bind1" => $r_name,
            ":bind2" => $r_type,
            ":bind3"  => $r_address,
            ":bind4" => rand(1, 5)
        );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("insert into Restaurant1 values (:bind1, :bind2, :bind3)", $alltuples);
    executeBoundSQL("insert into Restaurant2 values (:bind1, :bind3, :bind4)", $alltuples);
    OCICommit($db_conn);
        }
        return $result;
        }

        }

function handleCreateCoupon($r_name, $r_address, $coupon_value, $valid_until) 
{


    if (connectToDB()) {
    global $db_conn; 
    $tuple = array(
        ":bind1" => rand(1, 100000),
        ":bind2" => $coupon_value,
        ":bind3"  => $valid_until,
        ":bind5" => $r_name,
        ":bind6" => $r_address
    );

    $alltuples = array(
        $tuple
    ); 

    executeBoundSQL("insert into Coupon2 values (:bind1, :bind2, :bind3, :bind5, :bind6)", $alltuples);
    OCICommit($db_conn);
}
}

function setOrderComplete($order_num) {
    if (connectToDB()) {
        global $db_conn; 
    
        $result = executePlainSQL("SELECT order_num FROM Pickup WHERE order_num = $order_num");
        $row = OCI_Fetch_Array($result, OCI_BOTH);
        if ($row[0] != "") {
            $result = "exists";
        }
        else {
        $result = "not exists";
        executePlainSQL("UPDATE Order2 SET order_status = 'completed' WHERE order_num = '$order_num'");
    
        OCICommit($db_conn);
    }
        return $result;
}
}

function handleCreateMenuItem($r_name, $r_address, $item_name, $cooking_time, $price) 
{
    if (connectToDB()) {
    global $db_conn; 

    $result = executePlainSQL("SELECT item_name FROM MenuItem1 WHERE r_name = '$r_name' AND address = '$r_address' AND item_name = '$item_name'");
    $row = OCI_Fetch_Array($result, OCI_BOTH);
    if ($row[0] != "") {
        $result = "exists";
    }
    else {
    $result = "not exists";
    $tuple = array(
        ":bind1" => $r_name,
        ":bind2" => $r_address,
        ":bind3"  => $item_name,
        ":bind4" => $cooking_time,
        ":bind5" => $price
    );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("insert into MenuItem1 values (:bind1, :bind2, :bind3, :bind5)", $alltuples);
    executeBoundSQL("insert into MenuItem2 values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
    OCICommit($db_conn);
}
return $result;
}
}

function handleDeleteMenuItem($r_name, $r_address, $item_name)
{
    if (connectToDB()) {
    global $db_conn; 

    $result = executePlainSQL("SELECT item_name FROM MenuItem1 WHERE r_name = '$r_name' AND address = '$r_address' AND item_name = '$item_name'");
    $row = OCI_Fetch_Array($result, OCI_BOTH);
    if ($row[0] != "") {
        $result = "exists";
    }
    else {
    $result = "not exists";
    
    executePlainSQL("DELETE FROM MenuItem1 WHERE r_name = '$r_name' AND address = '$r_address' AND item_name = '$item_name'");
    executePlainSQL("DELETE FROM MenuItem2 WHERE r_name = '$r_name' AND address = '$r_address' AND item_name = '$item_name'");

    OCICommit($db_conn);
}

return $result;

}
}

function handleDeleteRestaurant($r_name, $r_address)
{
    if (connectToDB()) {
    global $db_conn; 

    executePlainSQL("DELETE FROM Restaurant1 WHERE r_name = '$r_name' AND address = '$r_address'");
    executePlainSQL("DELETE FROM Restaurant2 WHERE r_name = '$r_name' AND address = '$r_address'");

    OCICommit($db_conn);
}

}

function displayMenuItems($r_name, $r_address) {
    if (connectToDB()) {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Restaurant1 WHERE EXISTS (SELECT * FROM Restaurant1 WHERE r_name = '$r_name' AND address = '$r_address')");
        $row = OCI_Fetch_Array($result, OCI_BOTH);
        if ($row == NULL) {
            $result = 1;
        }
        else {
        $result = executePlainSQL("SELECT m1.item_name, m2.cooking_time, m1.price
        FROM MenuItem1 m1, MenuItem2 m2
        WHERE m1.r_name = '$r_name'
        AND m1.address = '$r_address'
        AND m1.r_name = m2.r_name 
        AND m1.address = m2.address
        AND m1.item_name = m2.item_name"
        );
        }
    }
        disconnectFromDB();
        return $result;
}

function displayCoupons($r_name, $r_address) {
    if (connectToDB()) {
        global $db_conn;
        
        $result = executePlainSQL("SELECT coupon_id, value, valid_until FROM Coupon2 WHERE r_name = '$r_name' AND address = '$r_address'");
    }
        disconnectFromDB();
        return $result;
}


function displayDeliveryOrders($r_name, $r_address) {
    if (connectToDB()) {
        global $db_conn;

        $result = executePlainSQL("SELECT o1.order_num, o1.order_subtotal, o1.order_total, o2.order_status
        FROM Order1 o1, Order2 o2, Delivery d
        WHERE o2.r_name = '$r_name'
        AND o2.address = '$r_address'
        AND o1.order_num = o2.order_num
        AND o1.order_num = d.order_num
        AND o2.order_status = 'in progress'"
        );
        }
        disconnectFromDB();
        return $result;
}

function displayPickupOrders($r_name, $r_address) {
    if (connectToDB()) {
        global $db_conn;

        $result = executePlainSQL("SELECT o1.order_num, o1.order_subtotal, o1.order_total, o2.order_status
        FROM Order1 o1, Order2 o2, Pickup p
        WHERE o2.r_name = '$r_name'
        AND o2.address = '$r_address'
        AND o1.order_num = o2.order_num
        AND o1.order_num = p.order_num
        AND o2.order_status = 'in progress'"
        );
        }
        disconnectFromDB();
        return $result;
}


function handleCreateDriver($d_id, $d_name, $d_telephone, $d_employer, $e_location) 
{
    if (connectToDB()) {
    global $db_conn; 

    $tuple = array(
        ":bind1" => $d_id,
        ":bind2" => $d_name,
        ":bind3" => $d_telephone,
        ":bind4" => rand(1, 5),
        ":bind5" => $d_employer,
        ":bind6" => $e_location
    );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("insert into DeliveryDriver1 values (:bind1, :bind2, :bind3)", $alltuples);
    executeBoundSQL("insert into DeliveryDriver2 values (:bind1, :bind4, :bind5, :bind6)", $alltuples);
    OCICommit($db_conn);    
    }
}

// displays all active orders in a list
function handleSelectOrders() {
    if (connectToDB()) {
        global $db_conn;

        $query = executePlainSQL("SELECT o.order_num, order_status, r_name, address 
        FROM Order2 o, Delivery d
        WHERE o.order_num = d.order_num 
        AND order_status='in progress'");

        printActiveOrders($query, ["Order Number", "Status", "Restauarant", "Address"]);

        oci_free_statement($query);
        OCICommit($db_conn);
    }
}

function printInfo($data, $columns = []) {
    if (count($columns) > 0) {
        // Print the column names
        echo '<table><tr>';
        foreach ($columns as $column) {
            echo '<th>' . htmlspecialchars($column) . '</th>';
        }
        echo '</tr>';
    }
    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $column) {
            echo '<td>' . htmlspecialchars($column)  . '<br>' . '</td>';
        }
        echo '</tr>';
    }
    
    if (count($columns) > 0) {
        echo '</table>';
    }
}

?>