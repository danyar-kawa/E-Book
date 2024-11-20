<?php
include 'adminHeader.php';


$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_contacts.php');
}

?>



<!-- Messages section starts -->
<section class="messages container my-5">

    <h1 class="title mb-4">Messages</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
        if (mysqli_num_rows($select_message) > 0) {
            while ($fetch_message = mysqli_fetch_assoc($select_message)) {
        ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User ID: <?php echo $fetch_message['user_id']; ?></h5>
                            <p><strong>Name:</strong> <?php echo $fetch_message['name']; ?></p>
                            <p><strong>Number:</strong> <?php echo $fetch_message['number']; ?></p>
                            <p><strong>Email:</strong> <?php echo $fetch_message['email']; ?></p>
                            <p><strong>Message:</strong> <span><?php echo $fetch_message['message']; ?></span></p>
                            <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Delete this message?');" class="btn btn-danger">Delete Message</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">You have no messages!</p>';
        }
        ?>
    </div>

</section>

<?php include 'adminFooter.php'; ?>