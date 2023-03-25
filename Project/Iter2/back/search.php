<?php
include_once 'database.php';
include_once 'auth.php';

class SearchClass{
    private $db_instance;
    private $auth;
  
    public function __construct()
    {
      $this->db_instance = new DatabaseClass();
      $this->auth = new AuthenticationClass();
    }

    public function searchOrders($userid) {
        if ($this->auth->authenticated()){
            $sql = "SELECT * FROM orders 
            WHERE user_id = ${userid}
            ORDER BY order_id DESC";
            try {
                $result=$this->db_instance->execute_query($sql);
            } catch (Exception $e) {
                echo "Error searching", $e->getMessage(), "\n";
            }
            
            return $this->db_instance->return_all_rows($result);

        }
        else{
            return [];
        }
    }

    public function getOrder($oid) {
        if ($this->auth->authenticated()){
            $userId = $this->auth->getUserId();
            $sql = "SELECT * FROM orders 
            WHERE user_id = ${userId}
            AND order_id = ${oid}";
            try {
                $result=$this->db_instance->execute_query($sql);
                return $this->db_instance->return_first_row($result);
            } catch (Exception $e) {
                echo "Error searching", $e->getMessage(), "\n";
                return false;
            }

        }
        else{
            return FALSE;
        }
    }

    public function getShippingInfo($oid) {
        if ($this->auth->authenticated()){
            if ($order = $this->getOrder($oid) ){
                $sql = "SELECT * FROM trips
                WHERE trip_id =".$order['trip_id'];
                try {
                    $result=$this->db_instance->execute_query($sql);
                    return $this->db_instance->return_first_row($result);
                } catch (Exception $e) {
                    echo "Error searching", $e->getMessage(), "\n";
                    return false;
                }
            }
            

        }
        else{
            return FALSE;
        }
    }
}

if (isset($_POST['userid'])) {
    $search_instance = new SearchClass();
    $userId = $_POST['userid'];

    $rows = $search_instance->searchOrders($userId);
    $html ='<ul class="list-group" style="margin-top:-15px;">';
    $html .= '<li class="list-group-item">Sorry! No record found</li>';
    if ($rows != FALSE) {
        foreach ($rows as $row)
        {
            $html .= "<li class='list-group-item'><a>" . $row['order_id'] . "</a></li>";
        }
        
    } else {
          $html .= '<li class="list-group-item">Sorry! No record found</li>';
    }
    $html .= "</ul>";
    echo $html;
} 



?>