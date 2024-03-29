<?php
class DatabaseClass
{
    private $host;
    private $username;
    private $db;
    public $connection;
    public function __construct($host = "localhost", $username = "root", $password = "", $db = "cps630")
    {
        $this->host = $host;
        $this->username = $username;
        $this->db = $db;
        $this->connection = mysqli_connect($host, $username, $password, $db) or die(mysqli_error());
    }

    public function execute_query($sql)
    {
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }

    public function return_first_row($result)
    {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        }
        return false;
    }
    public function return_all_rows($result)
    {
        if (mysqli_num_rows($result) > 0) {
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        return [];
    }
}
