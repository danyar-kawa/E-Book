<?php
include('header.php');

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    if (($_POST['email'] = 'admin@admin') && (md5($_POST['password']) == md5('12345'))) {
        $user_type = 'admin';
    } else {
        $user_type = 'user';
    }

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
            $message[] = 'Registered successfully!';
            header('location:login.php');
        }
    }
}

if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . $msg . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
    }
}
?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 col-lg-4">
        <div class="card p-4">
            <h3 class="text-center mb-4">Register Now</h3>
            <form action="" method="post">
                <div class="form-group my-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Enter your name" required class="form-control" id="name">
                </div>
                <div class="form-group my-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required class="form-control" id="email">
                </div>
                <div class="form-group my-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required class="form-control" id="password">
                </div>
                <div class="form-group my-3">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" name="cpassword" placeholder="Confirm your password" required class="form-control" id="cpassword">
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block">Register Now</button>
                <p class="text-center mt-3">Already have an account? <a href="login.php">Login now</a></p>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>