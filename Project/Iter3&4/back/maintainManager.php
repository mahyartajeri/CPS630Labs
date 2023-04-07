<?php
session_start();

require("maintain.php");
$db = new MaintainClass();
$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']); //parse content_type string
if ($content_type_args[0] == 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

if (isset($_POST['tableName']) && isset($_POST['insertFields'])) {
    $_SESSION['table'] = $_POST['tableName'];
    if (isset($_SESSION['table'])) {
        $result = $db->getAttributes($_SESSION['table']);
        while ($row = $result->fetch_assoc()) {
            echo "<label>" . $row['Field'] . "</label><br>";
            echo "<input id='text" . $row['Field'] . "' name='text" . $row['Field'] . "' class='controls' type='text' required><br>";
        }
        echo "<button type='submit'>Insert</button>";
    }
}

if (isset($_POST['tableName']) && isset($_POST['deleteFields'])) {
    $_SESSION['table'] = $_POST['tableName'];
    if (isset($_SESSION['table'])) {
        $result = $db->getAttributes($_SESSION['table'])->fetch_assoc();

        echo "<label>" . $result['Field'] . "</label><br>";
        echo "<input id='text" . $result['Field'] . "' name='text" . $result['Field'] . "' class='controls' type='text' required><br>";

        echo "<button type='submit'>Delete</button>";
    }
}

if (isset($_POST['tableName']) && isset($_POST['updateFields'])) {
    $_SESSION['table'] = $_POST['tableName'];
    if (isset($_SESSION['table'])) {
        $result = $db->getAttributes($_SESSION['table']);
        while ($row = $result->fetch_assoc()) {
            echo "<label>" . $row['Field'] . "</label><br>";
            echo "<input id='text" . $row['Field'] . "' name='text" . $row['Field'] . "' class='controls' type='text' required><br>";
        }
        echo "<button type='submit'>Update</button>";
    }
}

if (isset($_POST['insert'])) {
    $db->insertEntry($_SESSION['table']);
}

if (isset($_POST['delete'])) {
    $db->deleteEntry($_SESSION['table']);
}

if (isset($_POST['update'])) {
    $db->updateEntry($_SESSION['table']);
}

if (isset($_POST['select']) && isset($_POST["table"])) {

    $_SESSION["table"] = $_POST["table"];
    $result = $db->select($_POST['table']);
    $attributes = $db->getAttributes($_POST['table']);

    echo "<table>";
    echo "<tr>";
    while ($attrow = $attributes->fetch_assoc()) {
        print_r("<td>" . $attrow['Field'] . "</td> ");
    }
    echo "</tr>";
    echo "<br>";
    for ($set = array(); $row = $result->fetch_assoc(); $set[] = $row);


    foreach ($set as $data => $vals) {
        echo "<tr>";
        foreach ($vals as $val) {
            print_r("<td>" . $val . "</td> ");
        }
        echo "</tr>";
    }

    echo "</table>";
}
