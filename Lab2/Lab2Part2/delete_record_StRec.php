<!DOCTYPE html>

<head>

</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testnew";

    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Error establishing connection! " . mysqli_connect_error());
        }
        $res = $conn->query("SHOW TABLES LIKE 'StRec';");



        if (mysqli_num_rows($res) !== 0) {
            if (isset($_POST['submit'])) {
                $pkey = $_POST['primarykey'];

                $sql = "DELETE FROM StRec WHERE id = '$pkey'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record deleted successfully!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Table StRec doesn't exist!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        mysqli_close($conn);
        echo "<br><button onclick='window.top.location.href= `./Lab2-Part2-Team19.html`;'>Back</button>";
    }

    ?>
</body>