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
    <link href="./style.css" rel="stylesheet" />
    <title>SCS Home</title>
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
    <?php
      include 'database.php';
      if (isset($_GET['signup']) && $_GET['signup']=="success") {
        echo "<h1>You have successfully signed up. Please sign in.";
      }
      if (!isset($_COOKIE['userid'])) { #if not logged in
        echo"<h1 class='display-6 pt-5 mt-5'>Sign-In</h1>
        <form method='POST'>
          <label for='username'>Username:</label>
          <input type='text' id='username' name='username' /><br />
          <label for='password'>Password:</label>
          <input type='password' id='password' name='password' />
          <button name='action' value='login' action='signin.php' method='POST' />Sign In</button>
        </form>";
      }
      else {
        echo "<form method='POST' class='py-5 my-5'>
        <button name='action' value='logout' action='signin.php' method='POST' />Log Out</button>
        </form>";
      }
      if (isset($_POST['action'])) {
        $db_instance = new DatabaseClass("127.0.0.1", "cps630", "cps630Password", "cps630");
        if ($_POST['action']=='login'){

          $pattern = "/^[A-z0-9]+$/";
          # Check inputs
          if (!preg_match($pattern, $_POST['username'])) {
            $success = FALSE;
            echo "<h1>Wrong Username</h1>";
          }
          $pattern = "/^[^\s]+$/";
          if (!preg_match($pattern, $_POST['password'])) {
            $success = FALSE;
            echo "<h1>Wrong Password</h1>";
          }

          # Check credentials
          $result = $db_instance->execute_query("SELECT Password FROM users
                                                WHERE LoginId = '".$_POST['username']."';");
          $row = $db_instance->return_first_row($result);
          if ($row > 0) {
            if ($row["Password"]==$_POST['password'])
            {
              echo "<h1>Logged in successfully. Redirecting to home</h1>";
              header("refresh:2; url=index.php");
              setcookie('userid', $_POST['username']);
            }
            else {
              echo "<h1>Wrong Password</h1>";
            }
          }
          else{
            echo "<h1>Wrong Username</h1>";
          }
        }
        if ($_POST['action']=='logout')
        {
          unset($_COOKIE['userid']);
          setcookie('userid', '', time() - 3600, '/'); // empty value and old timestamp
          header("refresh:0;");
        }
      }
    ?>




    <!-- <script>
      function login() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        usersString = sessionStorage.getItem("userData");
        if (usersString) {
          var found = false;
          users = JSON.parse(usersString);
          for (let i = 0; i < users.length; i++) {
            if (users[i].email == email && users[i].password == password) {
              found = true;
              sessionStorage.setItem("currentUser", email);
              alert("logged in Successfully");
              console.log(sessionStorage.getItem("currentUser"));
              window.location.href = "./index.php";
              break;
            }
          }

          if (!found) {
            alert("Email or Password incorrect.");
            console.log(users);
          }
        } else {
          alert("Email or Password incorrect.");
        }
      }

      function logout() {
        sessionStorage.removeItem("currentUser");
        console.log(sessionStorage.getItem("currentUser"));
        alert("Logged out Successfully.");
        window.location.href = "./index.php";
      }

      if (sessionStorage.getItem("currentUser")) {
        document.write(
          "<form class='py-5 my-5'><input type='button' value='Logout' onclick='logout()' /></form>"
        );
      } else {
        document.write(
          "<h1 class='display-6 pt-5 mt-5'>Sign-In</h1><form><label for='email'>Email:</label><input type='email' id='email' name='email' /><br /><label for='password'>Password:</label><input type='password' id='password' name='password' /><input type='button' value='Submit' onclick='login()' /></form>"
        );
      }
    </script> -->
    
  </body>
</html>
