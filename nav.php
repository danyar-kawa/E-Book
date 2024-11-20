<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
         ' . $message . '
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      ';
    }
}
?>

<header class="header bg-dark text-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <!-- Logo -->
            <a href="index.php" class="logo fs-2 text-white text-decoration-none">Bookly.</a>

            <!-- Navbar -->
            <nav class="navbar navbar-expand-md">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon bg-light"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="shop.php">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="orders.php">Orders</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Icons -->
            <div class="icons d-flex">
                <a href="searchPage.php" class="fas fa-search text-white mx-2"></a>
                <a href="#" class="fas fa-user text-white mx-2" data-bs-toggle="modal" data-bs-target="#userModal"></a>
                <?php
                $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_rows_number = mysqli_num_rows($select_cart_number);
                ?>
                <a href="cart.php" class="text-white"><i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span></a>
            </div>
        </div>
    </div>
</header>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"><?php if (isset($_SESSION['user_id'])) { ?>
                    <p><strong>Username:</strong> <?php echo $_SESSION['user_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
                    <a href="logout.php" class="btn btn-danger w-100">Logout</a><?php } else { ?>
                    <a class="nav-link btn-primary text-light text-center" href="login.php">Login</a>
                <?php }  ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>