<?php
session_start();
?>

<head>
    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<header ng-app="myApp" ng-controller="headerController">
    <nav class="navbar navbar-light bg-light navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#/!">SCS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navbar-left" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="#/!">Home</a>
                    <a class="nav-link" href="#!about">About Us</a>
                    <a class="nav-link" href="#!contact">Contact Us</a>
                    <a class="nav-link" href="#!reviews">Reviews</a>
                    <a class="nav-link" href="#!cart">Shopping Cart</a>
                    <a class="nav-link" href="#!faq">FAQ</a>
                    <a class="nav-link" href="#!balance">Buy Balance</a>
                    <a class="nav-link" href="#!services" tabindex="-1">Types of Services</a>
                </div>
            </div>
            <div ng-bind-html="buttons" id="buttons" class="nav navbar-nav navbar-right">

            </div>
        </div>
    </nav>
</header>