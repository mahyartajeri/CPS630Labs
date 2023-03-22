<?php
include_once 'database.php';
class MaintainClass
{
    private $db_instance;
  
    public function __construct()
    {
      $this->db_instance = new DatabaseClass();
    }

    public function getDbTables(){
        $sql = "SHOW Tables from cps630;";
        try {
            $result = $this->db_instance->execute_query($sql);
            return $result;
        } catch (Exception $e) {
            echo "Error getting tables", $e->getMessage(), "\n";
        }
    }

    public function insertEntry($table){
        $sql = "DESCRIBE ". $table;
        try {
            $result = $this->db_instance->execute_query($sql);
            return $result;
        } catch (Exception $e) {
            echo "Error getting tables", $e->getMessage(), "\n";
        }
    }
}