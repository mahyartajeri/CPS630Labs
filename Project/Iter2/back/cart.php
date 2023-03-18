<?php
include_once 'database.php';
class CartClass
{

    private $db_instance;
    private $shoppingCart;


    public function __construct()
    {
        $this->db_instance = new DatabaseClass();
        $this->shoppingCart = [];
    }

    public function add($id)
    {
        $sql = "INSERT INTO ShoppingCart (user_id, item_id, quantity) VALUES (" . $_COOKIE["userid"] . "," . $id . ", 1);";
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error adding to shopping cart", $e->getMessage(), "\n";
        }
    }

    public function remove($id)
    {
        $sql = "DELETE FROM ShoppingCart WHERE user_id = " . $_COOKIE["userid"] . " AND item_id = " . $id . ";";
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting from shopping cart", $e->getMessage(), "\n";
        }
    }

    public function update($id, $num)
    {
        $sql = "UPDATE ShoppingCart SET quantity = " . $num . " WHERE user_id = " . $_COOKIE["userid"] . " AND item_id = " . $id . ";";
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating quantity in shopping cart", $e->getMessage(), "\n";
        }
    }

    public function getTotal()
    {
        $sumSql = "SELECT SUM(price * quantity) AS total_price FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id = " . $_COOKIE["userid"] . ";";
        try {
            $priceResult = $this->db_instance->execute_query($sumSql);
            if ($priceResult && $priceResult->num_rows > 0) {
                $row = $priceResult->fetch_assoc();
                $totalPrice = $row["total_price"];
                echo $totalPrice;
            }
        } catch (Exception $e) {
            echo "Error in calculating total", $e->getMessage(), "\n";
        }
    }

    public function placeOrder()
    {
        $sumSql = "SELECT SUM(price * quantity) AS total_price FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id = " . $_COOKIE["userid"] . ";";
        try {
            $priceResult = $this->db_instance->execute_query($sumSql);
            if ($priceResult && $priceResult->num_rows > 0) {
                $row = $priceResult->fetch_assoc();
                $totalPrice = $row["total_price"];

                $insertSql = "INSERT INTO Purchases (store_code, total_price) VALUES ('1', '$totalPrice')";

                $result = $this->db_instance->execute_query($insertSql);
                if ($result) {
                    echo "Purchase made successfully";
                } else {
                    echo "Problem in purchasing";
                }
            } else {
                echo "Problem in calculating final cost";
            }
        } catch (Exception $e) {
            echo "Error in purchasing", $e->getMessage(), "\n";
        }
    }

    public function clearCart()
    {
        $sql = "DELETE FROM ShoppingCart WHERE user_id = " . $_COOKIE["userid"] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error clearing shopping cart", $e->getMessage(), "\n";
        }
    }
}
