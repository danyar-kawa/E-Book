<?php

include '../includes/header.php';

session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'message sent already!';
    } else {
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!';
    }
}
include '../includes/nav.php'; ?>

<!-- Heading Section -->
<div class="heading text-center py-5">
    <h3>Contact Us</h3>
    <p><a href="index.php">Home</a> / Contact</p>
</div>

<!-- Contact Section -->
<section class="contact py-5">
    <div class="container">
        <form action="" method="post">
            <h3 class="text-center mb-4">Say Something!</h3>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" name="name" required placeholder="Enter your name" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <input type="email" name="email" required placeholder="Enter your email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <input type="number" name="number" required placeholder="Enter your number" class="form-control">
            </div>
            <div class="form-group">
                <textarea name="message" class="form-control" placeholder="Enter your message" cols="30" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="send">Send Message</button>
        </form>
    </div>
</section>

<?php include '../includes/footer.php'; ?>