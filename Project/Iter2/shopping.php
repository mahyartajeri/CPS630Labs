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
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3aJ3UiAaO7r4NZjXH68_65yl_NPwmd8&libraries=places&callback=initMap"
      async
      defer
    ></script>
    <link href="./style.css" rel="stylesheet" />
    <title>Shopping Cart</title>
  </head>
  <body>
    <?php include 'header.php'?>

    <div class="container-fluid my-5 py-5">
      <div class="row">
        <label for="shopping-cart">Shopping Cart</label>
        <div class="col-md-12">
          <ul class="list-group" id="shopping-cart"></ul>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h1 class="display-6">Order Summary</h1>
          <ul class="list-group" id="shopping-cart">
            <li class="list-group-item">
              Total Cost:
              <span id="total">$0</span>
            </li>
          </ul>
          <?php 
            // include_once("back/auth.php");
            // $auth = new AuthenticationClass();
            // if $auth->authenticated();
              # buy is allowed
            //   <button id="order" action="shopping.php" method="POST">Purchase</button> 
            // else 
            //   button sends to sign in page



            // if post
            //   $auth->get_user_id()
              # add user id and shopping cart to db orders table
          ?>
          <p id="login-message">You must Login to order.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="map-holder">
          <p id="x"></p>
          <div id="map">hi</div>
        </div>
      </div>
    </div>

    <script>
      let x = document.getElementById("x"); // For Error Messages.
      function initMap() {
        navigator.geolocation.watchPosition(function (position) {
          let location = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          let location2 = {
            lat: position.coords.latitude + 0.1,
            lng: position.coords.longitude + 0.2,
          };
          let map = new google.maps.Map(document.getElementById("map"), {
            center: location,
            zoom: 15,
          });
          /*
          let marker = new google.maps.Marker({
            position: location,
            map: map,
          });
          
          let marker2 = new google.maps.Marker({
            position: location2,
            map: map,
          });
          
          let geocoder = new google.maps.Geocoder();

          geocoder.geocode({ location: location }, function (results, status) {
            let infoWindow;
            if (status === "OK") {
              let msg = "Address: " + results[0].formatted_address;
              infoWindow = new google.maps.InfoWindow({
                content:
                  "Your location: " +
                  location.lat +
                  ", " +
                  location.lng +
                  " " +
                  msg,
              });
            } else {
              let infoWindow = new google.maps.InfoWindow({
                content: "Your location: " + location.lat + ", " + location.lng,
              });
            }
            marker.addListener("click", function () {
              infoWindow.open(map, marker);
            });
          });
          /*
          geocoder.geocode({ location: location2 }, function (results, status) {
            let infoWindow2;
            if (status === "OK") {
              let msg = "Address: " + results[0].formatted_address;
              infoWindow2 = new google.maps.InfoWindow({
                content:
                  "Your location: " +
                  location2.lat +
                  ", " +
                  location2.lng +
                  " " +
                  msg,
              });
            } else {
              let infoWindow = new google.maps.InfoWindow({
                content:
                  "Your location: " + location2.lat + ", " + location2.lng,
              });
            }
            marker2.addListener("click", function () {
              infoWindow2.open(map, marker2);
            });
          });
*/
          const directions = new google.maps.DirectionsService();

          const renderer = new google.maps.DirectionsRenderer({
            map: map,
          });

          // Start and end Points
          const start = new google.maps.LatLng(location2);
          const end = new google.maps.LatLng(location);

          // Request object
          const request = {
            origin: start,
            destination: end,
            travelMode: "DRIVING",
          };

          // Send request
          directions.route(request, function (result, status) {
            if (status == "OK") {
              // Draw path on map
              renderer.setDirections(result);
            }
          });
        }, showError);
      }

      function showError(error) {
        switch (error.code) {
          case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation.";
            break;
          case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable.";
            break;
          case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out.";
            break;
          case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred.";
            break;
        }
      }
    </script>

    <script>
      $(document).ready(function () {
        if (sessionStorage.getItem("currentUser")) {
          $("#order").prop("disabled", false);
          $("#login-message").css("visibility", "hidden");
        } else {
          $("#order").prop("disabled", true);
          $("#login-message").css("visibility", "visible");
        }

        var cartData = sessionStorage.getItem("cart");
        var cartArray = JSON.parse(cartData);
        var $shoppingCart = $("#shopping-cart");
        var total = 0;
        $.each(cartArray, function (index, item) {
          var $listItem = $(
            "<li class='list-group-item cart-item'><span class=remove-item style=visibility:hidden>&#10006</span>" +
              item +
              "</li>"
          );
          $shoppingCart.append($listItem);
          total += parseInt(item.replace(/\D/g, ""));
        });

        $("#total").html("$" + total);
      });

      $(document).on("mouseenter", ".cart-item", function () {
        $(this).find(".remove-item").css("visibility", "visible");
      });
      $(document).on("mouseleave", ".cart-item", function () {
        $(this).find(".remove-item").css("visibility", "hidden");
      });

      $(document).on("click", ".remove-item", function () {
        var item = $(this).parent().html();
        var itemName = item.slice(item.indexOf("</span>") + 7);

        console.log(itemName);
        sessionStorage.setItem(
          "cart",
          JSON.stringify(
            JSON.parse(sessionStorage.getItem("cart")).filter(
              (it) => it != itemName
            )
          )
        );
        $(this).parent().remove();

        var cartData = sessionStorage.getItem("cart");
        var cartArray = JSON.parse(cartData);
        var total = 0;
        $.each(cartArray, function (index, item) {
          var $listItem = $(
            "<li class='list-group-item cart-item'><span class=remove-item style=visibility:hidden>&#10006</span>" +
              item +
              "</li>"
          );
          total += parseInt(item.replace(/\D/g, ""));
        });
        $("#total").html("$" + total);
      });
    </script>
  </body>
</html>
