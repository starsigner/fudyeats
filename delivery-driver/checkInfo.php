<html>
    <header>
        <style>
            body {
              background: linear-gradient(45deg, #FC466B, #3F5EFB);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                width: 100vmin;
                height: 100vmin;
                overflow: hidden;
            }
            h1   {color: black; font-family: impact;}
            p    {color: black; font-family: arial;}
    
            
            </style>
</header>
<body>

<!-- <div class="info"> -->
<h1>Check Active Delivery Driver's information:</h1>
<p>Please select one or more boxes to display their respective information.</p>

<form action="checkInfo.php" method="post">
  <!-- <input type="checkbox" id="name" name='info[]' value="driver_name">Name</br> -->
  <input type="checkbox" id="id" name='info[]' value="driver_id">ID</br>
  <!-- <input type="checkbox" id="telephone" name='info[]' value="telephone">Telephone</br> -->
  <input type="checkbox" id="rating" name='info[]' value="rating">Rating</br>
  <input type="checkbox" id="employer" name='info[]' value="employer_name">Employer</br>
  <input type="checkbox" id="location" name='info[]' value="employer_location">Employer Address<br></br>
  <input type="submit" value="Submit" name="submit">
</form>

<!-- <form method="POST" action="viewActiveOrders.php">
        <input type="hidden" id="backreq" name="backreq">
        <p><input type="submit" value="Back to Orders" name="backreq"></p>
</form>  -->

<?php
    include 'functions.php';

    if(connectToDB()) {
        global $db_conn;
        if(isset($_POST['submit'])){
            if(!empty($_POST['info'])) {
                foreach($_POST['info'] as $value){
                    // echo "Chosen info: ".$value.'<br/>';
                    $query = "SELECT $value FROM DeliveryDriver2";
                    $stid = oci_parse($db_conn, $query);
                    oci_execute($stid);

                    $num_cols = oci_num_fields($stid);
                    $column_names = [];
                    for ($i = 1; $i <= $num_cols; $i++) {
                    $column_names[] = oci_field_name($stid, $i);
                    }
                    printInfo([], $column_names);

                    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
                        printInfo([$row]);
                    }
    
                }
                oci_free_statement($stid);
                oci_close($db_conn);
            }
        }
    }
?>

<!-- </div> -->

</body>
    </html>
