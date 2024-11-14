<?php

include '../includes/header.php';

session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
include '../includes/nav.php'; ?>

<!-- Heading Section -->
<div class="heading text-center py-5">
    <h3>Your Orders</h3>
    <p><a href="index.php">Home</a> / Orders</p>
</div>

<!-- Orders Section -->
<section class="placed-orders py-5">
    <div class="container">
        <h1 class="title text-center mb-4">Placed Orders</h1>

        <div class="row">

            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($order_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                                <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
                                <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
                                <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
                                <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
                                <p>Payment Method: <span><?php echo $fetch_orders['method']; ?></span></p>
                                <p>Your Orders: <span><?php echo $fetch_orders['total_products']; ?></span></p>
                                <p>Total Price: <span>$<?php echo $fetch_orders['total_price']; ?>/-</span></p>
                                <p>Payment Status:
                                    <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                            echo 'red';
                                                        } else {
                                                            echo 'green';
                                                        } ?>;">
                                        <?php echo $fetch_orders['payment_status']; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty text-center">No orders placed yet!</p>';
            }
            ?>

        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>