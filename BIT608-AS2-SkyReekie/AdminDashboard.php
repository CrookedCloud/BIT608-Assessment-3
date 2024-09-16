<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<!--Set the page title-->
<head>
    <title>Admin Dashboard.html</title>
    <meta charset="utf-8">
</head>
<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<body>
    <h1>Admin Dashboard</h1>
    <!-- Links to return to bookings list and homepage -->
    <a href="../BIT608-AS2-SkyReekie/CurrentBookingsList.php" style="font-size: 20px;">[Current bookings list]</a>
    <a href="../BIT608-AS2-SkyReekie/Logout.php" style="font-size: 20px;">[Logout]</a>
</body>