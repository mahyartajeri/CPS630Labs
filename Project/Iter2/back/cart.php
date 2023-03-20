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

    public function placeOrder($source_code, $destination_code, $distance, $date_issued)
    {
        $sumSql = "SELECT SUM(price * quantity) AS total_price FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id = " . $_COOKIE["userid"] . ";";
        //$sql = "INSERT INTO Trips (source_code, destination_code, distance,truck_id, price) VALUES ('" . $source_code . "','" . $destination_code . "'," . $distance . ",1, 7.99);";
        $sqlLastTrip = "SELECT MAX( trip_id) as trip_id FROM Trips";
        $sqlLastPurchase = "SELECT MAX(receipt_id) as receipt_id FROM Purchases";

        try {
            $truckId = $this->getClosestTruck($destination_code);
            $sql = "INSERT INTO Trips (source_code, destination_code, distance,truck_id, price) VALUES ('" . $source_code . "','" . $destination_code . "'," . $distance . ",'". $truckId ."', 7.99);";
            $this->db_instance->execute_query($sql);
            $priceResult = $this->db_instance->execute_query($sumSql);

            $tripIdResult= $this->db_instance->execute_query($sqlLastTrip)->fetch_assoc();
            $tripId = $tripIdResult["trip_id"];

            if ($priceResult && $priceResult->num_rows > 0) {
                $row = $priceResult->fetch_assoc();
                $totalPrice = $row["total_price"];

                $insertSql = "INSERT INTO Purchases (store_code, total_price) VALUES ('1', '$totalPrice')";

                $receiptIdResult= $this->db_instance->execute_query($sqlLastPurchase)->fetch_assoc();
                $receiptId = $receiptIdResult["receipt_id"];

                $result = $this->db_instance->execute_query($insertSql);
                $sqlAddOrder = "INSERT INTO Orders (date_issued, date_received, total_price ,payment_code, user_id, trip_id, receipt_id) VALUES ('" . $date_issued . "','" . $date_issued . "','" . $totalPrice ."','". "200". "','".  $_COOKIE["userid"] ."','". $tripId . "','" . $receiptId ."');";
                $this->db_instance->execute_query($sqlAddOrder);
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

    public function getClosestTruck($userPostalCode) {
        $sql = "SELECT *  FROM Trucks WHERE availability_code = '" . substr($userPostalCode,0,3) . "';";
        try{
            $truckPostalResult = $this->db_instance->execute_query($sql);
            if ($truckPostalResult->num_rows === 0) {
                // $sql2 = "SELECT * FROM Trucks". ";";
                // $allTrucks = $this->db_instance->execute_query($sql2);
                // $row = $allTrucks->fetch_assoc();
                // $numResults = $allTrucks->num_rows;
                // $randomNum = (int)rand(1,$numResults);
                // printf($numResults);
                // $num = 1;
                //$truckId = $row["truck_id"][$numResults];

                //default to truck_id=2 if no truck with availability_code in with the user
                $truckId = 1;
                
            }else{
                $temp = $truckPostalResult->fetch_assoc();
                $truckId = $temp['truck_id'];
            }
            return $truckId;
        }catch (Exception $e) {
            echo "Error getting truck ", $e->getMessage(), "\n";
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
