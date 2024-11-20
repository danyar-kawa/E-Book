<?php
session_start();
include 'header.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'Cart quantity updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}

?>
<div class="container mt-5">
    <h2 class="text-center">Shopping Cart</h2>
    <p class="text-center"><a href="index.php">Home</a> / Cart</p>

    <section class="shopping-cart mt-4">

        <h3 class="text-center mb-4">Products Added</h3>

        <div class="row">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../uploaded_img/<?php echo $fetch_cart['image']; ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $fetch_cart['name']; ?></h5>
                                <p class="card-text">Price: $<?php echo $fetch_cart['price']; ?>/-</p>
                                <p class="card-text">Subtotal: $<?php echo $sub_total; ?>/-</p>
                                <form action="" method="post" class="d-inline-block">
                                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                    <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>" class="form-control mb-2">
                                    <button type="submit" name="update_cart" class="btn btn-primary btn-sm">Update</button>
                                </form>
                                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this item from the cart?');">Delete</a>
                            </div>
                        </div>
                    </div>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="text-center w-100">Your cart is empty.</p>';
            }
            ?>
        </div>

        <div class="text-center mt-4">
            <a href="cart.php?delete_all" class="btn btn-danger <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all items from the cart?');">Delete All</a>
        </div>

        <div class="text-center mt-4">
            <p>Grand Total: <strong>$<?php echo $grand_total; ?>/-</strong></p>
            <a href="shop.php" class="btn btn-secondary">Continue Shopping</a>
            <a href="checkout.php" class="btn btn-success <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
        </div>

    </section>
</div>

<?php include 'footer.php'; ?>