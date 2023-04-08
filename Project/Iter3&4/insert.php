<?php
session_start();
?>
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
    <title>Admin Insert</title>
</head>

<body>
    <?php include 'header.php' ?>
    <p class="mt-5 pt-5"></p>
    <h2 class="display-6 pt-5 mt-5">DB Maintain Insert</h2>
    <p>Select a table to insert</p>

    <form id="dbTable" ng-submit="getFields()">
        <select name="dbTables" id="dbTables" ng-bind-html="tableOptions">


        </select>

        <button type="submit" id="dbInsert" name="dbInsert">Submit</button>
    </form>

    <form ng-submit="insertFunction()" ng-bind-html="insertFormFields" id="dbInsertForm">

    </form>

    <?php
    ?>
</body>

</html>