<?php

include_once './search.php';


$search_instance = new SearchClass();
$auth = new AuthenticationClass();

if ($auth->authenticated() && isset($_POST['order_id'])) {
        $order = $search_instance->getOrder($_POST['order_id']);
        $trip = $search_instance->getShippingInfo($_POST['order_id']);
        if ($order) {
                echo '
                <div class="container">
                        <div class="row">
                                <div class="col-md">
                                        <table>
                                                <tr>
                                                        <th>Order ID</th>
                                                        <th>Date issued</th>
                                                        <th>Date Received</th>
                                                        <th>Total Price</th>
                                                </tr>
                                                <tr>
                                                        <?php
                                                        echo "<td>" . $order["order_id"] . "</td>";
                                                        echo "<td>" . $order["date_issued"] . "</td>";
                                                        echo "<td>" . $order["date_received"] . "</td>";
                                                        echo "<td>" . $order["total_price"] . "</td>";
                                                        ?>
                                                </tr>
                                        </table>
                                </div>
                                <div class="col-md">
                                        <table>
                                                <tr>
                                                        <th>Originating Postal Code</th>
                                                        <th>Destination Postal Code</th>
                                                        <th>Distance</th>
                                                        <th>Truck Number</th>
                                                        <th>Shipping Cost</th>
                                                </tr>
                                                <tr>
                                                        <?php
                                                        echo "<td>" . $trip["source_code"] . "</td>";
                                                        echo "<td>" . $trip["destination_code"] . "</td>";
                                                        echo "<td>" . $trip["distance"] . "</td>";
                                                        echo "<td>" . $trip["truck_id"] . "</td>";
                                                        echo "<td>" . $trip["price"] . "</td>";
                                                        ?>
                                                </tr>
                                        </table>
                                </div>
                        </div>
                </div>';
        } else {
                echo "<h3> No order:" . $_POST['order_id'] . " found for current user </h3>";
        }
} else {
        echo "<h3> No order requested </h3>";
}


echo '
<div class="container-fluid text-center my-5">
        <h1 class="display-1">Past Orders</h1>
</div>
<table class="list-group">
        <tr>
                <th>Order ID</th>
                <th>Date issued</th>
                <th>Date Received</th>
                <th>Total Price</th>
        </tr>';

if ($auth->authenticated()) {
        $orders = $search_instance->searchOrders($auth->getUserID());
        foreach ($orders as $order) {
                echo "<tr class='clickable-row' data-orderid='" . $order['order_id'] . "'>";
                echo "<td>" . $order['order_id'] . "</td>";
                echo "<td>" . $order['date_issued'] . "</td>";
                echo "<td>" . $order['date_received'] . "</td>";
                echo "<td>" . $order['total_price'] . "</td>";
                echo "</tr>";
        }
}
