<?php
include_once 'database.php';
class AuthenticationClass
{
  private $db_instance;
  private $isAdmin = 'basic';

  public function __construct()
  {
    $this->db_instance = new DatabaseClass();
  }
  public function login($username, $password)
  {
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
    try {
      $result = $this->db_instance->execute_query("SELECT password, user_id, user_type FROM users
                                                        WHERE login_id = '${username}';");
      $row = $this->db_instance->return_first_row($result);

      if ($row > 0) {
        if ($row["password"] == $_POST['password']) {
          setcookie('userid', $row["user_id"], time() + 86400); # times out in 1 day
          return TRUE;
        } else {
          return FALSE; #bad pass
        }
      } else {
        return FALSE; #bad username
      }
    } catch (Exception $e) {
      echo "Error authenticating sign-in", $e->getMessage(), "\n";
    }
  }
  public function logout()
  {
    unset($_COOKIE['userid']);
    setcookie('userid', '', time() - 3600); // empty value and old timestamp
    if (isset($_COOKIE["userid"])) {
      echo "OOPS";
    }
    header("refresh:0;url=signin.php");
  }
  public function authenticated()
  {
    if (isset($_COOKIE['userid'])) {
      return TRUE;
    }
    return FALSE;
  }

  public function isAdmin($username) {
    $sql = "SELECT user_type FROM users WHERE login_id = '${username}';";
    try{
      $result = $this->db_instance->execute_query($sql)->fetch_assoc();
      $user = $result["user_type"];
      
      if($user){
        return $user;
      }else {
        return 'basic';
      }
    
    } catch (Exception $e) {
      echo "Error confirming user type", $e->getMessage(), "\n";
    }
  }
}
