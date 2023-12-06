<?php
// MongoDB connection
require __DIR__ . '/../vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$myDatabase = $mongoClient->selectDatabase('mystore');

?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta https-equiv = "X-UA-Compatible" content= "IE-edge">
    <meta name =  "viewport" content = "width-device-width, initial-scale-1.0">
    <title>Admin Dashboard</title>

    <!--bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
     crossorigin="anonymous">


     <!--Font link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--css file -->
     <link rel="stylesheet" href="../style.css">

        <style>
     .footer{
        position:absolute;
        bottom:0;
     }
    </style>

</head>
<body>
        <!--NAVBAR -->
        <div class="container-fluid p-0">
            <!--First-->
            <nav class="navbar navbar-expand-lg navbar-light bg-info">
                <div class="container-fluid">
                    <img src="../images/admin.png" alt="" class="logo">
                    <nav class="navbar navbar-expand-lg">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href ="" class = "nav-link" >Welcome admin </a>
                            </li>
                        </ul>
                </nav>
                </div>
            </nav>
            <!--Second-->
            <div class="bg-light">
                <h3 class="text-center p-2">Manage Details</h3>
            </div>

             <!--Third-->
             <div class="row">
                <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                    <div class="p-3">
                        <a href ="#"><img src="../images/admin.png" alt="" class="admin_image"></a>
                        <p class="text-light text-center">Admin Name</p>
                    </div>
                    
                    <div class="button text-center">
                        <button class="my-3"><a href="insert_product.php" class="nav-link text-light 
                        bg-info my-1">Insert Products</a></button>
                        <button><a href="view_products.php" class="nav-link text-light 
                        bg-info my-1">View Products</a></button>
                        <button><a href="../index.php" class="nav-link text-light 
                        bg-info my-1">Go Home</a></button>
                        

                </div>
            </div>



            <!--Last -->

            <div class ="bg-info p-3 text-center footer">
                <p>All Rights Reserved ⓒ- Nathan Peterson 2023</p>
            <div>

        </div>



<!--bootstrap js link -->
  <!--bootstrap js link -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous"></script>

</body>
</html>