<!--Sky Reekie SN#3809237 BIT608 Assesment 3-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<!--Set the page title-->
<head>
    <title>Customer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="
    default-src 'self';
    script-src 'self';
    style-src 'self' https://fonts.googleapis.com 'unsafe-inline';
    font-src 'self' https://fonts.gstatic.com;
    img-src 'self';
    object-src 'none';
    frame-src 'self' https://www.google.com;
    upgrade-insecure-requests;">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href='../BIT608-AS3-SkyReekie/stylesheet.css' rel='stylesheet'>
</head>

<!--------------------------------->
<!--Nav Bar-->
<!--------------------------------->

<body>
    <header>
        <div class="wrapper">
            <div class="logo">
                <a href="../BIT608-AS3-SkyReekie/index.php">
                    <img src="../BIT608-AS3-SkyReekie/BIT608_AS3_Images/graphic.png" alt="Logo" height="100" width="240">
                </a>
            </div>

            <nav id="navbar">
                <a href="../BIT608-AS3-SkyReekie/index.php">Home</a>
                <a href="../BIT608-AS3-SkyReekie/NewCustomer.php">New Customer</a>
                <a href="../BIT608-AS3-SkyReekie/CustomerDashboard.php">Customer Dashboard</a>
                <a href="../BIT608-AS3-SkyReekie/AdminDashboard.php">Admin Dashboard</a>
            </nav>
            <div class="mobile-menu-icon" onclick="toggleMenu()">
                ☰
            </div>
        </div>
    </header>
    <div class="centered-content">
    <h1>The Motueka Bed & Breakfast<br></h1>

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
    <a href="../BIT608-AS3-SkyReekie/Logout.php" style="font-size: 20px;">[Logout]</a>
    <a href="../BIT608-AS3-SkyReekie/CreateBooking.php" style="font-size: 20px;">[New Booking]</a>
    <a href="../BIT608-AS3-SkyReekie/PrivacyPolicy.php" style="font-size: 20px;">[Privacy Policy]</a>
    </div>
    <hr class="hr-line">

        <!-- Page Footer -->
    <div class="pagefooter">
        <a href="../BIT608-AS3-SkyReekie/PrivacyPolicy.php">Privacy Policy</a>
    </div>
</body>
</html>