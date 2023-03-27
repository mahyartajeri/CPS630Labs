<?php
include_once 'database.php';
class ItemsClass
{

    private $db_instance;


    public function __construct()
    {
        $this->db_instance = new DatabaseClass();
    }

    public function printItems($chosen)
    {
        if (!isset($chosen)) {
            $sql = "SELECT * FROM Items;";
            $result = $this->db_instance->execute_query($sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li id='$row[item_id]' class='list-group-item item'>" . $row["item_name"] . ", " . $row["price"] . " ," . $row["made_in"] . " ," . $row["department_code"] . "</li>";
                }
            }
        } else {
            if (!empty($chosen) && $chosen != null) {
                $sql = "SELECT Items.item_id, item_name, price, made_in, quantity FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE Items.item_id IN (" . implode(",", $chosen) . ") AND ShoppingCart.user_id = " . $_COOKIE["userid"] . ";";
                $result = $this->db_instance->execute_query($sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li id='$row[item_id]' class='list-group-item item cart-item'><span class=remove-item style=visibility:hidden>&#10006</span>" . $row["item_name"] . ", " . $row["price"] . " ," . $row["made_in"] . " ," . " <input type='number' min='1' value='" . $row["quantity"] . "'></input</li>";
                    }
                }
            } else {
                echo "<p>Cart empty</p>";
            }
        }
    }

    public function optionItems()
    {
        $sql = "SELECT * FROM Items;";
        $result = $this->db_instance->execute_query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value=" . $row["item_id"] . ">" . $row["item_name"] . "</option>";
            }
        }
    }
}
