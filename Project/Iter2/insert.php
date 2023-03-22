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
  <title>SCS Home</title>
</head>

<body>
    <?php include 'header.php' ?>

    <h2 class="display-6">DB Maintain Insert</h2>
    <p>Select a table to insert</p>

    <form id="dbTable"action="insert.php" method="POST">
        <select name="dbTables" id="dbTables"> 
            <?php
                require './back/maintain.php';
                $db = new MaintainClass();
                $result = $db->getDbTables();
                while($row = $result->fetch_assoc()){
                    echo "<option value=".$row['Tables_in_cps630'].">".$row['Tables_in_cps630']."</option>";
                }
            ?>
        </select> 

        <button type="submit" id="dbInsert" name="dbInsert">Submit</button>
    </form>
    
    <?php
        if (isset($_SESSION['table'])) {
            $result = $db->insertEntry($_SESSION['table']);
            
            while($row = $result->fetch_assoc()){
                echo "<label>".$row['Field']."</label>";
                echo "<input id='text". $row['Field'] . " name='text'" . $row['Field']. " class='controls' type='text'><br>";
            }

        }

        if (isset($_POST['dbInsert'])) {
            $_SESSION['table'] = $_POST['dbTables'];
        }


    ?>

</body>

</html>