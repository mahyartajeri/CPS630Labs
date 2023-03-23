<?php
session_start();
?>
<head>
    <link href="style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<header>
    <nav class="navbar navbar-light bg-light navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">SCS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navbar-left" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="./index.php">Home</a>
                    <a class="nav-link" href="./about.php">About Us</a>
                    <a class="nav-link" href="./contact.php">Contact Us</a>
                    <a class="nav-link" href="#">Reviews</a>
                    <a class="nav-link" href="./shopping.php">Shopping Cart</a>
                    <a class="nav-link" href="./services.php" tabindex="-1">Types of Services</a>
                    <?php
                        include './back/auth.php';
                        try {
                            $auth = new AuthenticationClass();
                            if ($_SESSION['user_type'] == 'admin' && $auth->authenticated()) {
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
                        ?>
                    
                </div>
            </div>
            <div class="nav navbar-nav navbar-right">
                <?php
                #include './back/auth.php';
                try {
                    $auth = new AuthenticationClass();
                    if ($auth->authenticated()) {
                        echo "<a class='nav-link' href='./signin.php?action=logout'>Logout</a>";
                    } else {
                        echo "<a class='nav-link' href='./signin.php'>Login</a>";
                        echo "<a class='nav-link' style='background-color: cornflowerblue;
                    border-radius: 10px; color: white;' href='./signup.php'>Sign-up</a>";
                    }
                } catch (Exception $e) {
                    echo "Exception: ", $e->getMessage(), "\n";
                }
                ?>
            </div>
        </div>
    </nav>
</header>