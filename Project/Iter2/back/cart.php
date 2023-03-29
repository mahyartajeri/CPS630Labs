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
        $stmt = $this->db_instance->connection->prepare("INSERT INTO ShoppingCart (user_id, item_id, quantity) VALUES (?, ?, 1)");
        $stmt->bind_param('ss', $_COOKIE["userid"], $id);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error adding to shopping cart", $e->getMessage(), "\n";
        }
    }

    public function remove($id)
    {
        $stmt = $this->db_instance->connection->prepare("DELETE FROM ShoppingCart WHERE user_id =? AND item_id =?");
        $stmt->bind_param('ss', $_COOKIE["userid"], $id);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error deleting from shopping cart", $e->getMessage(), "\n";
        }
    }

    public function update($id, $num)
    {
        $stmt = $this->db_instance->connection->prepare("UPDATE ShoppingCart SET quantity=? WHERE user_id=? AND item_id = ?" );
        $stmt->bind_param('sss', $num, $_COOKIE["userid"], $id);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error updating quantity in shopping cart", $e->getMessage(), "\n";
        }
    }

    public function getTotal()
    {
        $stmt = $this->db_instance->connection->prepare("SELECT SUM(price * quantity) AS total_price FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id =?");
        $stmt->bind_param('s', $_COOKIE["userid"]);
        try {
            $stmt->execute();
            $priceResult = $stmt->get_result();
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
        $sumSql = $this->db_instance->connection->prepare("SELECT SUM(price * quantity) AS total_price FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id =?");
        $sumSql->bind_param('s', $_COOKIE["userid"]);

        $sqlLastTrip = "SELECT MAX( trip_id) as trip_id FROM Trips";
        $sqlLastPurchase = "SELECT MAX(receipt_id) as receipt_id FROM Purchases";

        try {
            $truckId = $this->getClosestTruck($destination_code);

            $sql = $this->db_instance->connection->prepare("INSERT INTO Trips (source_code, destination_code, distance,truck_id, price) VALUES (?,?,?,?,7.99)");
            $sql->bind_param('ssss', $source_code, $destination_code, $distance, $truckId);
            $sql->execute();

            $sumSql->execute();
            $priceResult = $sumSql->get_result();

            $tripIdResult= $this->db_instance->execute_query($sqlLastTrip)->fetch_assoc();
            $tripId = $tripIdResult["trip_id"];

            if ($priceResult && $priceResult->num_rows > 0) {
                $row = $priceResult->fetch_assoc();
                $totalPrice = $row["total_price"];

                $insertSql = $this->db_instance->connection->prepare("INSERT INTO Purchases (store_code, total_price) VALUES (1,?)");
                $insertSql->bind_param('s', $totalPrice);
                $insertSql->execute();
                $result = $insertSql;

                $receiptIdResult= $this->db_instance->execute_query($sqlLastPurchase)->fetch_assoc();
                $receiptId = $receiptIdResult["receipt_id"];
                
                $sqlAddOrder = $this->db_instance->connection->prepare("INSERT INTO Orders (date_issued, date_received, total_price ,payment_code, user_id, trip_id, receipt_id) VALUES (?,?,?,200,?,?,?)");
                $sqlAddOrder->bind_param('ssssss', $date_issued, $date_issued, $totalPrice, $_COOKIE["userid"], $tripId ,$receiptId);
                $sqlAddOrder->execute();

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
        $sql = $this->db_instance->connection->prepare("SELECT *  FROM Trucks WHERE availability_code =?");
        $sql->bind_param('s', substr($userPostalCode,0,3));
        try{
            $sql->execute();
            $truckPostalResult = $sql->get_result();
            if ($truckPostalResult->num_rows === 0) {
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
        $sql = $this->db_instance->connection->prepare("DELETE FROM ShoppingCart WHERE user_id =?");
        $sql->bind_param('s', $_COOKIE["userid"]);
        try {
            $sql->execute();
        } catch (Exception $e) {
            echo "Error clearing shopping cart", $e->getMessage(), "\n";
        }
    }

}
