<?php
include_once 'database.php';
include_once 'items.php';
class reviewsClass
{

        private $db_instance;
        private $shoppingCart;


        public function __construct()
        {
                $this->db_instance = new DatabaseClass();
        }

        public function show()
        {
                try {
                        $sql = "SELECT * FROM reviews, items, users WHERE reviews.user_id = users.user_id AND reviews.item_id = items.item_id;";
                        $results = $this->db_instance->execute_query($sql);
                        while ($row = mysqli_fetch_assoc($results)) {
                                echo "<li style='border:1px solid black;' id=" . $row["id"] . "class='list-group-item item'> ITEM PURCHASED: <strong>" . $row["item_name"] . "</strong><br>NAME: <strong>" . $row["name"] . "</strong><br>RANK: <strong>" . $row["rank"] . "/5 </strong> Stars<br>DESCRIPTION:<p>" . $row["description"] . "</p></li>";
                        }
                } catch (Exception $e) {
                        echo "Error showing reviews:", $e->getMessage();
                }
        }

        public function add($item_id, $rank, $description)
        {
                try {
                        $sql = "INSERT INTO reviews(item_id, user_id, rank, description) VALUES(" . $item_id . ", " . $_COOKIE["userid"] . ", " . $rank . ", '" . $description . "');";

                        $this->db_instance->execute_query($sql);
                } catch (Exception $e) {
                        echo "Error adding to reviews:", $e->getMessage();
                }
        }
}
