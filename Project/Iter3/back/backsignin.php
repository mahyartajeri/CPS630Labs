<?php
session_start();
// $_SESSION['user_type']='basic';

include_once './auth.php';
$auth = new AuthenticationClass();
$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']); //parse content_type string
if ($content_type_args[0] == 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

# Sign up success
if (isset($_POST['signup']) && $_POST['signup'] == "success") {
    echo "<h1>You have successfully signed up. Please sign in.";
}
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    $auth->logout();
}

if (isset($_POST['action'])) {
    // echo $_POST['username'], $_POST['password'];
    if ($_POST['action'] == 'login') {
        if ($auth->login($_POST['username'], $_POST['password'])) {
            echo "good";
            $userType = $auth->isAdmin($_POST['username']);
            $_SESSION['user_type'] = $userType;
        } else {
            echo "bad";
        }
    }
}
