<?php
include_once 'database.php';
class MaintainClass
{
    private $db_instance;
  
    public function __construct()
    {
      $this->db_instance = new DatabaseClass();
    }

    public function getDbTables(){
        $sql = "SHOW Tables from cps630;";
        try {
            $result = $this->db_instance->execute_query($sql);
            return $result;
        } catch (Exception $e) {
            echo "Error getting tables", $e->getMessage(), "\n";
        }
    }

    public function getAttributes($table){
        $sql = "DESCRIBE ". $table;
        try {
            $result = $this->db_instance->execute_query($sql);
            return $result;
        } catch (Exception $e) {
            echo "Error getting tables", $e->getMessage(), "\n";
        }
    }

    public function select($table){
        if ($_POST['whereClause']){
            $sql = "SELECT * FROM " . $table . " WHERE " . $_POST['whereClause'];
        } else{
            $sql = "SELECT * FROM " . $table;
        }
        try{
            $result = $this->db_instance->execute_query($sql);
            return $result;
        } catch (Exception $e) {
            echo "Error getting tables", $e->getMessage(), "\n";
        }

    }

    public function updateEntry($table){

        if (($table) == 'items'){
            $this->updateItem($table);
        } elseif(($table) == 'orders'){
            $this->updateOrder($table);
        } elseif(($table) == 'purchases'){
            $this->updatePurchase($table);
        } elseif(($table) == 'shoppingcart'){
            $this->updateShoppingcart($table);
        } elseif(($table) == 'trips'){
            $this->updateTrip($table);
        } elseif(($table) == 'trucks'){
            $this->updateTruck($table);
        } elseif(($table) == 'users'){
            $this->updateUser($table);
        }
    }

    public function updateItem($table){
        $name = '';
        $price = '';
        $madeIn = '';
        $depCode = '';

        if ($_POST['textitem_name']) {
            $name = "`item_name` = '" . $_POST['textitem_name'] . "',";
        }
        if ($_POST['textprice']) {
            $price = "`price` = '" . $_POST['textprice'] . "',";
        }
        if ($_POST['textmade_in']) {
            $madeIn = "`made_in` = '" . $_POST['textmade_in'] . "',";
        }
        if ($_POST['textdepartment_code']) {
            $depCode = "`department_code` = '" . $_POST['textdepartment_code'] . "',";
        }

        $temp = $name . $price . $madeIn . $depCode;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `items` SET " . $updates . " WHERE `item_id` = " . $_POST['textitem_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating item", $e->getMessage(), "\n";
        }
    }

    public function updateOrder($table){
        $dateIssued = '';
        $dateReceived = '';
        $totalPrice = '';
        $paymentCode = '';
        $userId = '';
        $tripId = '';
        $receiptId = '';

        if ($_POST['textdate_issued']) {
            $dateIssued = "`date_issued` = '" . $_POST['textdate_issued'] . "',";
        }
        if ($_POST['textdate_received']) {
            $dateReceived = "`date_received` = '" . $_POST['textdate_received'] . "',";
        }
        if ($_POST['textpayment_code']) {
            $paymentCode = "`payment_code` = '" . $_POST['textpayment_code'] . "',";
        }
        if ($_POST['textuser_id']) {
            $userId = "`user_id` = '" . $_POST['textuser_id'] . "',";
        }
        if ($_POST['texttrip_id']) {
            $tripId = "`trip_id` = '" . $_POST['texttrip_id'] . "',";
        }
        if ($_POST['textreceipt_id']) {
            $receiptId = "`receipt_id` = '" . $_POST['textreceipt_id'] . "',";
        }
        if ($_POST['texttotal_price']) {
            $totalPrice = "`total_price` = '" . $_POST['texttotal_price'] . "',";
        }

        $temp = $dateIssued . $dateReceived . $totalPrice . $paymentCode . $userId . $tripId . $receiptId;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `orders` SET " . $updates . " WHERE `order_id` = " . $_POST['textorder_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating order", $e->getMessage(), "\n";
        }
    }

    public function updatePurchase($table){
        $storeCode = '';
        $totalPrice = '';

        if ($_POST['textstore_code']) {
            $storeCode = "`store_code` = '" . $_POST['textstore_code'] . "',";
        }
        if ($_POST['texttotal_price']) {
            $totalPrice = "`total_price` = '" . $_POST['texttotal_price'] . "',";
        }

        $temp = $storeCode . $totalPrice;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `purchases` SET " . $updates . " WHERE `receipt_id` = " . $_POST['textreceipt_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating purchase", $e->getMessage(), "\n";
        }
    }

    public function updateShoppingcart($table){
        $itemId = '';
        $quantity = '';

        if ($_POST['textitem_id']) {
            $itemId = "`item_id` = '" . $_POST['textitem_id'] . "',";
        }
        if ($_POST['textquantity']) {
            $quantity = "`quantity` = '" . $_POST['textquantity'] . "',";
        }

        $temp = $itemId . $quantity;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `shoppingcart` SET " . $updates . " WHERE `user_id` = " . $_POST['textuser_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating shopping cart", $e->getMessage(), "\n";
        }
    }

    public function updateTrip($table){
        $srcCode = '';
        $dstcode = '';
        $dist = '';
        $truckId = '';
        $price = '';


        if ($_POST['textsource_code']) {
            $srcCode = "`source_code` = '" . $_POST['textsource_code'] . "',";
        }
        if ($_POST['textdestination_code']) {
            $dstcode = "`destination_code` = '" . $_POST['textdestination_code'] . "',";
        }
        if ($_POST['textdistance']) {
            $dist = "`distance` = '" . $_POST['textdistance'] . "',";
        }
        if ($_POST['texttruck_id']) {
            $truckId = "`truck_id` = '" . $_POST['texttruck_id'] . "',";
        }
        if ($_POST['textprice']) {
            $price = "`price` = '" . $_POST['textprice'] . "',";
        }

        $temp = $srcCode . $dstcode . $dist . $truckId . $price ;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `trips` SET " . $updates . " WHERE `trip_id` = " . $_POST['texttrip_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating trip", $e->getMessage(), "\n";
        }
    }

    public function updateTruck($table){
        $truckCode = '';
        $avail = '';

        if ($_POST['texttruck_code']) {
            $truckCode = "`truck_code` = '" . $_POST['texttruck_code'] . "',";
        }
        if ($_POST['textavailability_code']) {
            $avail = "`availability_code` = '" . $_POST['textavailability_code'] . "',";
        }

        $temp = $truckCode . $avail;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `trucks` SET " . $updates . " WHERE `truck_id` = " . $_POST['texttruck_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating truck", $e->getMessage(), "\n";
        }
    }

    public function updateUser($table){
        $name = '';
        $telNo = '';
        $email = '';
        $address = '';
        $cityCode = '';
        $loginId = '';
        $password = '';
        $balance = '';
        $userType = '';

        if ($_POST['textname']) {
            $name = "`name` = '" . $_POST['textname'] . "',";
        }
        if ($_POST['texttel_no']) {
            $telNo = "`tel_no` = '" . $_POST['texttel_no'] . "',";
        }
        if ($_POST['textemail']) {
            $email = "`email` = '" . $_POST['textemail'] . "',";
        }
        if ($_POST['textaddress']) {
            $address = "`address` = '" . $_POST['textaddress'] . "',";
        }
        if ($_POST['textcity_code']) {
            $cityCode = "`city_code` = '" . $_POST['textcity_code'] . "',";
        }
        if ($_POST['textlogin_id']) {
            $loginId = "`login_id` = '" . $_POST['textlogin_id'] . "',";
        }
        if ($_POST['textpassword']) {
            $password = "`password` = '" . $_POST['textpassword'] . "',";
        }
        if ($_POST['textbalance']) {
            $balance = "`balance` = '" . $_POST['textbalance'] . "',";
        }
        if ($_POST['textuser_type']) {
            $userType = "`user_type` = '" . $_POST['textuser_type'] . "',";
        }

        $temp = $name . $telNo . $email . $address . $cityCode . $loginId . $password . $balance . $userType;
        $updates = rtrim($temp, ", ");
        $sql = "UPDATE `users` SET " . $updates . " WHERE `user_id` = " . $_POST['textuser_id'] . ";";

        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error updating user", $e->getMessage(), "\n";
        }
    }

    public function deleteEntry($table){

        if (($table) == 'items'){
            $this->deleteItem($table);
        } elseif(($table) == 'orders'){
            $this->deleteOrder($table);
        } elseif(($table) == 'purchases'){
            $this->deletePurchase($table);
        } elseif(($table) == 'shoppingcart'){
            $this->deleteShoppingcart($table);
        } elseif(($table) == 'trips'){
            $this->deleteTrip($table);
        } elseif(($table) == 'trucks'){
            $this->deleteTruck($table);
        } elseif(($table) == 'users'){
            $this->deleteUser($table);
        }
    }

    public function deleteItem($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE item_id = ' . $_POST['textitem_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting item", $e->getMessage(), "\n";
        }
    }

    public function deleteOrder($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE order_id = ' . $_POST['textorder_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting order", $e->getMessage(), "\n";
        }
    }

    public function deletePurchase($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE receipt_id = ' . $_POST['textreceipt_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting purchase", $e->getMessage(), "\n";
        }
    }

    public function deleteShoppingcart($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE user_id = ' . $_POST['textuser_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting shopping cart", $e->getMessage(), "\n";
        }
    }

    public function deleteTrip($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE trip_id = ' . $_POST['texttrip_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting trip", $e->getMessage(), "\n";
        }
    }

    public function deleteTruck($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE truck_id = ' . $_POST['texttruck_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting truck", $e->getMessage(), "\n";
        }
    }

    public function deleteUser($table){
        $sql = 'DELETE FROM ' . $table . ' WHERE user_id = ' . $_POST['textuser_id'] ;
        try {
            $this->db_instance->execute_query($sql);
        } catch (Exception $e) {
            echo "Error deleting user", $e->getMessage(), "\n";
        }
    }

    public function insertEntry($table){

        if (($table) == 'items'){
            $this->insertItems();
        } elseif(($table) == 'orders'){
            $this->insertOrders();
        } elseif(($table) == 'purchases'){
            $this->insertPurchases();
        } elseif(($table) == 'shoppingcart'){
            $this->insertShoppingcart();
        } elseif(($table) == 'trips'){
            $this->insertTrips();
        } elseif(($table) == 'trucks'){
            $this->insertTrucks();
        } elseif(($table) == 'users'){
            $this->insertUsers();
        }
    }

    public function insertItems(){
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO items (item_id, item_name, price, made_in, department_code) VALUES (NULL, ?, ?, ?, ?)");
            $stmt->bind_param('ssss', $_POST['textitem_name'], $_POST['textprice'], $_POST['textmade_in'], $_POST['textdepartment_code']);
            $stmt->execute();
            //return $result;
        } catch (Exception $e) {
            echo "Error inserting items", $e->getMessage(), "\n";
        }
    }

    public function insertOrders(){
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO orders (order_id, date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssss', $_POST['textdate_issued'], $_POST['textdate_received'], $_POST['texttotal_price'], $_POST['textpayment_codee'], $_POST['textuser_id'], $_POST['texttrip_id'], $_POST['textreceipt_id']);
            $stmt->execute();
            //return $result;
        } catch (Exception $e) {
            echo "Error inserting orders", $e->getMessage(), "\n";
        }
    }

    public function insertPurchases(){
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO purchases (receipt_id, store_code, total_price) VALUES (NULL, ?, ?)");
            $stmt->bind_param('ss', $_POST['textstore_code'], $_POST['texttotal_price']);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error inserting purchases", $e->getMessage(), "\n";
        }
    }


    public function insertShoppingCart(){
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO shoppingcart (user_id, item_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $_POST['textuser_id'], $_POST['textitem_id'], $_POST['textquantity']);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error inserting into shoppingcart", $e->getMessage(), "\n";
        }
    }

    public function insertTrips(){
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO trips (trip_id, source_code, destination_code, distance, truck_id, price) VALUES (NULL, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $_POST['textsource_code'], $_POST['textdestination_code'], $_POST['textdistance'], $_POST['texttruck_id'], $_POST['textprice']);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error inserting trip", $e->getMessage(), "\n";
        }
    }

    public function insertTrucks(){
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO trucks (truck_id, truck_code, availability_code) VALUES (NULL, ?, ?)");
            $stmt->bind_param('ss', $_POST['texttruck_code'], $_POST['textavailability_code']);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error inserting truck", $e->getMessage(), "\n";
        }
    }

    public function insertUsers(){
        //$sql = $sql = "INSERT INTO users (user_id, name, tel_no, email, address, city_code, login_id, password, balance, user_type) VALUES (" . $_POST['textuser_id'] . "," . $_POST['textname'] . "," . $_POST['texttel_no'] . "," . $_POST['textemail'] . "," . $_POST['textaddress']  . "," . $_POST['textcity_code'] . "," . $_POST['textlogin_id'] . "," . $_POST['textpassword'] . "," . $_POST['textbalance'] . "," . $_POST['textuser_type'] . ");";
        try {
            $stmt = $this->db_instance->connection->prepare("INSERT INTO users (user_id, name, tel_no, email, address, city_code, login_id, password, balance, user_type) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssssss', $_POST['textname'], $_POST['texttel_no'], $_POST['textemail'], $_POST['textaddress'], $_POST['textcity_code'], $_POST['textlogin_id'], $_POST['textpassword'], $_POST['textbalance'], $_POST['textuser_type']);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error inserting user", $e->getMessage(), "\n";
        }
    }
}