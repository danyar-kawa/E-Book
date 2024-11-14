<?php

include('../includes/header.php');

session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

?>



<?php include '../includes/nav.php'; ?>

<!-- Heading Section -->
<div class="heading text-center py-5">
    <h3>About Us</h3>
    <p> <a href="index.php">Home</a> / About </p>
</div>

<!-- About Section -->
<section class="about py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="https://m.media-amazon.com/images/I/617b34iNYeL._AC_UF1000,1000_QL80_.jpg" alt="About Us Image" class="img-fluid w-50">
            </div>
            <div class="col-md-6">
                <h3>Why Choose Us?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet voluptatibus aut hic molestias, reiciendis natus fuga, cumque excepturi veniam ratione iure.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
                <a href="contact.php" class="btn btn-primary">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<?php include '../includes/footer.php'; ?>