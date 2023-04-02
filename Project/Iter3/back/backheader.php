<?php
include './auth.php';
try {
    $auth = new AuthenticationClass();
    if ($auth->authenticated() && $_SESSION['user_type'] == 'admin') {
        echo "<li class='nav-item dropdown'>";
        echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Dropdown</a>";
        echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
        echo "<a class='dropdown-item' href='./insert.php'>Insert</a>";
        echo "<a class='dropdown-item' href='./delete.php'>Delete</a>";
        echo "<a class='dropdown-item' href='./select.php'>Select</a>";
        echo "<a class='dropdown-item' href='./update.php'>Update</a>";
        echo "</div>";
        echo "</li>";
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
