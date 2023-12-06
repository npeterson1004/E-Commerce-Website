<?php
// MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->mystore;

// getting products
function getProducts() {
    global $db; // Assuming $db is your MongoDB connection

    
        // MongoDB query to get random products (equivalent to "order by rand() LIMIT 0,4" in MySQL)
        $products = $db->products->aggregate([
            ['$sample' => ['size' => 4]]
        ]);

        displayProducts($products);
    
}

// get all products
function getAllProducts() {
    global $db; // Assuming $db is your MongoDB connection

   
        // MongoDB query to get all products (equivalent to "order by rand()" in MySQL)
        $products = $db->products->find();

        displayProducts($products);
    
}

// common function to display products
function displayProducts($products) {
    foreach ($products as $document) {
        $product_id = $document['_id'];
        $product_title = $document['product_title'];
        $product_description = $document['product_description'];
        $product_image = $document['product_image'];
        $product_price = $document['product_price'];

        echo "<div class='col-md-4 mb-2'>
                <div class='card'>
                    <img src='./admin/product_images/$product_image' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text'>Price $$product_price</p>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add To Cart</a>
                        <a href='#' class='btn btn-secondary'>View More</a>
                    </div>
                </div>
            </div>";
    }
}

// get all products
function getAllAdminProducts() {
    global $db; // Assuming $db is your MongoDB connection

   
        // MongoDB query to get all products (equivalent to "order by rand()" in MySQL)
        $products = $db->products->find();

        displayadminProducts($products);
    
}

// common function to display products
function displayadminProducts($products) {
    foreach ($products as $document) {
        $product_id = $document['_id'];
        $product_title = $document['product_title'];
        $product_description = $document['product_description'];
        $product_image = $document['product_image'];
        $product_price = $document['product_price'];

        echo "<div class='col-md-4 mb-2'>
                <div class='card'>
                    <img src='../admin/product_images/$product_image' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text'>Price $$product_price</p>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add To Cart</a>
                        <a href='#' class='btn btn-secondary'>View More</a>
                    </div>
                </div>
            </div>";
    }
}



// search products function
function search_product() {
    global $db; // Assuming $db is your MongoDB connection

    if (isset($_GET['search_data_product'])) {
        $search_data_value = $_GET['search_data'];

        // MongoDB query to search for products
        $search_query = $db->products->find(['product_keywords' => new MongoDB\BSON\Regex($search_data_value, 'i')]);

        // Convert the cursor to an array
        $products = iterator_to_array($search_query);

        $num_of_rows = count($products);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger'>No Items for this Category</h2>";
        }

        foreach ($products as $document) {
            $product_id = $document['_id'];
            $product_title = $document['product_title'];
            $product_description = $document['product_description'];
            $product_image = $document['product_image'];
            $product_price = $document['product_price'];

            echo "<div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_image' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add To Cart</a>
                            <a href='#' class='btn btn-secondary'>View More</a>
                        </div>
                    </div>
                </div>";
        }
    }
}


// View Details Function
function view_details() {
    global $db; // Assuming $db is your MongoDB connection

    // condition to check isset or not
    if (isset($_GET['product_id'])) {
    
                $product_id = $_GET['product_id'];

                // MongoDB query to get product details by product_id
                $product = $db->products->findOne(['_id' => new MongoDB\BSON\ObjectId($product_id)]);

                echo "<div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin/product_images/{$product['product_image']}' class='card-img-top' alt='{$product['product_title']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$product['product_title']}</h5>
                                <p class='card-text'>{$product['product_description']}</p>
                                <p class='card-text'>Price ${$product['product_price']}</p>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add To Cart</a>
                                <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class='col-md-8'>
                        <!-- related images -->
                        <div class='row'>
                            <div class='col-md-12'>
                                <h4 class='text-center mb-5'>Related products</h4>
                            </div>
                            <div class='col-md-6'>
                                <img src='./admin/product_images/{$product['product_image']}' class='card-img-top' alt='{$product['product_title']}'>
                            </div>
                            <div class='col-md-6'>
                                <img src='./admin/product_images/{$product['product_image']}' class='card-img-top' alt='{$product['product_title']}'>
                            </div>
                        </div>  
                    </div>";
            }
        
    
}

// get IP address function
function getIPAddress() {
        //whether ip is from the share internet  
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
//whether ip is from the proxy  
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
 }  
//whether ip is from the remote address  
else{  
         $ip = $_SERVER['REMOTE_ADDR'];  
 }  
 return $ip;  
}
function cart() {
    if (isset($_GET['add_to_cart'])) {
        global $db;
        $get_ip_add = getIPAddress();
        $get_product_id = $_GET['add_to_cart'];

        // Ensure the provided product_id is a valid ObjectId
        if (!isValidObjectId($get_product_id)) {
            echo "<script>alert('Invalid product ID')</script>";
            echo "<script>window.open('index.php','_self')</script>";
            return;
        }

        // MongoDB query to check if the item is already in the cart
        $cartCollection = $db->selectCollection('cart_details');
        $cartItem = $cartCollection->findOne([
            'ip_address' => $get_ip_add,
            'product_id' => new MongoDB\BSON\ObjectId($get_product_id)
        ]);

        if ($cartItem) {
            echo "<script>alert('This item is already present inside the cart')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        } else {
            // MongoDB query to insert item into the cart
            $cartCollection->insertOne([
                'product_id' => new MongoDB\BSON\ObjectId($get_product_id),
                'ip_address' => $get_ip_add,
                'quantity' => 1,
            ]);

            echo "<script>alert('Item is added to the cart!')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }
    }
}

// Function to check if a string is a valid MongoDB ObjectId
function isValidObjectId($id) {
    return (is_string($id) && strlen($id) === 24 && ctype_xdigit($id));
}
function cart_item() {
    global $db;
    $cartCollection = $db->selectCollection('cart_details');
    $ip_address = getIPAddress();
    $result = $cartCollection->find(['ip_address' => $ip_address]);
    $count_cart_items = iterator_count($result);

    echo $count_cart_items;
}
function total_cart_price() {
    global $db;
    $get_ip_add = getIPAddress();
    $total = 0;

    // MongoDB query to get cart items
    $cartCollection = $db->selectCollection('cart_details');
    $cartItems = $cartCollection->find(['ip_address' => $get_ip_add]);

    foreach ($cartItems as $cartItem) {
        $product_id = $cartItem['product_id'];

        // Check if $product_id is a valid ObjectId
        if (!isValidObjectId($product_id)) {
            // Handle the case where $product_id is not a valid ObjectId
            continue;
        }

        // Fetch product data from MongoDB
        $productQuery = ['_id' => new MongoDB\BSON\ObjectId($product_id)];
        $productDocument = $db->products->findOne($productQuery);

        // Check if $productDocument is not null before accessing its properties
        if ($productDocument !== null) {
            $price_table = $productDocument['product_price'];
            $quantity = $cartItem['quantity'];
            $product_values = $price_table * $quantity;
            $total += $product_values;
        } else {
            ?>
            <tr>
                <td colspan="6" class="text-danger">Product not found for ID: <?php echo $product_id ?></td>
            </tr>
            <?php
        }
    }

    // Display the total after the loop
    ?>
    <tr>
        <td><?php echo number_format($total, 2) ?></td>
    </tr>
    <?php
}

// common function to remove item from cart
function removeCartItem($product_id) {
    global $db;

    // Check if $product_id is a valid ObjectId
    if (!isValidObjectId($product_id)) {
        // Handle the case where $product_id is not a valid ObjectId
        return;
    }

    $ip_address = getIPAddress();

    // MongoDB query to remove item from cart
    $cartCollection = $db->selectCollection('cart_details');
    $cartCollection->deleteOne([
        'ip_address' => $ip_address,
        'product_id' => new MongoDB\BSON\ObjectId($product_id)
    ]);

    echo "<script>alert('Item removed from the cart!')</script>";
    echo "<script>window.open('cart.php','_self')</script>";
}

?>
