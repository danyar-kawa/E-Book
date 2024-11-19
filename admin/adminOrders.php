<?php
include 'adminHeader.php';



$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:/what/sadFinal/home/login.php');
}

if (isset($_POST['update_order'])) {

    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    $message[] = 'payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:/what/sadFinal/admin/admin_orders.php');
}

?>



<!-- Orders section starts -->
<section class="orders container my-5">

    <h1 class="title mb-4">Placed Orders</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
        if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
        ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order ID: <?php echo $fetch_orders['id']; ?></h5>
                            <p><strong>User ID:</strong> <?php echo $fetch_orders['user_id']; ?></p>
                            <p><strong>Placed On:</strong> <?php echo $fetch_orders['placed_on']; ?></p>
                            <p><strong>Name:</strong> <?php echo $fetch_orders['name']; ?></p>
                            <p><strong>Number:</strong> <?php echo $fetch_orders['number']; ?></p>
                            <p><strong>Email:</strong> <?php echo $fetch_orders['email']; ?></p>
                            <p><strong>Address:</strong> <?php echo $fetch_orders['address']; ?></p>
                            <p><strong>Total Products:</strong> <?php echo $fetch_orders['total_products']; ?></p>
                            <p><strong>Total Price:</strong> $<?php echo $fetch_orders['total_price']; ?>/-</p>
                            <p><strong>Payment Method:</strong> <?php echo $fetch_orders['method']; ?></p>
                            <form action="" method="post" class="d-flex justify-content-between">
                                <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                                <select name="update_payment" class="form-select">
                                    <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <button type="submit" name="update_order" class="btn btn-primary">Update</button>
                                <a href="/what/sadFinal/admin/admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="btn btn-danger">Delete</a>
                            </form>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
        ?>
    </div>

</section>

<?php include 'adminFooter.php'; ?>