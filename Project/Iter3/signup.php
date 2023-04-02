<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3aJ3UiAaO7r4NZjXH68_65yl_NPwmd8&libraries=places&callback=initAutoComplete" async defer></script>
  <link href="./style.css" rel="stylesheet" />
  <title>Sign-Up</title>
</head>

<body>
  <?php include 'header.php' ?>


  <h1 class="display-6 pt-5 mt-5">Sign-Up</h1>
  <div class="container-fluid">
    <form name="signup" ng-submit="submitForm()">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" ng-model="formData.username" />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" ng-model="formData.password" /><br />

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" ng-model="formData.name" /><br />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" ng-model="formData.email" /><br />
      <label for="tel">Telephone:</label>
      <input type="tel" id="tel" name="tel" ng-model="formData.tel" /><br />

      <label for="address">Address:</label>
      <input type="text" id="address" name="address" ng-model="formData.address" />
      <label for="postal">Postal Code:</label>
      <input type="text" id="postal" name="postal" ng-model="formData.postal" /><br />

      <button name="action" action="signup.php" method="POST" value="signup" ng-model="formData.action">Sign Up</button>
    </form>
  </div>

</body>

</html>