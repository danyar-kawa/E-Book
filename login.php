<?php
include 'connection.php';
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin.php');
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS if needed -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Alert for messages -->
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }
    ?>

    <!-- Login Form -->
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 shadow-sm">
                <h3 class="text-center mb-4">Login Now</h3>
                <form action="" method="post">
                    <!-- Email Input -->
                    <div class="mb-3">
                        <input type="email" name="email" placeholder="Enter your email" required class="form-control">
                    </div>
                    <!-- Password Input -->
                    <div class="mb-3">
                        <input type="password" name="password" placeholder="Enter your password" required class="form-control">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" name="submit" class="btn btn-primary w-100">Login Now</button>
                </form>
                <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register Now</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>