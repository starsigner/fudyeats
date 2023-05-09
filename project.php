<html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
        <style>
            body {
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                width: 100vmin;
                height: 100vmin;
                overflow: hidden;
                background-image: url('https://i1.wp.com/studiodiy.com/wp-content/uploads/2016/08/Brunch-Desktop-Wallpaper-Green.jpg');
            }
           
            h1 {
                color: black;
                background-color: #ADD8E6;  
                font-family: impact;
                position: relative;
                text-align: center;
                justify-items: center;
                margin: auto;
                padding-left: 65vmin;
                padding-right: 65vmin;
                /* padding-top: 15vmin; */
                width: 70%;  
            }
            p {
                color: black; 
                font-family: HYWenHei-85W, sans-serif;
                text-align: center;
            }
            .aligning {
                position: relative;
                text-align: center;
                justify-items: center;
                margin: auto;
                padding-left: 65vmin;
                padding-top: 5vmin;
                width: 70%;    
            }
            .portals {
              background: rgba(255, 255, 255, 0.3);
              padding: 3em;
              height: 320;
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
              width: 50%;
              margin: auto;
            }
            form input {
              background: white;
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
              color: black;
              font-family: HYWenHei-85W, sans-serif;
              font-weight: 500;
              transition: all 0.2s ease-in-out;
              text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            } 
            
            </style>
        
    </head>
    <body>

    <!-- LANDING PAGE -->

    <h1>Welcome to Fudy Eats!</h1>

    <!-- <form method="POST" action="project.php">
        <input type="hidden" id="login" name="login">
        <p><input type="submit" value="Login" name="login"></p>
    </form>

    <form method="POST" action="project.php">
        <input type="hidden" id="createAccountRequest" name="createAccountRequest">
        <p><input type="submit" value="Create Account" name="createAccountRequest"></p>
    </form> -->

    <div class="aligning">

        <div class="portals">
            <p>New to Fudy Eats? Click to join the Fudy Eats family now!</p>

            <!-- CUSTOMER PORTAL BUTTON -->

            <form method="POST" action="view_restaurant.php">
            <input type="hidden" id="goToCustomerPortal" name="goToCustomerPortal">
                <p><input type="submit" value="Customer" name="goToCustomerPortal"></p>
            </form>

            <!-- RESTAURANT PORTAL BUTTON -->

            <form method="POST" action="restaurant.php">
            <input type="hidden" id="goToRestaurantPortal" name="goToRestaurantPortal">
                <p><input type="submit" value="Restaurant" name="goToRestaurantPortal"></p>
            </form>

            <!-- DELIVERY DRIVER PORTAL BUTTON -->

            <form method="POST" action="driver.php">
            <input type="hidden" id="goToDriverPortal" name="goToDriverPortal">
                <p><input type="submit" value="Delivery Driver" name="goToDriverPortal"></p>
            </form>

            <!-- TESTING SELECTION AND COUNT *DELETE AFTER* -->
        
            <!-- <h2>Count Tuples in Restaurant1 Table</h2>
            <form method="GET" action="project.php">  
                <input type="hidden" id="countTupleRequest" name="countTupleRequest">
                <input type="submit" value="Restaurant1Count" name="countTuples"></p>
            </form>

            <h2>Select Names in Restaurant1 Table</h2>
            <form method="GET" action="project.php">  
                <input type="hidden" id="selectRestaurantRequest" name="selectRestaurantRequest">
                <input type="submit" value="Select Restaurants" name="selectRestaurant"></p>
            </form>

            <?php 
            include 'functions.php';
                        if (isset($_GET['selectRestaurantRequest'])) {
                        handleSelectRestaurant();
                    }
            ?> -->

        </div>
    </div>

</body>
</html>

