
<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set the page title -->
    <title>Edit Booking.html</title>
    <meta charset="utf-8">

    <!--Create a style sheet/ this could be handled in css in a final version-->
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

        .border-container select,
        .border-container input,
        textarea,
        button {
            margin: 5px;
        }

        textarea {
            resize: vertical;
            min-height: 50px;
        }

        button {
            margin: 10px;
        }
    </style>

<?php
    session_start();

    // Check if either customer or admin is logged in
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'customer')) {
        header("Location: ../BIT608-AS2-SkyReekie/Login.php");
        exit();
    }?>

   <!-- JavaScript function to validate form input for correct dates -->
   <script>
        function validateForm() {
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;
            if (new Date(checkin) >= new Date(checkout)) {
                alert('Check-out date must be after check-in date.');
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <!-- Main heading for the page -->
    <h1>Edit a Booking</h1>
    <!-- Navigation links to other pages -->
    <a href="../BIT608-AS2-SkyReekie/CurrentBookingsList.php" style="font-size: 20px;">[Return to bookings list]</a>
    <a href="../BIT608-AS2-SkyReekie/AdminDashboard.php" style="font-size: 20px;">[Return to Dashboard]</a>
    <p><br></p>

    <!-- Container for the booking edit form with styles applied -->
    <div class="border-container">
        <h4>Edit Booking</h4>

        <?php 
        // Include configuration and input cleaning files
        include "config.php";
        include "cleaninput.php";
        
        // Connect to the database
        $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

        // Check for connection errors
        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
            exit;
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['customerID']) && !empty($_POST['customerID'])) {
                $customerID = (int)$_POST['customerID'];
                $room_data = explode(',', $_POST['room']);
                $roomID = (int)$room_data[0];
                $checkin = clean_input($_POST['checkin']);
                $checkout = clean_input($_POST['checkout']);
                $phonenumber = clean_input($_POST['phonenumber']);
                $bookingextras = clean_input($_POST['bookingextras']);
                $review = clean_input($_POST['review']);

                // SQL query to update booking details in the database
                $query = "UPDATE bookings SET roomID = ?, checkin = ?, checkout = ?, phone = ?, extras = ?, review = ? WHERE customerID = ?";
                $stmt = mysqli_prepare($db_connection, $query);
                mysqli_stmt_bind_param($stmt, 'issssii', $roomID, $checkin, $checkout, $phonenumber, $bookingextras, $review, $customerID);

                // Execute the query and check for errors
                if (mysqli_stmt_execute($stmt)) {
                    echo "<h1>Booking Successfully Updated!</h1>";
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "No customer ID provided.";
            }
        } 
        // Handle request to edit an existing booking
        else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $customerID = (int)$_GET['id'];

            // SQL query to retrieve existing booking details
            $query = "SELECT b.bookingID, b.roomID, b.checkin, b.checkout, b.phone, b.extras, b.review, r.roomname, r.roomtype, r.beds
                      FROM bookings b
                      JOIN room r ON b.roomID = r.roomID
                      WHERE b.customerID = ?";
            $stmt = mysqli_prepare($db_connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $customerID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Check for errors in the query result
            if ($result === false) {
                echo "Error: " . mysqli_error($db_connection);
                exit;
            }

            $booking = mysqli_fetch_assoc($result);

            // Check if the booking was found
            if (!$booking) {
                echo "Booking not found.";
                exit;
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "No customer ID provided.";
            exit;
        }
        ?>

        <!-- Form to edit booking details -->
        <form action="EditBooking.php" method="post" onsubmit="return validateForm()">
            <!-- Hidden input to store customer ID -->
            <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customerID, ENT_QUOTES, 'UTF-8'); ?>">

            <!-- Dropdown to select the room -->
            <label for="room">Room (Name, Type, Beds):</label>
            <select id="room" name="room" required>
                <?php
                // SQL query to retrieve room details
                $query = "SELECT roomID, roomname, roomtype, beds FROM room";
                $result = mysqli_query($db_connection, $query);

                // Populate the dropdown with room options
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $roomID = $row['roomID'];
                        $roomName = htmlspecialchars($row['roomname'], ENT_QUOTES, 'UTF-8');
                        $roomType = htmlspecialchars($row['roomtype'], ENT_QUOTES, 'UTF-8');
                        $beds = htmlspecialchars($row['beds'], ENT_QUOTES, 'UTF-8');
                        $selected = ($booking['roomID'] == $roomID) ? 'selected' : '';
                        echo "<option value=\"$roomID,$roomType,$beds\" $selected>$roomName, $roomType, $beds</option>";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "<option disabled>Error fetching rooms</option>";
                }
                ?>
            </select><br>

            <!-- Input fields for check-in and check-out dates -->
            <label for="checkin">Check in date:</label>
            <input type="date" id="checkin" name="checkin" value="<?php echo htmlspecialchars($booking['checkin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

            <label for="checkout">Check out date:</label>
            <input type="date" id="checkout" name="checkout" value="<?php echo htmlspecialchars($booking['checkout'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

            <!-- Input field for contact number -->
            <label for="phonenumber">Contact Number:</label>
            <input type="tel" id="phonenumber" name="phonenumber" pattern="[0-9]{10}" placeholder="Phone number required" value="<?php echo htmlspecialchars($booking['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

            <!-- Textarea for booking extras -->
            <label for="bookingextras">Extras:</label>
            <textarea id="bookingextras" name="bookingextras" placeholder="Please enter any extras required"><?php echo htmlspecialchars($booking['extras'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea><br>

            <!-- Textarea for reviews -->
            <label for="review">Reviews:</label>
            <textarea id="review" name="review" placeholder="Please enter your review"><?php echo htmlspecialchars($booking['review'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea><br>

            <!-- Submit button to update the booking -->
            <button type="submit">Update</button>
            <!-- Link to cancel and go back to bookings list -->
            <a href="../BIT608-AS2-SkyReekie/">[Cancel]</a>
        </form>
    </div>
</body>
</html>

