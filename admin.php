<?php
include 'adminHeader.php'; // Include the header file to make use of the navigation


$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

?>

<section class="dashboard py-5">
    <div class="container">
        <h1 class="title text-center mb-4">Admin Dashboard</h1>

        <div class="box-container row">

            <!-- Total Pendings Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $total_pendings = 0;
                        $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
                        if (mysqli_num_rows($select_pending) > 0) {
                            while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                                $total_price = $fetch_pendings['total_price'];
                                $total_pendings += $total_price;
                            };
                        };
                        ?>
                        <h3>$<?php echo $total_pendings; ?>/-</h3>
                        <p>Total Pendings</p>
                    </div>
                </div>
            </div>

            <!-- Total Completed Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $total_completed = 0;
                        $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
                        if (mysqli_num_rows($select_completed) > 0) {
                            while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
                                $total_price = $fetch_completed['total_price'];
                                $total_completed += $total_price;
                            };
                        };
                        ?>
                        <h3>$<?php echo $total_completed; ?>/-</h3>
                        <p>Completed Payments</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                        $number_of_orders = mysqli_num_rows($select_orders);
                        ?>
                        <h3><?php echo $number_of_orders; ?></h3>
                        <p>Orders Placed</p>
                    </div>
                </div>
            </div>

            <!-- Total Products Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                        $number_of_products = mysqli_num_rows($select_products);
                        ?>
                        <h3><?php echo $number_of_products; ?></h3>
                        <p>Products Added</p>
                    </div>
                </div>
            </div>

            <!-- Total Normal Users Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                        $number_of_users = mysqli_num_rows($select_users);
                        ?>
                        <h3><?php echo $number_of_users; ?></h3>
                        <p>Normal Users</p>
                    </div>
                </div>
            </div>

            <!-- Total Admin Users Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                        $number_of_admins = mysqli_num_rows($select_admins);
                        ?>
                        <h3><?php echo $number_of_admins; ?></h3>
                        <p>Admin Users</p>
                    </div>
                </div>
            </div>

            <!-- Total Accounts Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                        $number_of_account = mysqli_num_rows($select_account);
                        ?>
                        <h3><?php echo $number_of_account; ?></h3>
                        <p>Total Accounts</p>
                    </div>
                </div>
            </div>

            <!-- Total Messages Box -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                        $number_of_messages = mysqli_num_rows($select_messages);
                        ?>
                        <h3><?php echo $number_of_messages; ?></h3>
                        <p>New Messages</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Include the footer -->
<?php include 'adminFooter.php'; ?>