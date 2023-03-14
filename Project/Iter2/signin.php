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
    <?php include 'header.php'?>
    <h1 class='display-6 pt-5 mt-5'>Sign-In</h1>
    <form method='POST'>
      <label for='username'>Username:</label>
      <input type='text' id='username' name='username' /><br />
      <label for='password'>Password:</label>
      <input type='password' id='password' name='password' />
      <button name='action' value='login' action='signin.php' method='POST'>Sign In</button>
    </form>
    <?php 
      include_once 'back/auth.php';
      $auth = new AuthenticationClass();

      # Sign up success
      if (isset($_GET['signup']) && $_GET['signup']=="success") {
        echo "<h1>You have successfully signed up. Please sign in.";
      }
      if (isset($_GET['action']) &&$_GET['action']=='logout')
      {
        $auth->logout();
      }

      if (isset($_POST['action'])) {
        if ($_POST['action']=='login'){
          if ($auth->login($_POST['username'], $_POST['password'])==TRUE)
          {
            echo "<h1>Logged in successfully. Redirecting to home</h1>";
            header("refresh:2; url=index.php");
          }
          else{
            echo "<h1>Bad Credentials</h1>";
          }
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
