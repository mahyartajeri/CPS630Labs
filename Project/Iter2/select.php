<?php
  session_start();
  if(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'admin') {
    die("Admins Only!");
  }
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

    <h2 class="display-6">DB Maintain Select</h2>
    <p>Select a table to Select</p>

    <form id="dbTable"action="select.php" method="POST">
        <p>SELECT * FROM</p>
        <select name="dbTables" id="dbTables"> 
            <option selected disabled>Table</option>
            <?php
                require './back/maintain.php';
                $db = new MaintainClass();
                $result = $db->getDbTables();
                while($row = $result->fetch_assoc()){
                    echo "<option value=".$row['Tables_in_cps630'].">".$row['Tables_in_cps630']."</option>";
                }
            ?>
        </select> 
        <br>

        <button type="submit" id="dbSelect" name="dbSelect">Submit</button>
    </form>

    <?php

        if (isset($_POST['dbSelect'])) {
            $_SESSION['table'] = $_POST['dbTables'];
            $result = $db->select($_SESSION['table']);
            $attributes = $db->getAttributes($_SESSION['table']);

            echo "<table>";
            echo "<tr>";
            while($attrow = $attributes->fetch_assoc()){
                print_r("<td>" . $attrow['Field'] . "</td> ");
            }
            echo "</tr>";
            echo "<br>";
            for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);
            

            foreach ($set as $data=>$vals){
                echo "<tr>";
                foreach($vals as $val){
                    print_r("<td>" . $val . "</td> ");
                }
                echo "</tr>";
            }

            echo "</table>";
        }

    ?>
</body>

</html>