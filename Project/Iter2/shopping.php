<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3aJ3UiAaO7r4NZjXH68_65yl_NPwmd8&libraries=places&callback=initMap" async defer></script>
  <link href="./style.css" rel="stylesheet" />
  <title>Shopping Cart</title>
</head>

<body>
  <?php include 'header.php' ?>

  <div class="container-fluid my-5 py-5">
    <div class="row">
      <label for="shopping-cart">Shopping Cart</label>
      <div class="col-md-12">
        <ul class="list-group" id="shopping-cart"></ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-6">Cart Summary</h1>
        <ul class="list-group" id="shopping-cart">
          <?php
          if (isset($_COOKIE["userid"])) {
            try {
              include "./back/items.php";
              include_once "./back/database.php";
              $items = new ItemsClass();
              $db = new DatabaseClass();
              $sql = "SELECT Items.item_id FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id = " . $_COOKIE["userid"] . ";";
              $result = $db->execute_query($sql);
              $rows = $result->fetch_all(MYSQLI_NUM);

              $chosen = array_map(function ($row) {
                return $row[0];
              }, $rows);
              if ($chosen == null) {
                $chosen = [];
              }
              $items->printItems($chosen);
            } catch (Exception $e) {
              echo "Error in printing shopping cart", $e->getMessage(), "\n";
            }
          }

          ?>
          <li class="list-group-item">
            Total Cost:
            <span id="total">$0</span>
          </li>
        </ul>
        <button id="order">Purchase</button>
        <p id="login-message" style="visibility: hidden;">You must Login to order.</p>
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
      navigator.geolocation.watchPosition(function(position) {
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
        directions.route(request, function(result, status) {
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
    $(document).ready(function() {
      $('input[type="number"]').change(function() {
        var newQuantity = $(this).val();
        var itemId = $(this).parent().attr("id");
        $.ajax({
          url: "./back/cartManager.php",
          type: "POST",
          data: {
            action: "UPDATE",
            id: itemId,
            num: newQuantity,
          },
          success: function(response) {
            console.log(response);
          }
        });
      })

      $("#order").click(function() {
        $.ajax({
          url: "./back/cartManager.php",
          type: "POST",
          data: {
            action: "PURCHASE",
          },
          success: function(response) {
            console.log(response);
            $.ajax({
              url: "./back/cartManager.php",
              type: "POST",
              data: {
                action: "CLEAR",
              },
              success: function(response) {
                console.log(response);
                location.reload();
              }
            });
          }
        });
      })

      if (!$.cookie("userid")) {
        $("#order").prop("disabled", true);
        $("#login-message").css("visibility", "visible");
        $("#total").css("visibility", "hidden");
      }

      $.ajax({
        url: "./back/cartManager.php",
        type: "POST",
        data: {
          action: "TOTAL",
        },
        success: function(response) {
          console.log(response);
          if (!response) {
            $("#total").html("$0");
          } else {
            $("#total").html("$" + response);
          }
        }
      });

    });

    $(document).on("mouseenter", ".cart-item", function() {
      $(this).find(".remove-item").css("visibility", "visible");
    });
    $(document).on("mouseleave", ".cart-item", function() {
      $(this).find(".remove-item").css("visibility", "hidden");
    });


    $(document).on("click", ".remove-item", function() {
      var itemId = $(this).parent().attr("id");
      $.ajax({
        url: './back/cartManager.php',
        type: "POST",
        data: {
          action: "REMOVE",
          id: itemId,
        },
        success: function(response) {
          location.reload();
          console.log(response);
        }
      })

    });
  </script>
</body>

</html>