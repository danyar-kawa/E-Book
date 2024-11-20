<?php

include 'header.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['order_btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if ($cart_total == 0) {
        $message[] = 'Your cart is empty';
    } else {
        if (mysqli_num_rows($order_query) > 0) {
            $message[] = 'Order already placed!';
        } else {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $message[] = 'Order placed successfully!';
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        }
    }
}

?>

<div class="container mt-5">
    <div class="text-center">
        <h3>Checkout</h3>
        <p><a href="index.php">Home</a> / Checkout</p>
    </div>

    <section class="display-order my-4">
        <h4 class="text-center">Order Summary</h4>

        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $total_price;
        ?>
                <p class="text-center"> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$' . $fetch_cart['price'] . '/-' . ' x ' . $fetch_cart['quantity']; ?>)</span> </p>
        <?php
            }
        } else {
            echo '<p class="text-center">Your cart is empty.</p>';
        }
        ?>
        <div class="text-center font-weight-bold">Grand Total: <span>$<?php echo $grand_total; ?>/-</span></div>
    </section>

    <section class="checkout mb-5">
        <form action="" method="post" class="p-4 border rounded bg-light">
            <h4 class="text-center mb-4">Place Your Order</h4>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" id="name" required class="form-control" placeholder="Enter your name">
                </div>
                <div class="form-group col-md-6">
                    <label for="number">Your Number</label>
                    <input type="number" name="number" id="number" required class="form-control" placeholder="Enter your number">
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Your Email</label>
                    <input type="email" name="email" id="email" required class="form-control" placeholder="Enter your email">
                </div>
                <div class="form-group col-md-6">
                    <label for="method">Payment Method</label>
                    <select name="method" id="method" class="form-control">
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit card">Credit Card</option>
                        <option value="paypal">Paypal</option>
                        <option value="paytm">Paytm</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="flat">Address Line 01</label>
                    <input type="number" min="0" name="flat" id="flat" required class="form-control" placeholder="e.g. flat no.">
                </div>
                <div class="form-group col-md-4">
                    <label for="street">Street</label>
                    <input type="text" name="street" id="street" required class="form-control" placeholder="e.g. street name">
                </div>
                <div class="form-group col-md-4">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" required class="form-control" placeholder="e.g. Mumbai">
                </div>
                <div class="form-group col-md-4">
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" required class="form-control" placeholder="e.g. Maharashtra">
                </div>
                <div class="form-group col-md-4">
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" required class="form-control" placeholder="e.g. India">
                </div>
                <div class="form-group col-md-4">
                    <label for="pin_code">Pin Code</label>
                    <input type="number" min="0" name="pin_code" id="pin_code" required class="form-control" placeholder="e.g. 123456">
                </div>
            </div>
            <button type="submit" name="order_btn" class="btn btn-primary btn-block">Order Now</button>
        </form>
    </section>

</div>

<?php include 'footer.php'; ?>