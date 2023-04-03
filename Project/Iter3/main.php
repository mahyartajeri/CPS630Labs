<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3aJ3UiAaO7r4NZjXH68_65yl_NPwmd8&libraries=places&callback=initMap" async defer></script> -->
</head>

<body ng-app="myApp">
  <div></div>

  <div ng-view>
    <script>
      var app = angular.module("myApp", ["ngRoute"]);
      app.config(function($routeProvider) {
        $routeProvider
          .when("/", {
            templateUrl: "index.php",
            controller: "indexController",
          })
          .when("/about", {
            templateUrl: "about.php",
          })
          .when("/contact", {
            templateUrl: "contact.php",
          })
          .when("/search", {
            templateUrl: "search.php",
            controller: "searchController",
          })
          .when("/signin", {
            templateUrl: "signin.php",
            controller: "signinController",
          })
          .when("/signup", {
            templateUrl: "signup.php",
            controller: "signupController",
          })
          .when("/services", {
            templateUrl: "services.php",
          })
          .when("/reviews", {
            templateUrl: "reviews.php",
            controller: "reviewsController",
          })
          .when("/cart", {
            templateUrl: "shopping.php",
            controller: "cartController",
          }).when("/faq", {
            templateUrl: "faq.php",
          });
      });

      app.controller("signupController", function($scope, $http, $sce) {
        $scope.formData = {};

        $scope.submitForm = function() {
          $scope.formData["action"] = "signup";
          console.log($scope.formData);
          $http({
            method: 'POST',
            url: './back/backsignup.php',
            data: JSON.stringify($scope.formData),

          }).then(function(response) {
            console.log(response.data);
            if (response.data === "good") {
              window.location.href = "#!signin";
            } else {

            }
          }, function(error) {
            console.log("Error signing in:", error);
          });
        };
      });

      app.controller("signinController", function($scope, $http, $sce) {
        $scope.formData = {};

        $scope.submitForm = function() {
          $scope.formData["action"] = "login";
          console.log($scope.formData);
          $http({
            method: 'POST',
            url: './back/backsignin.php',
            data: JSON.stringify($scope.formData),

          }).then(function(response) {

            if (response.data === "good") {
              window.location.href = "#!"
            } else {
              $scope.msg = "Invalid Credentials!";
            }
          }, function(error) {
            console.log("Error signing in:", error);
          });
        };
      });

      app.controller("reviewsController", function($scope, $http, $sce) {
        $http({
          method: "POST",
          url: "./back/reviewsManager.php",
          data: JSON.stringify({
            show: true
          })
        }).then(function(response) {
          console.log(response);
          $scope.reviews = $sce.trustAsHtml(response.data);

        }).catch(function(error) {
          console.log("Error:", error);
        })


        $http({
          method: "POST",
          url: "./back/reviewsManager.php",
          data: JSON.stringify({
            options: true
          })
        }).then(function(response) {
          console.log("options", response.data);
          $scope.itemsList = $sce.trustAsHtml(response.data);

        }).catch(function(error) {
          console.log("Error:", error);
        })

        $("#reviewSubmit").submit(function(event) {
          event.preventDefault();
          var formData = $(this).serialize();

          console.log(formData);
          $http({
            method: "POST",
            url: "./back/reviewsManager.php",

            data: JSON.stringify({
              add: true,
              item_id: $("#itemId").val(),
              rank: $("#rank").val(),
              description: $("#description").val(),
            })
          }).then(function(response) {
            console.log(response);
            $scope.reviews = $sce.trustAsHtml(response.data);

          }).catch(function(error) {
            console.log("Error:", error);
          })
        })
      })

      app.controller("headerController", function($scope, $location, $http, $rootScope, $sce) {

        $(document).on("click", "#logout", function() {
          $scope.logout();
        })

        $scope.logout = function() {
          console.log("loggin out");
          $http({
            method: "POST",
            url: "./back/backsignin.php",
            data: JSON.stringify({
              action: "logout"
            }),
          }).then(function(response) {

          }).catch(function(error) {
            console.log("Error:", error);
          })
          window.location.href = "#!signin";
        }
        $http({
          method: "POST",
          url: "./back/backheader.php",

        }).then(function(response) {

          $scope.buttons = $sce.trustAsHtml(response.data);


        }).catch(function(error) {
          console.log("Error:", error);
        })

        // $scope.searchSubmit = function(event) {
        //   event.preventDefault();
        //   var orderID = $('input[name="order_id"]').val();

        //   $rootScope.orderID = $sce.trustAsHtml(orderID);
        //   window.location.href = "#!search";
        // }

        $(document).on("keydown", "#searchright", function(event) {
          //console.log($('input[name="order_id"]').val());
          if (event.key === 'Enter') {
            var orderID = $('input[name="order_id"]').val();
            $rootScope.orderID = orderID;
            $location.path("/");
            $scope.$apply();
            $location.path("/search");
            $scope.$apply();
          }
        })

      })

      app.controller("searchController", function($scope, $http, $sce, $rootScope) {
        //$scope.orderID = $rootScope.orderID;
        $http({
          method: "POST",
          url: "./back/searchManager.php",
          data: JSON.stringify({
            order_id: $rootScope.orderID
          }),
        }).then(function(response) {
          console.log(response.data);
          $scope.orderDetails = $sce.trustAsHtml(response.data);

        }).catch(function(error) {
          console.log("Error:", error);
        })

      });
      app.controller("indexController", function($scope) {

        console.log($.cookie('userid'));
        $(document).ready(function() {

          // Make the items draggable
          $(".item").draggable({
            helper: "clone",
          });

          // Make the cart droppable
          $(".cart").droppable({
            drop: function(event, ui) {
              var item = ui.draggable.clone();
              itemId = item.attr("id");

              $.ajax({
                url: './back/cartManager.php',
                type: "POST",
                data: {
                  action: "ADD",
                  id: itemId,
                },
                success: function(response) {
                  console.log(response);
                }
              })

              var cartDiv = $(".cart");
              cartDiv.animate({
                  backgroundColor: "rgb(144,238,144)",
                },
                100,
                function() {
                  // Runs when animation is complete
                  cartDiv.animate({
                    backgroundColor: "transparent",
                  });
                }
              );
            },
          });
        });

      })
      app.controller("cartController", function($scope, $window, $http, $sce) {


        let x = document.getElementById("x"); // For Error Messages.
        let distance = 0;
        var src_code = "";
        var dst_code = "";
        var date = document.getElementById("deliveryDate");



        function getAddress(location) {
          var google_map_pos = new google.maps.LatLng(location.lat, location.lng);
          var google_maps_geocoder = new google.maps.Geocoder();
          google_maps_geocoder.geocode({
              'latLng': google_map_pos
            },
            function(results, status) {
              if (status == google.maps.GeocoderStatus.OK && results[0]) {
                // document.getElementById("shippingName").innerText = results[0].formatted_address;
                $scope.shipping = results[0].formatted_address;
                $scope.trustedShipping = $sce.trustAsHtml($scope.shipping);
                $scope.$apply();
                console.log($scope.shipping);
              }
            }
          );
        }

        function setPostalCodes(location, place) {
          var google_map_pos = new google.maps.LatLng(location.lat, location.lng);
          var google_maps_geocoder = new google.maps.Geocoder();
          google_maps_geocoder.geocode({
            'latLng': google_map_pos
          }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[0]) {
                for (j = 0; j < results[0].address_components.length; j++) {
                  if (results[0].address_components[j].types[0] == 'postal_code')
                    if (place == "src") {
                      src_code = results[0].address_components[j].short_name;
                    }
                  else {
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

        function calculateDistance(lon1, lat1, lon2, lat2) {
          var R = 6371; // Radius of the earth in km
          var dLat = toRad(lat2 - lat1); // Javascript functions in radians
          var dLon = toRad(lon2 - lon1);
          var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
          var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
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
        $window.initMap = function() {

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

            if (location && location2) {
              getAddress(location2);
              setPostalCodes(location, "dst");
              setPostalCodes(location2, "src");
              $distance = calculateDistance(location.lng, location.lat, location2.lng, location2.lat);
            };
          }, showError);

        }

        var script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3aJ3UiAaO7r4NZjXH68_65yl_NPwmd8&libraries=places&callback=initMap";
        script.defer = true;
        script.async = true;
        var scripts = document.getElementsByTagName('script');
        let add = true;
        // for (let i = 0; i < scripts.length; i++) {
        //   if (scripts[i].getAttribute("src") === script.src) {
        //     add = false;
        //   }
        // }
        if (add) {
          document.head.appendChild(script);
        }

        $scope.$watch('shipping', function() {
          console.log($scope.shipping, "is now");
          $scope.trustedShipping = $sce.trustAsHtml($scope.shipping);
        })

        $(document).ready(function() {

          function updateTotal() {
            $http({
              method: "POST",
              url: "./back/cartManager.php",
              data: JSON.stringify({
                action: "TOTAL",
              })
            }).then(function(response) {
              console.log(response.data);
              $scope.total = response.data;

            }).catch(function(error) {
              console.log("Error:", error);
            })
          }

          // $.ajax({
          //   url: "./back/cartManager.php",
          //   type: "POST",
          //   data: {
          //     show: true,
          //   },
          //   success: function(response) {
          //     console.log(response);
          //     $scope.cart = response;
          //     console.log($scope.cart);
          //   }
          // });

          $http({
            method: "POST",
            url: "./back/cartManager.php",
            data: JSON.stringify({
              show: true
            })
          }).then(function(response) {

            $scope.cart = $sce.trustAsHtml(response.data);
            //console.log($scope.cart);

          }).catch(function(error) {
            console.log("Error:", error);
          })

          $(document).on("change", 'input[type="number"]', function() {

            var newQuantity = $(this).val();
            var itemId = $(this).parent().attr("id");

            $http({
              method: "POST",
              url: "./back/cartManager.php",
              data: JSON.stringify({
                action: "UPDATE",
                id: itemId,
                num: newQuantity
              })
            }).then(function(response) {
              console.log(response.data);
              $scope.cart = $sce.trustAsHtml(response.data);
              updateTotal();

            }).catch(function(error) {
              console.log("Error:", error);
            })
            // $.ajax({
            //   url: "./back/cartManager.php",
            //   type: "POST",
            //   data: {
            //     action: "UPDATE",
            //     id: itemId,
            //     num: newQuantity,
            //   },
            //   success: function(response) {
            //     console.log(response);
            //     location.reload();
            //   }
            // });


          })


          $("#li2").click(function() {
            $("#shipping1").prop("checked", true);
          });


          $("#order").click(function() {
            var date = document.getElementById("deliveryDate").value;
            // $.ajax({
            //   url: "./back/cartManager.php",
            //   type: "POST",
            //   data: {
            //     action: "PURCHASE",
            //     source_code: src_code,
            //     destination_code: dst_code,
            //     distance: $distance.toFixed(2),
            //     date_issued: date,
            //   },
            //   success: function(response) {
            //     console.log(response);
            //     $.ajax({
            //       url: "./back/cartManager.php",
            //       type: "POST",
            //       data: {
            //         action: "CLEAR",
            //       },
            //       success: function(response) {
            //         console.log(response);
            //         location.reload();
            //       }
            //     });
            //   }
            // });
            function clearCart() {
              $http({
                method: "POST",
                url: "./back/cartManager.php",
                data: JSON.stringify({
                  action: "CLEAR",
                })
              }).then(function(response) {
                console.log(response.data);
                $scope.cart = $sce.trustAsHtml(response.data);

              }).catch(function(error) {
                console.log("Error:", error);
              })
            }

            $http({
              method: "POST",
              url: "./back/cartManager.php",
              data: JSON.stringify({
                action: "PURCHASE",
                source_code: src_code,
                destination_code: dst_code,
                distance: $distance.toFixed(2),
                date_issued: date,
              })
            }).then(function(response) {
              clearCart();

            }).catch(function(error) {
              console.log("Error:", error);
            })
          })

          if (!$.cookie("PHPSESSID")) {
            $("#order").prop("disabled", true);
            $("#login-message").css("visibility", "visible");
            $("#total").css("visibility", "hidden");
          }


          // $.ajax({
          //   url: "./back/cartManager.php",
          //   type: "POST",
          //   data: {
          //     action: "TOTAL",
          //   },
          //   success: function(response) {
          //     console.log(response);
          //     if (!response) {
          //       $("#total").html("$0");
          //     } else {
          //       $("#total").html("$" + response);
          //     }
          //   }
          // });
          updateTotal();

        });

        $(document).on("mouseenter", ".cart-item", function() {
          $(this).find(".remove-item").css("visibility", "visible");
        });
        $(document).on("mouseleave", ".cart-item", function() {
          $(this).find(".remove-item").css("visibility", "hidden");
        });


        $(document).on("click", ".remove-item", function() {
          var itemId = $(this).parent().attr("id");
          // $.ajax({
          //   url: './back/cartManager.php',
          //   type: "POST",
          //   data: {
          //     action: "REMOVE",
          //     id: itemId,
          //   },
          //   success: function(response) {
          //     location.reload();
          //     console.log(response);
          //   }
          // })
          $http({
            method: "POST",
            url: "./back/cartManager.php",
            data: JSON.stringify({
              action: "REMOVE",
              id: itemId,
            })
          }).then(function(response) {
            console.log(response.data);
            $scope.cart = $sce.trustAsHtml(response.data);

          }).catch(function(error) {
            console.log("Error:", error);
          })
        });

      })
    </script>
  </div>
</body>

</html>