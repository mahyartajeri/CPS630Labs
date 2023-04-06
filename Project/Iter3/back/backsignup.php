<?php
include_once './database.php';
$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']); //parse content_type string
if ($content_type_args[0] == 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);
}
if (isset($_POST['action']) && $_POST['action'] == "signup") {
    $success = TRUE;
    if (!isset($_POST['username'])) {
        $success=FALSE;
        echo "<h1>Error: No username entered</h1>";
    }
    if (!isset($_POST['password'])) {
        $success=FALSE;
        echo "<h1>Error: No password entered</h1>";
    }
    if (!isset($_POST['name'])) {
        $success=FALSE;
        echo "<h1>Error: No name entered</h1>";
    }
    if (!isset($_POST['tel'])) {
        $success=FALSE;
        echo "<h1>Error: No telephone entered</h1>";
    }
    if (!isset($_POST['address'])) {
        $success=FALSE;
        echo "<h1>Error: No address entered</h1>";
    }
    if (!isset($_POST['email'])) {
        $success=FALSE;
        echo "<h1>Error: No email entered</h1>";
    }
    if (!isset($_POST['postal'])) {
        $success=FALSE;
        echo "<h1>Error: No postal code entered</h1>";
    }

    if ($success == TRUE){
        signup($_POST['username'], $_POST['password'], $_POST['name'], $_POST['tel'], $_POST['address'], $_POST['email'], $_POST['postal']);
    }
}

function signup($username, $password, $name, $telephone, $address, $email, $postal)
{
    $success = TRUE;
    $pattern = "/^[A-z0-9]+$/";
    if (!preg_match($pattern, $username)) {
        $success = FALSE;
        echo "<h1>Error: Username is invalid (Alphanumeric)</h1>";
    }
    $pattern = "/^[^\s]+$/";
    if (!preg_match($pattern, $password)) {
        $success = FALSE;
        echo "<h1>Error: Password is invalid. No spaces allowed</h1>";
    }

    $pattern = "/^[A-z]+[A-z ]+$/";
    if (!preg_match($pattern, $name)) {
        $success = FALSE;
        echo "<h1>Error: Name is invalid (Alphabet and spaces only)</h1>";
    }
    $pattern = "/^[A-z ]+$/";

    $pattern = "/^[0-9]{10}$/";
    if (!preg_match($pattern, $telephone)) {
        $success = FALSE;
        echo "<h1>Error: Phone is invalid. Format: 1234567890</h1>";
    }
    $pattern = "/^[#.0-9a-zA-Z\s,-]+$/";
    if (!preg_match($pattern, $address)) {
        $success = FALSE;
        echo "<h1>Error: Address is invalid. Format: Alphanumeric and spaces only</h1>";
    }
    $pattern = "/^\S+@\S+.\S+$/";
    if (!preg_match($pattern, $email)) {
        $success = FALSE;
        echo "<h1>Error: Email is invalid. Format: abc123@123abc.com</h1>";
    }
    $pattern = "/^[A-z0-9]+$/";
    if (!preg_match($pattern, $postal)) {
        $success = FALSE;
        echo "<h1>Error: Email is invalid. Format: abc123@123abc.com</h1>";
    }



    if ($success == TRUE) {
        try {
            # sql stuff to add stuff
            $db_instance = new DatabaseClass("localhost", "root", "", "cps630");
            // if($connect){
            //     print("Connection Established Successfully<br>");
            // }else{
            //     print("Connection Failed <br>");
            // }
            if (mysqli_num_rows($db_instance->execute_query("SELECT * FROM users WHERE login_id = '${username}'")) > 0) {
                echo "<h1>Username taken choose another username</h1>";
            } else {
                $bytes = random_bytes(5);
                $salt = bin2hex($bytes);

                $securePass = md5($password . $salt);
                $encryptedBalance = openssl_encrypt(0, "AES-128-CTR", $salt, 0, '1234567891011121');
                $stmt = $db_instance->connection->prepare("INSERT INTO users (login_id, password, name, email, address, city_code, tel_no, balance, user_type, salt) VALUES (?,?,?,?,?,?,?,?,'basic',?)");
                $stmt->bind_param('sssssssss', $username, $securePass, $name, $email, $address, $postal, $telephone, $encryptedBalance, $salt);
                $stmt->execute();
            }
            echo "good";
        } catch (Exception $e) {
            echo "Error creating user account", $e->getMessage(), "\n";
        }
        exit();
    }
}
