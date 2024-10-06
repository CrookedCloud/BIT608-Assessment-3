<!--Sky Reekie SN#3809237 BIT608 Assesment 3-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Booking</title>
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
    <h1>The Motueka Bed & Breakfast<br></h1></div>

<?php
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin')) {
        header("Location: ../BIT608-AS3-SkyReekie/Login.php");
        exit();
    }?>

    <!-- JavaScript function to confirm deletion -->
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this booking?');
        }
    </script>
</head>

<body>
    <h1>Delete a Booking</h1>
    
    <!-- Links to return to the bookings list and homepage -->
    <a href="../BIT608-AS3-SkyReekie/CurrentBookingsList.php" style="font-size: 20px;">[Return to bookings list]</a>
    <a href="../BIT608-AS3-SkyReekie/AdminDashboard.php" style="font-size: 20px;">[Return to Dashboard]</a>
    <p><br></p>

    <!-- Container for the delete booking form -->
    <div class="border-container">
        <h4>Delete Booking</h4>

        <?php
        // Include configuration file for database connection
        include "config.php";
        $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

        // Check database connection
        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
            exit;
        }

        // Handle form submission for deleting a booking
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if customerID is provided and not empty
            if (isset($_POST['customerID']) && !empty($_POST['customerID'])) {
                $customerID = (int)$_POST['customerID'];

                // Query for the delete statement
                $query = "DELETE FROM bookings WHERE customerID = ?";
                $stmt = mysqli_prepare($db_connection, $query);
                mysqli_stmt_bind_param($stmt, 'i', $customerID);

                // Execute the delete statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "<h2>Booking Successfully Deleted!</h2>";
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<p>No customer ID provided.</p>";
            }
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $customerID = (int)$_GET['id'];

            // Display confirmation form for deletion
            echo '<form action="DeleteBooking.php" method="post" onsubmit="return confirmDelete()">';
            echo '<input type="hidden" name="customerID" value="' . htmlspecialchars($customerID, ENT_QUOTES, 'UTF-8') . '">';
            echo '<p>Are you sure you want to delete this booking?</p>';
            echo '<button type="submit">Delete</button>';
            echo '</form>';
        } else {
            echo "<h1>No customer ID provided.</h1>";
        }

        // Close the database connection
        mysqli_close($db_connection);
        ?>

    </div>
    <hr class="hr-line">

        <!-- Page Footer -->
    <div class="pagefooter">
        <a href="../BIT608-AS3-SkyReekie/PrivacyPolicy.php">Privacy Policy</a>
    </div>
</body>
</html>