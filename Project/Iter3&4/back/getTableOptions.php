<?php

require './maintain.php';


$db = new MaintainClass();
$result = $db->getDbTables();
while ($row = $result->fetch_assoc()) {
    echo "<option value=" . $row['Tables_in_cps630'] . ">" . $row['Tables_in_cps630'] . "</option>";
}
