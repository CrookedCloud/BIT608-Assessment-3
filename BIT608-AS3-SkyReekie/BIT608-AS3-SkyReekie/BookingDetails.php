<!--Sky Reekie SN#3809237 BIT608 Assesment 3-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bookings</title>
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

<?php
    session_start();

    // Check if admin is logged in
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin')) {
        header("Location: ../BIT608-AS3-SkyReekie/Login.php");
        exit();
    }?>
<!------------------->
<!--Nav Bar-->
<!------------------->
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


    <!-- Main heading for the page -->
    <h2>View Booking Details</h2>
    
    <!-- Links to return to bookings list and homepage -->
    <a href="../BIT608-AS3-SkyReekie/CurrentBookingsList.php" style="font-size: 20px;">[Return to bookings list]</a>
    <a href="../BIT608-AS3-SkyReekie/index.php" style="font-size: 20px;">[Return to home page]</a>
    <p><br></p>

    <?php
    // Include configuration and input cleaning files
    include "config.php";
    include "cleaninput.php";

    // Connect to the database
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    // Check if the connection was successful
    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    // Handle GET request to view booking details
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
            $customer_id = clean_input($_GET['id']);

            // Query to retrieve customer, booking and room details
            $query = "SELECT c.customerID, c.phone, b.checkin, b.checkout, b.extras, b.review, r.roomID, r.roomname 
                      FROM customer c
                      JOIN bookings b ON c.customerID = b.customerID
                      JOIN room r ON b.roomID = r.roomID
                      WHERE c.customerID=?";
            $stmt = mysqli_prepare($db_connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $customer_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Check if query execution was successful
            if ($result) {
                $row_count = mysqli_num_rows($result);

                // Check if any rows were returned
                if ($row_count > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $roomID = htmlspecialchars($row['roomID']);
                    
                    // Display booking details in a fieldset
                    echo "<fieldset><legend>Room ID #$roomID</legend><dl>";
                    echo "<dt>Room Name:</dt><dd>" . htmlspecialchars($row['roomname'] ?? '') . "</dd>";
                    echo "<dt>Check-in Date:</dt><dd>" . htmlspecialchars($row['checkin'] ?? '') . "</dd>";
                    echo "<dt>Check-out Date:</dt><dd>" . htmlspecialchars($row['checkout'] ?? '') . "</dd>";
                    echo "<dt>Phone:</dt><dd>" . htmlspecialchars($row['phone'] ?? '') . "</dd>";
                    echo "<dt>Extras:</dt><dd>" . htmlspecialchars($row['extras'] ?? '') . "</dd>";
                    echo "<dt>Review:</dt><dd>" . htmlspecialchars($row['review'] ?? '') . "</dd>";
                    echo "</dl></fieldset>";
                } else {
                    // Display message if no booking was found
                    echo "<h2>No booking found for Customer ID $customer_id</h2>";
                }

                mysqli_free_result($result);
            } else {
                // Display error message if query execution failed
                echo "Error: " . mysqli_error($db_connection);
            }

            mysqli_stmt_close($stmt);
        } else {
            // Display error message if customer ID is invalid
            echo "<h2>Invalid Customer ID</h2>";
        }
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