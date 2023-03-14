<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3aJ3UiAaO7r4NZjXH68_65yl_NPwmd8&libraries=places&callback=initAutoComplete"
      async
      defer
    ></script>
    <link href="./style.css" rel="stylesheet" />
    <title>Sign-Up</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-light bg-light navbar-expand-lg fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.php">SCS</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="true"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" aria-current="page" href="./index.php"
                >Home</a
              >
              <a class="nav-link" href="./about.html">About Us</a>
              <a class="nav-link" href="./contact.html">Contact Us</a>
              <a class="nav-link" href="./signup.php">Sign-up</a>
              <a class="nav-link" href="./signin.php">Sign-in/Logout</a>
              <a class="nav-link" href="#">Reviews</a>
              <a class="nav-link" href="./shopping.php">Shopping Cart</a>
              <a class="nav-link" href="./services.html" tabindex="-1"
                >Types of Services</a
              >
            </div>
          </div>
        </div>
      </nav>
    </header>


    <h1 class="display-6 pt-5 mt-5">Sign-Up</h1>
    <div class="container-fluid">
      <form name="signup"  method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" /><br />

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" /><br />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" /><br />
        <label for="tel">Telephone:</label>
        <input type="tel" id="tel" name="tel" /><br />

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" />
        <label for="postal">Postal Code:</label>
        <input type="text" id="postal" name="postal" /><br />

        <button name="action" action="signup.php" method="POST" value="signup">Sign Up</button>
      </form>
    </div>
    <?php
      if ($_POST['action']=="signup") {
        signup($_POST['username'], $_POST['password'], $_POST['name'], $_POST['tel'], $_POST['address'], $_POST['email'], $_POST['postal']);
      }

      function signup($username, $password, $name, $telephone, $address, $email, $postal) {
        $success = TRUE;
        $pattern = "/^[A-z0-9]+$/";
        if (!preg_match($pattern, $username)) {
          $success = FALSE;
          echo "<h1>Error: Username is invalid (Alphanumeric)</h1>";
        }
        $pattern = "/^[^\s]+$/";
        if (!preg_match($pattern, $password)) {
          $success = FALSE;
          echo "<h1>Error: Password is invalid. No spaces allowed</h1>";
        }

        $pattern = "/^[A-z]+[A-z ]+$/";
        if (!preg_match($pattern, $name)) {
          $success = FALSE;
          echo "<h1>Error: Name is invalid (Alphabet and spaces only)</h1>";
        }
        $pattern = "/^[A-z ]+$/";

        $pattern = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
        if (!preg_match($pattern, $telephone)) {
          $success = FALSE;
          echo "<h1>Error: Phone is invalid. Format: 123123-1234</h1>";
        }
        $pattern = "/^[#.0-9a-zA-Z\s,-]+$/";
        if (!preg_match($pattern, $address)) {
          $success = FALSE;
          echo "<h1>Error: Address is invalid. Format: Alphanumeric and spaces only</h1>";
        }
        $pattern = "/^[A-z0-9]+@[A-z0-9.]+$/";
        if (!preg_match($pattern, $email)) {
          $success = FALSE;
          echo "<h1>Error: Email is invalid. Format: abc123@123abc.com</h1>";
        }
        $pattern = "/^[A-z0-9]+$/";
        if (!preg_match($pattern, $postal)) {
          $success = FALSE;
          echo "<h1>Error: Email is invalid. Format: abc123@123abc.com</h1>";
        }



        if ($success==TRUE) {
          # sql stuff to add stuff
          $connect = mysqli_connect("127.0.0.1", "cps630", "cps630Password", "cps630") or die(mysql_error());            
          if($connect){
              print("Connection Established Successfully<br>");
          }else{
              print("Connection Failed <br>");
          }
          $sql = "INSERT INTO users (LoginId, Password, FullName, Email, Address, PostalCode, TelephoneNum)
          VALUES ('${username}', '${password}', '${name}', '${email}', '${address}', '${postal}', '${telephone}');";
          $result = mysqli_query($connect, $sql);

          header("Location: signin.php?signup=success");
          exit();
        }
        
      }

    ?>
  </body>
</html>
