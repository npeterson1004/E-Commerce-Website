<?php
// MongoDB connection
require __DIR__ . '/vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");

// Include common functions
include('functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <!-- Font link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <!-- Logo -->
        <img src="./images/elephant3d.png" alt="" class="logo">
        <!-- Navbar toggler button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navigation links -->
            <ul class="navbar-nav mr-auto">
                <!-- Home link -->
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <!-- Products link -->
                <li class="nav-item">
                    <a class="nav-link" href="display_all.php">Products</a>
                </li>
                <!-- Contact link -->
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <!-- Shopping cart link with item count -->
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item();?></sup></a>
                </li>
            </ul>
            <!-- Search form -->
            <form class="d-flex" action="search_product.php" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
            </form>
        </div>
    </nav>

    <!-- Calling Cart Function -->
    <?php
    cart();
    ?>

    <!-- Second Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <!-- Welcome message and admin link -->
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Welcome Guest</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="admin/index.php">Admin</a>
            </li>
        </ul>
    </nav>

    <!-- Third Section -->
    <div class="bg-light">
        <h3 class="text-center">3D Shop</h3>
        <p class="text-center">Welcome to the shop</p>
    </div>

    <!-- Fourth Section -->
    <div class="row">
        <div class="col-md-10">
            <!-- Products -->
            <div class="row">
                <!-- Fetching products -->
                <?php
                    getproducts();
                ?>
            </div>
            <!-- Row end -->
        </div>
        <!-- Col end -->
    </div>

    <!-- Last Section -->
    <!-- Include footer -->
    <?php include("./includes/footer.php") ?>
    
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>