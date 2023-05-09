<html>

<head>
  <title>Restaurant</title>
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

    h3 {
      color: black;
    }

    p {
      color: red;
    }

    .register_restaurant {
      position: relative;
      text-align: center;
      justify-items: center;
      margin: auto;
      padding-left: 65vmin;
      padding-top: 15vmin;
      width: 50%;
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

  <!-- Register Restaurant Details -->

  <div class="register_restaurant">
    <h3> Register </h3>
    <form method="POST" id="Register">
      <label for="r_name">Restaurant Name*:</label><br>
      <input type="text" id="r_name" name="r_name" value=""><br><br>
      <label for="type">Type:</label><br>
      <select id="type" name="type"><br><br>
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
      <label for="address">Address*:</label><br>
      <input type="address" id="address" name="address" value=""><br><br>
      <input type="submit" value="Submit">
    </form>

    <?php include 'functions.php';

// call CreateRestaurant with user input and error handling 

$r_name = $_POST["r_name"];
$r_type = $_POST["type"];
$address = $_POST["address"];

if (isset($_POST['r_name']) && $r_name != "" && strlen($r_name) <= 20) {
  if (isset($_POST['address']) && $address != "" && strlen($address) <= 20) {
    $result = handleCreateRestaurant($r_name, $r_type, $address);
    if ($result == "exists") {
      echo ("You already have an account. Logging you in...");
      header("Refresh: 2; restaurantMenu.php?r_name=$r_name&address=$address");
      exit; 
    }
    else  {
    echo ("Account created! You will be redirected to your dashboard in just few moments.");
    header("Refresh: 2; restaurantMenu.php?r_name=$r_name&address=$address");
    exit;
    }
    }
   else if (isset($_POST['address']) && $address == "") {
    echo ("Address is required");
  }
  else if (isset($_POST['address'])) {
    echo ("Address name is too long");
  }
} else if (isset($_POST['r_name']) && $r_name == "") {
  echo ("Restaurant name is required");
}
else if (isset($_POST['r_name'])) {
  echo ("Restaurant name is too long");
}



?>
  </div>



</body>

</html>