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
    <script>
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
    </script>
  </body>
</html>
