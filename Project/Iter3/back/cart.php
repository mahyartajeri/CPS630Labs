<?php
include_once 'database.php';
include_once 'items.php';
class CartClass
{

    private $db_instance;
    private $shoppingCart;
    private $shipping_cost = 7.99;

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

        $stmt = $this->db_instance->connection->prepare("UPDATE ShoppingCart SET quantity=? WHERE user_id=? AND item_id = ?");
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
            } else {
                echo 0;
            }
        } catch (Exception $e) {
            echo "Error in calculating total", $e->getMessage(), "\n";
        }
    }

    public function getTotalWShipping(){
        $stmt = $this->db_instance->connection->prepare("SELECT SUM(price * quantity) AS total_price FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id =?");
        $stmt->bind_param('s', $_COOKIE["userid"]);
        try {
            $stmt->execute();
            $priceResult = $stmt->get_result();
            if ($priceResult && $priceResult->num_rows > 0) {
                $row = $priceResult->fetch_assoc();
                $totalPrice = $row["total_price"];
                echo round(((float)$totalPrice + (float)$this->shipping_cost),2) . " (Shipping: $" . $this->shipping_cost . ")";
            } else {
                echo 0;
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


            $sql = $this->db_instance->connection->prepare("INSERT INTO Trips (source_code, destination_code, distance,truck_id, price) VALUES (?,?,?,?,".$this->shipping_cost.")");
            $sql->bind_param('ssss', $source_code, $destination_code, $distance, $truckId);
            $sql->execute();

            $sumSql->execute();
            $priceResult = $sumSql->get_result();

            $tripIdResult = $this->db_instance->execute_query($sqlLastTrip)->fetch_assoc();
            $tripId = $tripIdResult["trip_id"];

            if ($priceResult && $priceResult->num_rows > 0) {
                $row = $priceResult->fetch_assoc();
                $totalPrice = $row["total_price"];



                // $encryptedBalance = openssl_encrypt(1006.99, "AES-128-CTR", $salt, 0, '1234567891011121');
                // $stmt = $this->db_instance->connection->prepare("UPDATE users SET balance = ? WHERE user_id = ?");
                // $stmt->bind_param('ss', $encryptedBalance, $_COOKIE["userid"]);
                // $stmt->execute();

                # grab encrypted balance
                $saltsql = $this->db_instance->connection->prepare("SELECT salt, balance FROM users WHERE user_id = ?");
                $saltsql->bind_param('i', $_COOKIE["userid"]);
                $saltsql->execute();
                $result = $saltsql->get_result()->fetch_assoc();
                $salt = $result["salt"];

                $decryptedBalance = openssl_decrypt($result['balance'], "AES-128-CTR", $salt, 0, '1234567891011121');

                if ($decryptedBalance >= round(((float)$row["total_price"] + (float)$this->shipping_cost), 2)) { //check if balance is sufficient
                    $newBalance = (float)$decryptedBalance - (float)$row["total_price"] - (float)$this->shipping_cost;
                    $newBalance = round($newBalance, 2);
                    $encryptedBalance = openssl_encrypt($newBalance, "AES-128-CTR", $salt, 0, '1234567891011121');
                    $stmt = $this->db_instance->connection->prepare("UPDATE users SET balance = ? WHERE user_id = ?");
                    $stmt->bind_param('ss', $encryptedBalance, $_COOKIE["userid"]);
                    $stmt->execute();
                } else {
                    return FALSE;
                    // throw new Exception('Not enough balance to make purchase');
                }


                $insertSql = $this->db_instance->connection->prepare("INSERT INTO Purchases (store_code, total_price) VALUES (1,?)");
                $insertSql->bind_param('s', $totalPrice);
                $insertSql->execute();
                $result = $insertSql;

                $receiptIdResult = $this->db_instance->execute_query($sqlLastPurchase)->fetch_assoc();
                $receiptId = $receiptIdResult["receipt_id"];

                $sqlAddOrder = $this->db_instance->connection->prepare("INSERT INTO Orders (date_issued, date_received, total_price ,payment_code, user_id, trip_id, receipt_id) VALUES (?,?,?,200,?,?,?)");
                $sqlAddOrder->bind_param('ssssss', $date_issued, $date_issued, $totalPrice, $_COOKIE["userid"], $tripId, $receiptId);
                $sqlAddOrder->execute();
                if ($result) {
                    echo "Purchase made successfully";
                    return TRUE;
                } else {
                    echo "Problem in purchasing";
                }
            } else {
                echo "Problem in calculating final cost";
            }
        } catch (Exception $e) {
            echo "Error in purchasing", $e->getMessage(), "\n";
            // return FALSE;
        }
    }

    public function getClosestTruck($userPostalCode)
    {
        $sql = $this->db_instance->connection->prepare("SELECT *  FROM Trucks WHERE availability_code =?");
        $postalcode = substr($userPostalCode, 0, 3);
        $sql->bind_param('s', $postalcode);
        try {
            $sql->execute();
            $truckPostalResult = $sql->get_result();
            if ($truckPostalResult->num_rows === 0) {
                $truckId = 1;
            } else {
                $temp = $truckPostalResult->fetch_assoc();
                $truckId = $temp['truck_id'];
            }
            return $truckId;
        } catch (Exception $e) {
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

    public function show()
    {
        try {
            $sql = "SELECT Items.item_id FROM Items JOIN ShoppingCart ON Items.item_id = ShoppingCart.item_id WHERE ShoppingCart.user_id = " . $_COOKIE["userid"] . ";";


            $results = $this->db_instance->execute_query($sql);
            $rows = $results->fetch_all(MYSQLI_NUM);

            $chosen = array_map(function ($row) {
                return $row[0];
            }, $rows);
            if ($chosen == null) {
                $chosen = [];
            }
            $items = new ItemsClass();
            $items->printItems($chosen);
        } catch (Exception $e) {
            echo "Error showing shopping cart", $e->getMessage(), "\n";
        }
    }
}
