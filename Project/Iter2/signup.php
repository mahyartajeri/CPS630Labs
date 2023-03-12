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
          <a class="navbar-brand" href="./index.html">SCS</a>
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
              <a class="nav-link" aria-current="page" href="./index.html"
                >Home</a
              >
              <a class="nav-link" href="./about.html">About Us</a>
              <a class="nav-link" href="./contact.html">Contact Us</a>
              <a class="nav-link" href="./signup.html">Sign-up</a>
              <a class="nav-link" href="./signin.html">Sign-in/Logout</a>
              <a class="nav-link" href="#">Reviews</a>
              <a class="nav-link" href="./shopping.html">Shopping Cart</a>
              <a class="nav-link" href="./services.html" tabindex="-1"
                >Types of Services</a
              >
            </div>
          </div>
        </div>
      </nav>
    </header>

    <script>
      function storeData() {
        // Get form values
        var name = document.getElementById("name").value;
        var tel = document.getElementById("tel").value;
        var address = document.getElementById("address").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        // Create object with form values
        var userData = {
          name: name,
          tel: tel,
          address: address,
          email: email,
          password: password,
        };

        // Store object in sessionStorage
        if (sessionStorage.getItem("userData")) {
          /*console.log(
            "filtered: ",
            JSON.parse(sessionStorage.getItem("userData")).filter(
              (user) => user.email != userData.email
            ).length,
            "original: ",
            JSON.parse(sessionStorage.getItem("userData")).length
          );*/
          if (
            JSON.parse(sessionStorage.getItem("userData")).filter(
              (user) => user.email != userData.email
            ).length == JSON.parse(sessionStorage.getItem("userData")).length
          ) {
            sessionStorage.setItem(
              "userData",
              JSON.stringify([
                ...JSON.parse(sessionStorage.getItem("userData")),
                userData,
              ])
            );
            alert("Account successfully created.");
            window.location.href = "index.html";
          } else {
            alert("An account with this email already exists!");
          }
        } else {
          sessionStorage.setItem("userData", JSON.stringify([userData]));
          alert("Account successfully created.");
          window.location.href = "index.html";
        }

        console.log(sessionStorage.getItem("userData"));
      }

      function initAutoComplete() {
        var auto = new google.maps.places.Autocomplete(
          document.getElementById("address"),
          {
            types: ["address"],
          }
        );

        auto.addListener("place_changed", function () {
          // does nothing for now
          var place = auto.getPlace();
        });
      }
    </script>

    <h1 class="display-6 pt-5 mt-5">Sign-Up</h1>
    <div class="container-fluid">
      <form>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" /><br />

        <label for="tel">Telephone:</label>
        <input type="tel" id="tel" name="tel" /><br />

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" /><br />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" /><br />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" />

        <input type="button" value="Submit" onclick="storeData()" />
      </form>
    </div>
  </body>
</html>
