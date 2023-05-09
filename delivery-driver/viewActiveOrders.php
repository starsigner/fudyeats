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
            h1   {color: black; font-family: impact;}
            p    {color: black; font-family: arial;}
            .order {
                position: relative;
                text-align: center;
                justify-items: center;
                margin: auto;
                padding-left: 65vmin;
                padding-top: 15vmin;
                width: 80%;    
            }
            form {
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
              word-spacing: 2px;
            }
            form p {
              font-weight: 500;
              color: #fff;
              opacity: 0.7;
              font-size: 1.4rem;
              margin-top: 0;
              margin-bottom: 60px;
              text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            }
            form a {
              text-decoration: none;
              color: #ddd;
              font-size: 12px;
            }
            form a:hover {
              text-shadow: 2px 2px 6px #00000040;
            }
            form a:active {
              text-shadow: none;
            }
            form input {
              background: transparent;
              width: 200px;
              padding: 1em;
              margin-bottom: 2em;
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
        </style>
</head>
<body>

  <div class="order">
    <h1>Welcome, Delivery Driver!</h1>
    <p>Please select an order to deliver. Upon successful delivery, mark it as "complete".</p> 

    <form action="viewActiveOrders.php" method="post">
      <!-- <label for="orders">Select an order:</label> -->
        <?php 
        ob_start();
        include 'functions.php'; 
        handleSelectOrders();
        ?>
      <label for="orders">Please enter an order number:</label>
      <input type="text" id="order" name="selected_option" value="">
      <input type="submit" id="order" name="submit" value="Submit">
	  </form>

    <form method="POST" action="checkInfo.php">
       <h1>View Available Drivers</h1>
        <p>Click to be redirected.</p> 
        <input type="hidden" id="checkinforeq" name="checkinforeq">
        <p><input type="submit" value="View Available Drivers" name="checkinforeq"></p>
    </form> 

    <?php
      ob_start();
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_option = $_POST["selected_option"];
        header("Location: driversAssignedOrder.php?option=$selected_option");
        ob_end_clean();
        exit;
      }
    ?>

  </div>
</body>

</html>