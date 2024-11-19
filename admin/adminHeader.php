<?php
include('../includes/connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:/what/sadFinal/home/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons (Optional, if you need icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body>

    <header class="header bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="admin.php" class="logo text-white fs-4">Admin Panel</a>

            <nav class="navbar navbar-expand-lg navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/what/sadFinal/admin/admin.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="/what/sadFinal/admin/adminProducts.php" class="nav-link">Products</a></li>
                    <li class="nav-item"><a href="/what/sadFinal/admin/adminOrders.php" class="nav-link">Orders</a></li>
                    <li class="nav-item"><a href="/what/sadFinal/admin/adminUsers.php" class="nav-link">Users</a></li>
                    <li class="nav-item"><a href="/what/sadFinal/admin/adminContacts.php" class="nav-link">Messages</a></li>
                    <li class="nav-item"><a href="/what/sadFinal/home/logout.php" class="nav-link">Logout</a></li>
                </ul>
            </nav>

            <div class="dropdown">
            </div>
        </div>
    </header>