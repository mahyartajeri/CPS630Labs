<?php
include_once "cart.php";

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
        include_once './auth.php';
        $auth = new AuthenticationClass();
        if ($auth->authenticated()) {
            $result=$cart->placeOrder($_POST["source_code"], $_POST["destination_code"], $_POST["distance"], $_POST["date_issued"]);
            if (!$result) {
                trigger_error("Balance too low");
                $rtn = array("error" => "Balance too low");
                http_response_code("406");
                print json_encode($rtn);
            }
            else{
                $rtn = array("orderid" => $result);
                http_response_code("200");
                print json_encode($rtn);
            }
        }
        else {
            $rtn = array("error" => "Unauthorized");
            http_response_code("403");
            print json_encode($rtn);
        }
    } else if ($action == 'CLEAR') {
        $cart->clearCart();
        $cart->show();
    } else if ($action == 'TOTAL') {
        $cart->getTotal();
    } else if ($action == 'TOTALWSHIPPING') {
        $cart->getTotalWShipping();
    }
} else if (isset($_POST["show"]) && isset($_COOKIE["userid"])) {
    $cart = new CartClass();
    $cart->show();
}
