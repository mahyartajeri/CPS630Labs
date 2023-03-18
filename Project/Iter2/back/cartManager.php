<?php
include "./cart.php";
if (isset($_POST["action"])) {
    $cart = new CartClass();
    $action = $_POST["action"];
    if ($action == 'ADD') {
        $cart->add($_POST["id"]);
    } else if ($action == 'REMOVE') {
        $cart->remove($_POST["id"]);
    } else if ($action == 'UPDATE') {
        $cart->update($_POST["id"], $_POST["num"]);
    } else if ($action == 'PURCHASE') {
        $cart->placeOrder();
    } else if ($action == 'CLEAR') {
        $cart->clearCart();
    } else if ($action == 'TOTAL') {
        $cart->getTotal();
    }
}
