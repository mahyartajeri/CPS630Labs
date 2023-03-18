<head>
    <link href="style.css" rel="stylesheet" />
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
                </div>
            </div>
            <div class="nav navbar-nav navbar-right">
                <?php
                include './back/auth.php';
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