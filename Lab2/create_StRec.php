<!DOCTYPE html>
<html lang="en">


    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testnew";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Error establishing connection! " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE IF NOT EXISTS StRec (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        firstname VARCHAR(30) NOT NULL,
                        lastname VARCHAR(30) NOT NULL,
                        email VARCHAR(50),
                        reg_date TIMESTAMP
                    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table Student Records created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $sql = "INSERT INTO StRec (firstname, lastname, email)
                    VALUES ('John', 'Smith', 'john@example.com'),
                            ('Mohammed', 'Ali', 'm.ali@boxer.com'),
                            ('Pascal', 'Siakam', 'spicy.p@raptors.com'),
                            ('alfredo', 'pasta', 'a.pasta@delicious.com')";

    if ($conn->query($sql) === TRUE) {
        echo "Example records created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    ?>

</html>