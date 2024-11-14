<?php

include 'adminHeader.php';


$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_users.php');
}

?>



<!-- Users section starts -->
<section class="users container my-5">

    <h1 class="title mb-4">User Accounts</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
        while ($fetch_users = mysqli_fetch_assoc($select_users)) {
        ?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User ID: <?php echo $fetch_users['id']; ?></h5>
                        <p><strong>Username:</strong> <?php echo $fetch_users['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $fetch_users['email']; ?></p>
                        <p><strong>User Type:</strong> <span style="color:<?php if ($fetch_users['user_type'] == 'admin') {
                                                                                echo 'var(--orange)';
                                                                            } ?>"><?php echo $fetch_users['user_type']; ?></span></p>
                        <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="btn btn-danger">Delete User</a>
                    </div>
                </div>
            </div>
        <?php
        };
        ?>
    </div>

</section>
<?php include 'adminFooter.php'; ?>