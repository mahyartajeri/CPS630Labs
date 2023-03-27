<?php
include "./cart.php";

$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']); //parse content_type string
if ($content_type_args[0] == 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

if (isset($_POST["action"])) {
    $cart = new CartClass();
    $action = $_POST["action"];
    if ($action == 'ADD') {
        $cart->add($_POST["id"]);
    } else if ($action == 'REMOVE') {
        $cart->remove($_POST["id"]);
        $cart->show();
    } else if ($action == 'UPDATE') {

        $cart->update($_POST["id"], $_POST["num"]);
        $cart->show();
    } else if ($action == 'PURCHASE') {
        $cart->placeOrder($_POST["source_code"], $_POST["destination_code"], $_POST["distance"], $_POST["date_issued"]);
    } else if ($action == 'CLEAR') {
        $cart->clearCart();
        $cart->show();
    } else if ($action == 'TOTAL') {
        $cart->getTotal();
    }
} else if (isset($_POST["show"])) {
    $cart = new CartClass();
    $cart->show();
}
