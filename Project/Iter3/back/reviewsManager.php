<?php

include_once "reviewsBack.php";
include_once "items.php";
$content_type_args = explode(';', $_SERVER['CONTENT_TYPE']); //parse content_type string
if ($content_type_args[0] == 'application/json') {
        $_POST = json_decode(file_get_contents('php://input'), true);
}

if (isset($_POST["show"])) {
        $reviewsClass = new reviewsClass();
        $reviewsClass->show();
} else if (isset($_POST["add"])) {
        include_once './auth.php';
        $auth = new AuthenticationClass();
        if ($auth->authenticated()) {
                $reviewsClass = new reviewsClass();
                $reviewsClass->add($_POST["item_id"], $_POST["rank"], $_POST["description"]);
                $reviewsClass->show();
        }
        else {
                $rtn = array("error" => "Unauthorized");
                http_response_code("403");
                print json_encode($rtn);
            }

} else if (isset($_POST["options"])) {
        $itemsClass = new itemsClass();
        $itemsClass->optionItems();
}
