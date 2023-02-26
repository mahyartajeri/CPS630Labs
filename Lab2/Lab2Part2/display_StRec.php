<!DOCTYPE html>

<head>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 15px;
        }
    </style>
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


        $sql = "SELECT * FROM StRec";

        if (mysqli_num_rows($res) !== 0) {
            $data = $conn->query($sql);
            if ($data->num_rows > 0) {
                echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Date Admitted</th><th>Gender</th><th>GPA</th></tr>";
                // Data
                $closeOpenCell = "</td><td>";
                while ($row = $data->fetch_assoc()) {
                    echo "<tr><td>" . $row["id"] . $closeOpenCell . $row["firstname"] . $closeOpenCell . $row["lastname"] . $closeOpenCell . $row["email"] . $closeOpenCell . $row["reg_date"] . $closeOpenCell . $row["gender"] . $closeOpenCell . $row["GPA"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Table StRec doesn't exists!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        mysqli_close($conn);
        // echo "<br><button onclick='window.top.location.href= `./Lab2-Part2-Team19.html`;'>Back</button>";
    }
    ?>
</body>