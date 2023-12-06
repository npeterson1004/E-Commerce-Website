<?php
// MongoDB connection
require __DIR__ . '/vendor/autoload.php';

try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $myDatabase = $mongoClient->selectDatabase('mystore');
} catch (MongoDB\Driver\Exception\Exception $e) {
    die('Error connecting to MongoDB: ' . $e->getMessage());
}

include('functions/common_function.php');
$total=0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Cart</title>
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

    <style>
        .cart_img{
    width:80px;
    height:80px;
    object-fit:contain;
}
    </style> 


</head>
<body>
 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <img src="./images/elephant3d.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="display_all.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item();?></sup></a>
                </li>
                
            </ul>
            
        </div>
    </nav>

  

    <!--Calling Cart Function-->
    <?php
    cart();
    ?>

     <!-- Second Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Welcome Guest</a>
            </li>
         
            <li class="nav-item active">
                    <a class="nav-link" href="admin\index.php">admin </a>
                </li>
        </ul>
    </nav>

    <!-- Third Section -->
    <div class="bg-light">
        <h3 class="text-center">3D Shop</h3>
        <p class="text-center">Welcome to the shop</p>
    </div>

 <!-- Fourth Section -->
<div class="container">
    <div class="row">
        <form action="" method="post">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Product Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                        <th colspan="2"> Operations </th>
                    </tr>
                </thead>
                <tbody>

                    <!--Diplay dynamic data-->
                    <?php
                    // Fetch cart data from MongoDB
                    $get_ip_add = getIPAddress();
                    $cartQuery = ['ip_address' => $get_ip_add];
                    $cartCursor = $db->cart_details->find($cartQuery);
                    ?>

                    <?php foreach ($cartCursor as $cartDocument) : ?>
                        <?php
                        $product_id = $cartDocument['product_id'];

                        // Fetch product data from MongoDB
                        $productQuery = ['_id' => new MongoDB\BSON\ObjectId($product_id)];
                        $productDocument = $db->products->findOne($productQuery);

                        // Check if $productDocument is not null before accessing its properties
                        if ($productDocument !== null) {
                            $product_title = $productDocument['product_title'];
                            $product_image = $productDocument['product_image'];
                            // Convert $price_table to a numeric type using floatval() or intval()
                            $price_table = floatval($productDocument['product_price']);
                            $quantity = $cartDocument['quantity'];
                            $product_values = $price_table * $quantity;
                            $total += $product_values;
                            // Inside the loop, you use $product_title, $price_table, etc., to access the fields of each document
                        ?>
                            <tr>
                                <td><?php echo $product_title ?></td>
                                <td><img src="./admin/product_images/<?php echo $product_image ?>" alt="" class="cart_img"></td>
                                <td><input type="text" name="qty[]" value="<?php echo $quantity ?>" class="form-input w-50"></td>
                                <td><?php echo $price_table ?></td>
                                <td>
                                    <input type="hidden" name="product_id[]" value="<?php echo $product_id ?>">
                                    <input type="checkbox" name="remove_checkbox[]">
                                </td>
                                <td>
                                    <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                                
                                </td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td colspan="6" class="text-danger">Product not found for ID: <?php echo $product_id ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </form>
        <?php
        // After the foreach loop, handle the removal of the item
        if (isset($_POST['update_cart'])) {
            $remove_checkboxes = isset($_POST['remove_checkbox']) ? $_POST['remove_checkbox'] : array();

            foreach ($remove_checkboxes as $index => $remove_checkbox) {
                if ($remove_checkbox == 'on') {
                    $remove_product_id = $_POST['product_id'][$index];
                    $removeResult = removeCartItem($remove_product_id);
                }
            }

            // Display an alert based on the result of the removeCartItem function
            echo "<script>alert('" . $removeResult['message'] . "')</script>";
            echo "<script>window.open('cart.php','_self')</script>";
        }
        ?>





            <!-- SubTotal -->
            <div class="d-flex mb-5">
                <h4 class="px-3">Subtotal:<strong class="text-info"><?php echo $total ?></strong></h4>
                <a href="display_all.php"><button class="bg-info px-3 py-2 border-0 mx-3">Continue Shopping</button></a>
                <a href="#"><button class="bg-secondary p-3 py-2 border-0 text-light">Checkout</button></a>
            </div>
        </form>
    </div>
</div>

    <!-- Last Section -->
    <!--include footer-->
    <?php include("./includes/footer.php") ?>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
