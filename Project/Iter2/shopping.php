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
            Delivery Date:
            <input type="date" id="deliveryDate">
            <label for="deliveryDate"></label>
          </li>
          <li class="list-group-item" id="li2">
            Shipping:
            <input type="radio" id="shipping1">
            <label id="shippingName" for="shipping1"></label>
          </li>
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
    let distance = 0;
    var src_code = "";
    var dst_code = "";
    var date = document.getElementById("deliveryDate");

    function initMap() {
      console.log(date);
      navigator.geolocation.watchPosition(function(position) {
        let location = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        let location2 = {
          lat: 43.6577,
          lng: -79.3788,
        };
        //TMU coods as shipping location 1
        if (document.getElementById('shipping1').checked){

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

          // Send requestS
          directions.route(request, function(result, status) {
            if (status == "OK") {
              // Draw path on map
              renderer.setDirections(result);
            }
          });
      }
        if(location && location2){
          getAddress(location2);
          setPostalCodes(location, "dst");
          setPostalCodes(location2, "src");
          $distance=calculateDistance(location.lng,location.lat, location2.lng,location2.lat);
        };
      }, showError);
    }

    function getAddress(location){
      var google_map_pos = new google.maps.LatLng( location.lat , location.lng);
      var google_maps_geocoder = new google.maps.Geocoder();
      google_maps_geocoder.geocode(
          { 'latLng': google_map_pos },
          function( results, status ) {
            if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
              document.getElementById("shippingName").innerText = results[0].formatted_address;
              console.log( results[0].formatted_address );
            }
          }
        );
    }

    function setPostalCodes(location, place){
      var google_map_pos = new google.maps.LatLng( location.lat , location.lng);
      var google_maps_geocoder = new google.maps.Geocoder();
      google_maps_geocoder.geocode({'latLng': google_map_pos}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                for (j = 0; j < results[0].address_components.length; j++) {
                    if (results[0].address_components[j].types[0] == 'postal_code')
                      if (place=="src"){
                        src_code=results[0].address_components[j].short_name;
                      }
                      else{
                        dst_code = results[0].address_components[j].short_name;
                      }
                }
            }
        } else {
            console.log("Geocoder failed due to: " + status);
        }
      });
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

    function calculateDistance(lon1, lat1, lon2, lat2){
      var R = 6371; // Radius of the earth in km
      var dLat = toRad(lat2-lat1);  // Javascript functions in radians
      var dLon = toRad(lon2-lon1); 
      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
              Math.sin(dLon/2) * Math.sin(dLon/2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      var d = R * c; // Distance in km
      return d;
    }
    function toRad(Value) {
    /** Converts numeric degrees to radians */
      return Value * Math.PI / 180;
    }
    if (typeof(Number.prototype.toRad) === "undefined") {
      Number.prototype.toRad = function() {
        return this * Math.PI / 180;
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
            location.reload();
          }
        });
      })
        
      $("#li2").click(function() {
        $("#shipping1").prop("checked", true);
      });


      $("#order").click(function() {
        var date = document.getElementById("deliveryDate").value;
        $.ajax({
          url: "./back/cartManager.php",
          type: "POST",
          data: {
            action: "PURCHASE",
            source_code: src_code,
            destination_code: dst_code,
            distance: $distance.toFixed(2),
            date_issued: date,
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

      /*
          //Ryerson as shipping location 1
          let location2 = {
          lat: 43.6577,
          lng: -79.3788,
        };
        //console.log($src_code);
        
        $.ajax({
          url: "./back/cartManager.php",
          type: "POST",
          data: {
            action: "SHIPPING",
            source_code: src_code,
            distination_code: dst_code,
            distance: $distance.toFixed(2),
          },
          success: function(response) {
            console.log(response);
          }
        });
        */

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