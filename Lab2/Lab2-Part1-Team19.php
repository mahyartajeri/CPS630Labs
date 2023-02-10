<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>    
    <link rel="stylesheet" href="./Lab2-Part1-Team19.css"></link>
    <title>Art Work Database</title>

    <script>
        $(document).ready(function(){
          $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
          });
        });
    </script>
</head>
<body>
    <h1>Art Work Database</h1>
    <p>Put a bunch of info about the "Art Work Database" here</p>

    
    <form method="POST">
        <label for="genre">Genre:</label>
        <select name="genre" id="genre">
            <option value ="abstract">Abstract</option>
            <option value ="baroque">Baroque</option>
            <option value ="gothic">Gothic</option>
            <option value ="renaissance">Renaissance</option>
        </select>    

        <label for="type">Type:</label>
        <select name="type" id="type">
            <optgroup label="Painting">
                <option value ="landscape">Landscape</option>
                <option value ="portrait">Portrait</option>
            </optgroup>

            <option value ="sculpture">Sculpture</option>
        </select>    
        
        <label for="specification">Specification:</label>
        <select name="specification" id="specification">
  
            <option value ="commercial">Commercial</option>
            <option value ="non-commercial">Non-commercial</option>
            <option value ="derivative Work">Derivative Work</option>
            <option value ="non-derivative Work">Non-Derivative Work</option>
   
        </select>

        
        <label for="year">Year:</label>
        <input name="year" id="year" type="text">

        <label for="museum">Museum:</label>
        <input name="museum" id="museum" type="text" >
    
        <button name="action" style="margin:5px; float:right" action="index.php" method="POST" value="save">Save Record</button>
        <button name="action"style="margin:5px; float:right" action="index.php" method="POST" value="clear">Clear Record</button>
        <?php    
            $db = "artwork.txt";
            
            if ($_POST["action"]=="save") {
                $artwork = array();
                $int = 0;
                if (file_exists($db)) {
                    $fgc = file_get_contents($db);
                    $artwork = unserialize($fgc);
                    $int = count($artwork);
                }
                $artwork[$int]["genre"] = $_POST["genre"];
                $artwork[$int]["type"] = $_POST["type"];
                $artwork[$int]["specification"] = $_POST["specification"];
                $artwork[$int]["year"] = $_POST["year"];
                $artwork[$int]["museum"] = $_POST["museum"];
                file_put_contents($db, serialize($artwork));                                   
            }
            if ($_POST["action"]=="clear") {
                if (file_exists($db)) {
                    $fgc = file_get_contents($db);
                    $artwork = unserialize($fgc);
                    $int = count($artwork);
                }
                unlink($db);
            }
            //unset($GLOBALS['artwork']);
        ?>
    </form>

    <br>
    <div class="art">
        <?php
            $artwork = array();
            $db = "artwork.txt";
            if (file_exists($db)) {
                $fgc = file_get_contents($db);
                $artwork = unserialize($fgc);
                $int = count($artwork);
                foreach ($artwork as $rows => $row)
                {
                    foreach ($row as $key => $value)
                    {
                        echo "$value ";
                    }
                    echo "<br>";
                }
            }
            else {
                echo "no data";
            }
        ?>
    </div>


</body>
</html>