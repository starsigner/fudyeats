<html>
    <head>
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
            h1, h2  {color: black; font-family: impact;}
            p    {color: black; font-family: arial;}
            .order {
                position: relative;
                text-align: center;
                justify-items: center;
                margin: auto;
                padding-left: 65vmin;
                padding-top: 15vmin;
                width: 80%;  
                font-family: arial;  
            }
            
            form input[type=submit] {
              background: transparent;
              width: 200px;
              padding: 1em;
              margin-bottom: 2em;
              margin-top: 2em;
              border: none;
              border-left: 1px solid rgba(255, 255, 255, 0.3);
              border-top: 1px solid rgba(255, 255, 255, 0.3);
              border-radius: 5000px;
              -webkit-backdrop-filter: blur(5px);
              backdrop-filter: blur(5px);
              box-shadow: 4px 4px 60px rgba(0, 0, 0, 0.2);
              color: #fff;
              font-family: Montserrat, sans-serif;
              font-weight: 500;
              transition: all 0.2s ease-in-out;
              text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            } 
            .details  {
              background: rgba(255, 255, 255, 0.3);
              padding: 3em;
              height: 320px;
              border-radius: 20px;
              border-left: 1px solid rgba(255, 255, 255, 0.3);
              border-top: 1px solid rgba(255, 255, 255, 0.3);
              -webkit-backdrop-filter: blur(10px);
                      backdrop-filter: blur(10px);
              box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
              text-align: center;
              position: relative;
              transition: all 0.2s ease-in-out;
              font-family: arial;
            }

            
            
        </style>
</head>
<body>

  <div class="order">

    <h1>My Orders:</h1>
        <!-- <p>Upon successful delivery, mark it as "complete".</p>  -->

    <?php
      $selected_option = $_GET["option"];
      echo "You selected order no: $selected_option";
    ?>
    <h2>Order details:</h2>

    <div class="details">

    <?php
      include 'functions.php';
      
      if(connectToDB()) {
        $result = executePlainSQL("SELECT order_num, order_status, r_name, address 
        FROM Order2 WHERE order_num='$selected_option'");
        printActiveOrders($result, ["Order Number", "Order Status", " Restaurant", "Address"]);

      }
    ?>

    <p>Upon successful delivery, please mark "complete" and click submit to update the order's status:</p>
    <form action="" method="post">
    <input type="radio" id="complete" name="selected_option" value="">
    <label style="font-family: arial" for="complete">Complete</label><br>
    <input type="hidden" name="selected_option" value="">
    <input type="submit" id="complete" name="submit" value="Submit">
    </form>

    <?php
      ob_start();
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // $selected_option = $_POST["selected_option"];
        // header("Location: driversAssignedOrder.php?option=$selected_option");

        if(connectToDB()) {
          global $db_conn;

          $query = "UPDATE Order2 SET order_status = 'completed' WHERE order_num = :selected_option";
          $stmt = oci_parse($db_conn, $query);
          oci_bind_by_name($stmt, ':selected_option', $selected_option);
          $result = oci_execute($stmt);

          if ($result) {
            echo "Order status updated successfully!";
          } else {
            echo "Error updating order status!";
          }

        }
        header("Location: viewActiveOrders.php");
        ob_end_clean();
        exit;
      }
    ?>
    
    </div>

    
  <div>

</body>

</html>