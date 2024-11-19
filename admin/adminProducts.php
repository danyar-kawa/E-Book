<?php
include 'adminHeader.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:/what/sadFinal/home/login.php');
}

// Adding a product
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $pdf = $_FILES['pdf']['name']; // PDF input
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $pdf_tmp_name = $_FILES['pdf']['tmp_name']; // PDF tmp_name
    $image_folder = '../uploaded_img/' . $image;
    $pdf_folder = '../uploaded_pdf/' . $pdf; // PDF folder

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image, pdf) VALUES('$name', '$price', '$image', '$pdf')") or die('query failed');

        if ($add_product_query) {
            if ($image_size > 5000000) {
                $message[] = 'Image size is too large';
            } else {
                if (move_uploaded_file($image_tmp_name, $image_folder) && move_uploaded_file($pdf_tmp_name, $pdf_folder)) {
                    $message[] = 'Product added successfully!';
                } else {
                    $message[] = 'Failed to upload image or PDF. Please check folder permissions and path.';
                }
            }
        } else {
            $message[] = 'Product could not be added!';
        }
    }
}

// Deleting a product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image, pdf FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    unlink('../uploaded_pdf/' . $fetch_delete_image['pdf']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:/what/sadFinal/admin/adminProducts.php');
}

// Updating a product
if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_pdf = $_FILES['update_pdf']['name']; // PDF update
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_pdf_tmp_name = $_FILES['update_pdf']['tmp_name']; // PDF tmp_name
    $update_image_size = $_FILES['update_image']['size'];
    $update_pdf_size = $_FILES['update_pdf']['size']; // PDF size
    $update_folder = '../uploaded_img/' . $update_image;
    $update_pdf_folder = '../uploaded_pdf/' . $update_pdf; // PDF folder
    $update_old_image = $_POST['update_old_image'];
    $update_old_pdf = $_POST['update_old_pdf']; // Old PDF path

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image file size is too large';
        } else {
            if (move_uploaded_file($update_image_tmp_name, $update_folder)) {
                mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
                unlink('../uploaded_img/' . $update_old_image);
            } else {
                $message[] = 'Failed to upload new image.';
            }
        }
    }

    if (!empty($update_pdf)) {
        if ($update_pdf_size > 5000000) {
            $message[] = 'PDF file size is too large';
        } else {
            if (move_uploaded_file($update_pdf_tmp_name, $update_pdf_folder)) {
                mysqli_query($conn, "UPDATE `products` SET pdf = '$update_pdf' WHERE id = '$update_p_id'") or die('query failed');
                unlink('../uploaded_pdf/' . $update_old_pdf);
            } else {
                $message[] = 'Failed to upload new PDF.';
            }
        }
    }

    header('location:/what/sadFinal/admin/adminProducts.php');
}
?>
<!-- Product CRUD Section Starts -->
<section class="container mt-5">
    <h1 class="text-center">Shop Products</h1>

    <!-- Display Messages -->
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>

    <!-- Add Product Form -->
    <form action="" method="post" enctype="multipart/form-data" class="mt-4">
        <h3>Add Product</h3>
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
        </div>
        <div class="mb-3">
            <input type="number" min="0" name="price" class="form-control" placeholder="Enter product price" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="pdf" class="form-label">Product PDF</label>
            <input type="file" name="pdf" accept="application/pdf" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
    </form>
</section>

<!-- Show Products Section Starts -->
<section class="container mt-5">
    <h3 class="text-center">Product List</h3>

    <div class="row">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                            <p class="card-text">$<?php echo $fetch_products['price']; ?>/-</p>
                            <a href="../uploaded_pdf/<?php echo $fetch_products['pdf']; ?>" class="btn btn-success" download>Download PDF</a>
                            <a href="/what/sadFinal/admin/adminProducts.php?update=<?php echo $fetch_products['id']; ?>" class="btn btn-warning">Update</a>
                            <a href="/what/sadFinal/admin/adminProducts.php?delete=<?php echo $fetch_products['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this product?');">Delete</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="text-center w-100">No products added yet!</p>';
        }
        ?>
    </div>
</section>

<!-- Edit Product Form Starts -->
<section class="container mt-5">
    <?php
    if (isset($_GET['update'])) {
        $update_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
        if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
    ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                    <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                    <input type="hidden" name="update_old_pdf" value="<?php echo $fetch_update['pdf']; ?>"> <!-- Hidden PDF -->
                    <div class="mb-3">
                        <input type="text" name="update_name" class="form-control" value="<?php echo $fetch_update['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="update_price" class="form-control" value="<?php echo $fetch_update['price']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_image" class="form-label">Update Product Image</label>
                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="update_pdf" class="form-label">Update Product PDF</label>
                        <input type="file" name="update_pdf" accept="application/pdf" class="form-control">
                    </div>
                    <button type="submit" name="update_product" class="btn btn-success">Update Product</button>
                </form>
    <?php
            }
        }
    }
    ?>
</section>