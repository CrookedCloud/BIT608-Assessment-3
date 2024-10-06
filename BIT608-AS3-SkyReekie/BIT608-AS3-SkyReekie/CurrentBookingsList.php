<!--Sky Reekie SN#3809237 BIT608 Assesment 3-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<!-- Set the page title -->
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
    <h1>The Motueka Bed & Breakfast<br></h1></div>

<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../BIT608-AS3-SkyReekie/Login.php");
    exit();
}

// Connect to the database and check the connection
include "config.php";
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

// Query to retrieve current bookings along with customer and room details
$query = "SELECT c.customerID, c.firstname, c.lastname, r.roomname, r.roomID, b.checkin, b.checkout 
          FROM customer c
          JOIN bookings b ON c.customerID = b.customerID
          JOIN room r ON b.roomID = r.roomID
          ORDER BY r.roomID";

$result = mysqli_query($db_connection, $query);

// Check if the query execution was successful
if (!$result) {
    echo "Error: " . mysqli_error($db_connection);
    mysqli_close($db_connection);
    exit;
}

// Get the number of rows returned by the query
$rowcount = mysqli_num_rows($result);
?>

<div class="centered-content">
<!-- Display the headings and links -->
    <h2>Current Bookings</h2>

    <!-- Links to create a booking and return to homepage -->
    <a href="../BIT608-AS3-SkyReekie/CreateBooking.php" style="font-size: 20px;">[Create a Booking]</a>
    <a href="../BIT608-AS3-SkyReekie/AdminDashboard.php" style="font-size: 20px;">[Return to Dashboard]</a>
    <p><br></p>

    <!-- Display the table of bookings -->
    <table border="1">
        <thead>
            <tr>
                <th>Booking (room, dates)</th>
                <th>Customer (lastname, firstname)</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        // Check if there are any rows in the result
        if ($rowcount > 0) {
            // Loop through each row and display booking details
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['roomname']) . ', ' . htmlspecialchars($row['checkin']) . ', ' . htmlspecialchars($row['checkout']) . '</td>';
                echo '<td>' . htmlspecialchars($row['lastname']) . ', ' . htmlspecialchars($row['firstname']) . '</td>';
                echo '<td>';
                // Links for viewing, editing, managing reviews, and deleting bookings
                echo '<a href="../BIT608-AS3-SkyReekie/BookingDetails.php?id=' . htmlspecialchars($row['customerID']) . '">[View]</a> ';
                echo '<a href="../BIT608-AS3-SkyReekie/EditBooking.php?id=' . htmlspecialchars($row['customerID']) . '">[Edit]</a> ';
                echo '<a href="../BIT608-AS3-SkyReekie/ManageReviews.php?id=' . htmlspecialchars($row['customerID']) . '">[Manage Reviews]</a> ';
                echo '<a href="../BIT608-AS3-SkyReekie/DeleteBooking.php?id=' . htmlspecialchars($row['customerID']) . '">[Delete]</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // Display a message if no bookings were found
            echo "<tr><td colspan='3'><h2>No bookings found!</h2></td></tr>";
        }

        // Free the result set and close the database connection
        mysqli_free_result($result);
        mysqli_close($db_connection);
        ?>
    </table>
</div>
<hr class="hr-line">

<!-- Page Footer -->
<div class="pagefooter">
<a href="../BIT608-AS3-SkyReekie/PrivacyPolicy.php">Privacy Policy</a>
</div>
</body>
</html>