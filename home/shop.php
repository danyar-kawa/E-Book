<?php

include '../includes/header.php';

session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if ($_SESSION['user_id']) {
        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = 'Already added to cart!';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
            $message[] = 'Product added to cart!';
        }
    } else {
        header('location:/what/sadFinal/home/login.php');
        exit();
    }
}

include '../includes/nav.php'; ?>

<!-- Heading Section -->
<div class="heading text-center py-5">
    <h3>Our Shop</h3>
    <p><a href="/what/sadFinal/index.php">Home</a> / Shop</p>
</div>

<!-- Products Section -->
<section class="products py-5">
    <div class="container">
        <h1 class="title text-center mb-4">Latest Products</h1>
        <div class="row">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <form action="" method="post" class="card shadow-sm border-light">
                            <img class="card-img-top" src="../uploaded_img/<?php echo $fetch_products['image']; ?>" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                                <p class="card-text">$<?php echo $fetch_products['price']; ?>/-</p>
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" min="1" name="product_quantity" value="1" class="form-control" id="quantity">
                                </div>
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                <button type="submit" class="btn btn-primary w-100 mt-3" name="add_to_cart">Add to Cart</button>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty text-center">No products added yet!</p>';
            }
            ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>