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
  <link href="./style.css" rel="stylesheet" />
  <title>SCS Home</title>
</head>

<body>
  <?php include './header.php' ?>
  <div class="container-fluid text-center my-5">
    <h1 class="display-1">Welcome to SCS</h1>
    <h1 class="display-6">Drag Items below to cart for purchase.</h1>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h1 class="display-6">Electronics Department</h1>
        <ul class="list-group items">
          <?php
          include './back/items.php';
          if (!isset($_COOKIE["userid"])) {
            echo "<p>Please Sign-In to start shopping</p>";
          }
          $items = new ItemsClass();
          $items->printItems(null);
          ?>
        </ul>
      </div>
      <div class="col-md-6">
        <div class="cart d-flex justify-content-center text-center align-items-center rounded">
          <p style="opacity: 0.5; font-size: 200%">Cart</p>
        </div>
      </div>
    </div>
  </div>

  <script type='text/javascript'>
    $(document).ready(function() {
      if ($.cookie('userid')) {
        // Make the items draggable
        $(".item").draggable({
          helper: "clone",
        });
      }
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
  </script>
</body>

</html>