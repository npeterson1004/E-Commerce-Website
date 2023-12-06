<?php
// MongoDB connection
require __DIR__ . '/../vendor/autoload.php';

try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $myDatabase = $mongoClient->selectDatabase('mystore');
} catch (MongoDB\Driver\Exception\Exception $e) {
    die('Error connecting to MongoDB: ' . $e->getMessage());
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['insert_product'])) {
    // Sanitize user inputs
    $product_title = htmlspecialchars($_POST['product_title']);
    $description = htmlspecialchars($_POST['description']);
    $product_keywords = htmlspecialchars($_POST['keywords']);
    $product_price = htmlspecialchars($_POST['product_price']);
    $product_status = 'true';

    // Accessing image
    $product_image = htmlspecialchars($_FILES['product_image']['name']);

    // Accessing image tmp name
    $product_image_tmp = $_FILES['product_image']['tmp_name'];

    // Checking for empty fields
    if (empty($product_title) || empty($description) || empty($product_keywords) || empty($product_price) || empty($product_image)) {
        echo "<script>alert('Please fill all the available fields')</script>";
        exit();
    } else {
        // Move the uploaded file to the product_images directory
        move_uploaded_file($product_image_tmp, "./product_images/$product_image");

        // MongoDB connection
        $myDatabase = $mongoClient->selectDatabase('mystore');
        $productsCollection = $myDatabase->selectCollection('products');

        // Insert product into MongoDB
        $insertedProduct = $productsCollection->insertOne([
            'product_title' => $product_title,
            'product_description' => $description,
            'product_keywords' => $product_keywords,
            'product_image' => $product_image,
            'product_price' => $product_price,
            'product_status' => $product_status,
        ]);

        if ($insertedProduct->getInsertedCount() > 0) {
            echo "<script>alert('Product has been inserted successfully')</script>";
        }
    }
    header('Location: ../admin');
    exit();
}

?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta https-equiv = "X-UA-Compatible" content= "IE-edge">
    <meta name =  "viewport" content = "width-device-width, initial-scale-1.0">

    <title>Insert Product-AdminDashboard</title>
    <!--bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
     crossorigin="anonymous">
    <!--Font link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS file -->
    <link rel="stylesheet" href="style.css">
    </head>
    <body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <!--form-->
        <form action="" method="post" enctype="multipart/form-data">
            <!--Title-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter Product title" autocomplete="off" required="required">
            </div>

            <!--Description-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Product Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Enter Product description" autocomplete="off" required="required">
            </div>

            <!--Keywords-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="keywords" class="form-label">Product Keywords</label>
                <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Enter Product keywords" autocomplete="off" required="required">
            </div>

     
           

            <!-- Image Upload -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" required="required">
            </div>

            <!-- Price (You may need to adjust this part based on your form structure) -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter Product price" autocomplete="off" required="required">
            </div>

            <!-- Submit Button -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
            </div>
        </form>
    </div>
</body>
</html>