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
  <style>
    table {
      padding: 15px;
      margin: 15px;
    }
    th, td {
      padding: 15px;
      text-align: left;
    }
  </style>
  <script type='text/javascript'>
    $(document).ready(function() {
      $(".clickable-row").click(function() {
        var form = $('<form action="search.php" method="POST" style="display:none;">' +
          '<input type="text" name="order_id" value="'+$(this).data('orderid')+'" />' +
          '</form>');
        $('body').append(form);
        form.submit();
      });
    });
  </script>
</head>

<body>
  <?php include './header.php' ?>
    <div class="container-fluid text-center my-5">
      <h1 class="display-1">Order details</h1>
    </div>
    <?php
      include_once 'back/search.php';
      $search_instance = new SearchClass();
      $auth = new AuthenticationClass();
      
      if($auth->authenticated() && isset($_POST['order_id'])){
        $order = $search_instance->getOrder($_POST['order_id']);
        $trip = $search_instance->getShippingInfo($_POST['order_id']);
        if ($order) {
          ?>
              <div class="container">
                <div class="row">
                  <div class="col-md">
                    <table>
                      <tr>
                        <th>Order ID</th>
                        <th>Date issued</th>
                        <th>Date Received</th>
                        <th>Total Price</th>
                      </tr>
                      <tr>
                        <?php
                          echo "<td>" . $order['order_id'] . "</td>";
                          echo "<td>" . $order['date_issued'] . "</td>";
                          echo "<td>" . $order['date_received'] . "</td>";
                          echo "<td>" . $order['total_price'] . "</td>";
                        ?>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md">
                    <table>
                      <tr>
                        <th>Originating Postal Code</th>
                        <th>Destination Postal Code</th>
                        <th>Distance</th>
                        <th>Truck Number</th>
                        <th>Shipping Cost</th>
                      </tr>
                      <tr>
                        <?php
                          echo "<td>" . $trip['source_code'] . "</td>";
                          echo "<td>" . $trip['destination_code'] . "</td>";
                          echo "<td>" . $trip['distance'] . "</td>";
                          echo "<td>" . $trip['truck_id'] . "</td>";
                          echo "<td>" . $trip['price'] . "</td>";
                        ?>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
          <?php

        }
        else {
          echo "<h3> No order:". $_POST['order_id'] ." found for current user </h3>";
        }
      }
      else {
        echo "<h3> No order requested </h3>";
      }


    ?>
    <div class="container-fluid text-center my-5">
      <h1 class="display-1">Past Orders</h1>
    </div>
    <table class="list-group">
      <tr>
        <th>Order ID</th>
        <th>Date issued</th>
        <th>Date Received</th>
        <th>Total Price</th>
      </tr>
      <?php
        if($auth->authenticated()){
          $orders = $search_instance->searchOrders($auth->getUserID());
          foreach ($orders as $order) {
            echo "<tr class='clickable-row' data-orderid='" . $order['order_id'] . "'>";
            echo "<td>" . $order['order_id'] . "</td>";
            echo "<td>" . $order['date_issued'] . "</td>";
            echo "<td>" . $order['date_received'] . "</td>";
            echo "<td>" . $order['total_price'] . "</td>";
            echo "</tr>";
          }
        }
      ?>

    </table>
</body>

</html>