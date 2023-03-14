<?php
include_once 'database.php';
class AuthenticationClass {
    private $db_instance;


    public function __construct () {
        $this->db_instance = new DatabaseClass();
    }
    public function login($username, $password){
        $pattern = "/^[A-z0-9]+$/";
        # Check inputs
        if (!preg_match($pattern, $username)) {
          $success = FALSE;
          echo "<h1>Wrong Username</h1>";
        }
        $pattern = "/^[^\s]+$/";
        if (!preg_match($pattern, $password)) {
          $success = FALSE;
          echo "<h1>Wrong Password</h1>";
        }

        $result = $this->db_instance->execute_query("SELECT Password FROM users
                                                        WHERE LoginId = '${username}';");
        $row = $this->db_instance->return_first_row($result);

        if ($row > 0) {
            if ($row["Password"]==$_POST['password'])
            {
              setcookie('userid', $_POST['username'], time()+86400); # times out in 1 day
              return TRUE;
            }
            else {
              return FALSE; #bad pass
            }
          }
          else{
            return FALSE; #bad username
          }
    }
    public function logout() {
        unset($_COOKIE['userid']);
        setcookie('userid', '', time() - 3600, '/'); // empty value and old timestamp
        header("refresh:0;url=signin.php");
    }
    public function authenticated() {
        if (isset($_COOKIE['userid'])){
            return TRUE;
        }
        return FALSE;
    }
}
?>