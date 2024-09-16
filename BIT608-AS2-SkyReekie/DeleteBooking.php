<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the page title -->
    <title>Delete Booking.html</title>
    <meta charset="utf-8">
    <!--Stylesheet can be added with css file in a final version-->
    <style>
        .border-container {
            display: inline-block;
            position: relative;
            border: 1px solid black;
            padding: 10px;
            margin: 0;
        }

        .border-container h4 {
            position: absolute;
            top: -2em;
            left: 10px;
            background: white;
            padding: 0 5px;
        }

        .border-container label {
            padding: 10px;
            line-height: 2px;
        }

        button {
            margin: 10px;
        }
    </style>

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
    <a href="../BIT608-AS2-SkyReekie/CurrentBookingsList.php" style="font-size: 20px;">[Return to bookings list]</a>
    <a href="../BIT608-AS2-SkyReekie/HomePage.php" style="font-size: 20px;">[Return to Homepage]</a>
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
                    echo "<h1>Booking Successfully Deleted!</h1>";
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<h1>No customer ID provided.</h1>";
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
</body>
</html>