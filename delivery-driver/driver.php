<html>
    <head>
        <title>Delivery Driver</title>
        <style>
            body {
              background: linear-gradient(45deg, #FC466B, #3F5EFB);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                width: 100vmin;
                height: 100vmin;
                overflow: scroll;
            
            }
            h1   {color: black; 
                  font-family: impact; 
                  text-align: center;
                  position: relative;
                  justify-items: center;
                  margin: auto;
                  padding-left: 65vmin;
                  /* padding-top: 15vmin; */
                  width: 50%;   
                }
                
            h2   {
                  color: black; 
                  font-family: impact
                }
            p    {color: red;}

            .register_driver {
                position: relative;
                text-align: center;
                justify-items: center;
                margin: auto;
                padding-left: 65vmin;
                padding-top: 5vmin;
                width: 50%;    
            }

            form {
              background: rgba(255, 255, 255, 0.3);
              padding: 3em;
              height: 470px;
              border-radius: 20px;
              border-left: 1px solid rgba(255, 255, 255, 0.3);
              border-top: 1px solid rgba(255, 255, 255, 0.3);
              -webkit-backdrop-filter: blur(10px);
                      backdrop-filter: blur(10px);
              box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
              text-align: center;
              position: relative;
              transition: all 0.2s ease-in-out;
              font-family: arial
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

     <!-- Register Driver Details -->
     <!-- Backend: Insert Driver into Driver1 Table -->
     <h1>Welcome to the Delivery Driver Portal!</h1>

     <div class="register_driver">
        <h2> Register for an Account </h2>
        <form method="POST" id="register" name="register" action="driver.php">
            <label for="d_id">Driver ID:</label><br>
            <input type="text" id="d_id" name="d_id" value="" required><br>
            <label for="d_name">Name:</label><br>
            <input type="text" id="d_name" name="d_name" value=""><br>
            <label for="d_telephone">Telephone:</label><br>
            <input type="text" id="d_telephone" name="d_telephone" value=""><br>
            <label for="d_employer">Employer:</label><br>
            <input type="text" id="d_employer" name="d_employer" value=""><br>
            <label for="location">Employer Address:</label><br>
            <input type="text" id="location" name="location" value=""><br>
            <!-- <label for="employer">Employer:</label><br> -->
            <!-- <select id="employer" name="employer"><br><br>
              <option style="text-align: center" value="null">--</option>
                <option value="uber">Uber</option>
                <option value="door_dash">Door Dash</option>
                <option value="skip_the_dishes">Skip the Dishes</option>
            </select><br><br> -->
            <input type="submit" value="Submit">
        </form> 

      <?php
        ob_start();
        include 'functions.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $d_id = $_POST["d_id"];
          $d_name = $_POST["d_name"]; 
          $d_telephone = $_POST["d_telephone"];
          $d_employer = $_POST["d_employer"];
          $e_location = $_POST["location"];
        
          if (isset($_POST['d_id']) && $d_id != "") {
            handleCreateDriver($d_id, $d_name, $d_telephone, $d_employer, $e_location);
          }
          header("Location: viewActiveOrders.php?option=$d_id");
          exit();
        }
      ?>
    </div>

    </body> 
</html>
