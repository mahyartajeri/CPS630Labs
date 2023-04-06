<?php
session_start();
// $_SESSION['user_type']='basic';

include_once './auth.php';
$auth = new AuthenticationClass();
$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']); //parse content_type string
if ($content_type_args[0] == 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == "buyBalance") {
        buyBalance($_POST['cardNumber'], $_POST['cardName'], $_POST['expiryDate'], $_POST['cvv'], $_POST['balance']);
    }
    if ($action == "getBalance")
    {
        getBalance();
    }

}


function buyBalance($cardNumber, $name, $cardExp, $cardCVV, $balance){
    $success = TRUE;
    $pattern = "/^[0-9]{16}$/";
    if (!preg_match($pattern, $cardNumber)) {
        $success = FALSE;
        echo "<h1>Error: Card number is invalid</h1>";
    }
    $pattern = "/^[A-z]+[A-z ]+$/";
    if (!preg_match($pattern, $name)) {
        $success = FALSE;
        echo "<h1>Error: Name is invalid. (Alphabet and spaces only)</h1>";
    }
    $pattern = "/^[0-1][0-9]\/[2-3][0-9]$/";
    if (!preg_match($pattern, $cardExp)) {
        $success = FALSE;
        echo "<h1>Error: Expiry date is invalid. (mm/yy)</h1>";
    }
    $pattern = "/^[0-9]{3}$/";
    if (!preg_match($pattern, $cardCVV)) {
        $success = FALSE;
        echo "<h1>Error: CVV is invalid. (3 digits)</h1>";
    }
    $pattern = "/^[0-9]+$/";
    if (!preg_match($pattern, $balance)) {
        $success = FALSE;
        echo "<h1>Error: Balance is invalid.  (numbers only)</h1>";
    }

    if ($success == TRUE) {
        try {
            # sql stuff to add stuff
            $db_instance = new DatabaseClass();
            
            # grab encrypted balance
            $saltsql = $db_instance->connection->prepare("SELECT salt, balance FROM users WHERE user_id = ?");
            $saltsql->bind_param('i', $_COOKIE["userid"]);
            $saltsql->execute();
            $result = $saltsql->get_result()->fetch_assoc();
            $salt = $result["salt"];

            $decryptedBalance = openssl_decrypt($result['balance'], "AES-128-CTR", $salt, 0, '1234567891011121');
            $newBalance = (float)$decryptedBalance + (float)$balance;
            $newBalance = round($newBalance,2);
            $encryptedBalance = openssl_encrypt($newBalance, "AES-128-CTR", $salt, 0, '1234567891011121');
            $stmt = $db_instance->connection->prepare("UPDATE users SET balance = ? WHERE user_id = ?");
            $stmt->bind_param('ss', $encryptedBalance, $_COOKIE["userid"]);
            $stmt->execute();

            
            echo "good";
        } catch (Exception $e) {
            echo "Error updating adding balance", $e->getMessage(), "\n";
        }
        exit();
    }
}

function getBalance(){
    try {
        # sql stuff to add stuff
        $db_instance = new DatabaseClass();
        
        # grab encrypted balance
        $saltsql = $db_instance->connection->prepare("SELECT salt, balance FROM users WHERE user_id = ?");
        $saltsql->bind_param('i', $_COOKIE["userid"]);
        $saltsql->execute();
        $result = $saltsql->get_result()->fetch_assoc();
        $salt = $result["salt"];

        $decryptedBalance = openssl_decrypt($result['balance'], "AES-128-CTR", $salt, 0, '1234567891011121');
        
        echo $decryptedBalance;

    } catch (Exception $e) {
        echo "Error getting balance", $e->getMessage(), "\n";
    }
}
