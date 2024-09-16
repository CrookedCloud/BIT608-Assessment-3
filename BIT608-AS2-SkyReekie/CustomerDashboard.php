<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<!--Set the page title-->
<head>
    <title>Customer Dashboard.html</title>
    <meta charset="utf-8">
</head>
<?php
session_start();

// Check if the user is a customer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");  // Redirect to login page if not customer
    exit();
}

// Include the database connection
include 'config.php';  

// Get the customer details
$customerID = $_SESSION['customerID'];
$stmt = $pdo->prepare('SELECT firstname FROM customer WHERE customerID = ?');
$stmt->execute([$customerID]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!--Links for customer access pages-->
<body>
    <h1>Customer Dashboard</h1>
    <h3>Welcome, <?php echo htmlspecialchars($customer['firstname']); ?>!</h3>
    <a href="../BIT608-AS2-SkyReekie/Logout.php" style="font-size: 20px;">[Logout]</a>
    <a href="../BIT608-AS2-SkyReekie/CreateBooking.php" style="font-size: 20px;">[New Booking]</a>
    <a href="../BIT608-AS2-SkyReekie/PrivacyPolicy.php" style="font-size: 20px;">[Privacy Policy]</a>
</body>