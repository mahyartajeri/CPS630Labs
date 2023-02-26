<!DOCTYPE html>
<html lang="en">

<head>

    <style>
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


        $sql = "CREATE TABLE IF NOT EXISTS StRec (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        firstname VARCHAR(30) NOT NULL,
                        lastname VARCHAR(30) NOT NULL,
                        email VARCHAR(50),
                        gender VARCHAR(1),
                        GPA DECIMAL(10, 3),
                        reg_date TIMESTAMP
                    )";
        if (mysqli_num_rows($res) === 0) {
            if ($conn->query($sql) === TRUE) {
                echo "Table Student Records created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }
        }

        $sql = "INSERT INTO StRec (firstname, lastname, email, gender, GPA)
                    VALUES ('John', 'Smith', 'john@example.com', 'M', 3.87),
                            ('Mohammed', 'Ali', 'm.ali@boxer.com', 'M', 3.98),
                            ('Pascal', 'Siakam', 'spicy.p@raptors.com', 'M', 3.43),
                            ('alfredina', 'pasta', 'a.pasta@delicious.com', 'F', 4.24)";

        if (mysqli_num_rows($res) === 0) {
            if ($conn->query($sql) === TRUE) {
                echo "Example records created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Table StRec already exists!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        mysqli_close($conn);
        echo "<br><button onclick='window.top.location.href= `./Lab2-Part2-Team19.html`;'>Back</button>";
    }

    ?>
</body>

</html>