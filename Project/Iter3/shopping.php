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
  <title>SCS Shopping Cart</title>
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
          <div ng-bind-html="cart">

          </div>
          <div>
            <li class="list-group-item">
              Delivery Date:
              <input type="date" id="deliveryDate">
              <label for="deliveryDate"></label>
            </li>
            <li class="list-group-item" id="li2">
              Shipping:
              <input type="radio" id="shipping1">
              <label id="shippingName" for="shipping1">125 Bond St, Toronto, ON M5B 1Y2, Canada</label>
            </li>
            <li class="list-group-item">
              Total Cost:
              <span id="total">${{total}}</span>
            </li>
          </div>
        </ul>
        <button id="order">Purchase</button>
        <p id="login-message" style="visibility: hidden;">You must Login to order.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12" id="map-holder">
        <p id="x"></p>
        <div id="map">
          <h1>LOADING...</h1>
        </div>
      </div>
    </div>
  </div>


</body>

</html>