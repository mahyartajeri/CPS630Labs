<?php
include './auth.php';
session_start();
try {
    $auth = new AuthenticationClass();
    if ($auth->authenticated() && $_SESSION['user_type'] == 'admin') {
        echo "
        <li class='nav-item dropdown'>
            <a ng-click='toggleFunction()' class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>DB Management</a>
            <div class='dropdown-menu' aria-labelledby='navbarDropdown' style='display: none'>
                <a class='dropdown-item' href='#!insert'>Insert</a>
                <a class='dropdown-item' href='#!delete'>Delete</a>
                <a class='dropdown-item' href='#!select'>Select</a>
                <a class='dropdown-item' href='#!update'>Update</a>
            </div>
         </li>";
    }
} catch (Exception $e) {
    echo "Exception: ", $e->getMessage(), "\n";
}

try {
    $auth = new AuthenticationClass();
    if ($auth->authenticated()) {
        echo "<div class='search-container'>

                                <input class='search expandright' id='searchright' type='search' name='order_id' placeholder='Order ID'>
                             
                                <label class='button searchbutton' for='searchright'><span class='mglass'>&#9906;</span></label>
                            </div>";


        echo "<button id='logout' class='nav-link btn btn-warning text-light'>Logout</button>";
    } else {

        echo "<a class='nav-link btn btn-primary text-light'  href='#!signin'>Login</a>";
        echo "<a class='nav-link btn btn-success text-light' href='#!signup'>Sign-up</a>";
    }
} catch (Exception $e) {
    echo "Exception: ", $e->getMessage(), "\n";
}
