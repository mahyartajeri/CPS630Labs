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
  <title>SCS Search</title>
  <style>
    table {
      padding: 15px;
      margin: 15px;
    }

    th,
    td {
      padding: 15px;
      text-align: left;
    }
  </style>
  <script type='text/javascript'>
    // $(document).ready(function() {
    //   $(".clickable-row").click(function() {
    //     var form = $('<form action="search.php" method="POST" style="display:none;">' +
    //       '<input type="text" name="order_id" value="' + $(this).data('orderid') + '" />' +
    //       '</form>');
    //     $('body').append(form);
    //     form.submit();
    //   });
    // });
  </script>
</head>

<body>
  <?php include './header.php' ?>
  <div class="container-fluid text-center my-5 py-5">
    <h1 class="display-1">Order details <p>{{orderID}}</p>
    </h1>
  </div>
  <div ng-bind-html="orderDetails">


  </div>
</body>

</html>