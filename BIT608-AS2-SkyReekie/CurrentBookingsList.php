<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<!-- Set the page title -->
<head>
    <title>Current Bookings.html</title>
    <meta charset="utf-8">
</head>

<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../BIT608-AS2-SkyReekie/Login.php"); // Redirect to login page
    exit();
}

// Connect to the database and check the connection
include "config.php"; // Load database configuration variables
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

<!-- Display the headings and links -->
<body>
    <h1>Current Bookings</h1>

    <!-- Links to create a booking and return to homepage -->
    <a href="../BIT608-AS2-SkyReekie/CreateBooking.php" style="font-size: 20px;">[Create a Booking]</a>
    <a href="../BIT608-AS2-SkyReekie/AdminDashboard.php" style="font-size: 20px;">[Return to Dashboard]</a>
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
                echo '<a href="../BIT608-AS2-SkyReekie/BookingDetails.php?id=' . htmlspecialchars($row['customerID']) . '">[View]</a> ';
                echo '<a href="../BIT608-AS2-SkyReekie/EditBooking.php?id=' . htmlspecialchars($row['customerID']) . '">[Edit]</a> ';
                echo '<a href="../BIT608-AS2-SkyReekie/ManageReviews.php?id=' . htmlspecialchars($row['customerID']) . '">[Manage Reviews]</a> ';
                echo '<a href="../BIT608-AS2-SkyReekie/DeleteBooking.php?id=' . htmlspecialchars($row['customerID']) . '">[Delete]</a>';
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
</body>
</html>