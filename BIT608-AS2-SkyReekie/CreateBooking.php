<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!--Doctype and Language-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Set the page title -->
    <title>Create Booking.html</title>
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

        .horizontal-line {
            border: none;
            height: 2px;
            background-color: #000;
            margin: 20px 0;
        }
    </style>
    <script>
        // JavaScript function to validate form dates
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
    <h1>Create a Booking</h1>
    <!-- Links to return to the bookings list and homepage -->
    <a href="../BIT608-AS2-SkyReekie/CurrentBookingsList.php" style="font-size: 20px;">[Return to bookings list]</a>
    <a href="../BIT608-AS2-SkyReekie/HomePage.php" style="font-size: 20px;">[Return to Homepage]</a>
    <p><br></p>

    <!-- Container for the booking form -->
    <div class="border-container">
        <h4>Test Booking</h4>
        <form action="CreateBooking.php" method="post" onsubmit="return validateForm()">
            <!-- Room selection dropdown -->
            <label for="room">Room (Name,Type,Beds):</label>
            <select id="room" name="room" required>
                <?php
                // Connect to the database and check connection
                include "config.php";
                include "cleaninput.php";
                $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

                if (mysqli_connect_errno()) {
                    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
                    exit;
                }

                // Fetch room data from the database
                $query = "SELECT roomID, roomname, roomtype, beds FROM room";
                $result = mysqli_query($db_connection, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $roomID = $row['roomID'];
                        $roomName = htmlspecialchars($row['roomname']);
                        $roomType = htmlspecialchars($row['roomtype']);
                        $beds = htmlspecialchars($row['beds']);
                        $value = "$roomID,$roomName,$roomType,$beds";
                        echo "<option value=\"$value\">$roomName,$roomType,$beds</option>";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "<option disabled>Error fetching rooms</option>";
                }
                ?>
            </select><br>

            <!-- Input fields for customer details -->
            <!--Customer firstname and last name are added for database functionality-->
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required><br>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required><br>

            <label for="checkin">Check in date:</label>
            <input type="date" id="checkin" name="checkin" required><br>

            <label for="checkout">Check out date:</label>
            <input type="date" id="checkout" name="checkout" required><br>

            <label for="phonenumber">Contact Number:</label>
            <input type="tel" id="phonenumber" name="phonenumber" pattern="[0-9]{10}" placeholder="Enter a 10 digit number" required><br>

            <label for="bookingextras">Extras:</label>
            <textarea id="bookingextras" name="bookingextras" placeholder="Please enter any extras required"></textarea><br>

            <!-- Submit button and cancel link -->
            <button type="submit">Add</button>
            <a href="../BIT608-AS2-SkyReekie/HomePage.php">[Cancel]</a>
        </form>
    </div>

    <?php
    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $room_data = explode(',', $_POST['room']);
        $roomID = (int)$room_data[0];
        $roomname = clean_input($room_data[1]);
        $checkin = clean_input($_POST['checkin']);
        $checkout = clean_input($_POST['checkout']);
        $phonenumber = clean_input($_POST['phonenumber']);
        $bookingextras = clean_input($_POST['bookingextras']);
        $firstname = clean_input($_POST['firstname']);//
        $lastname = clean_input($_POST['lastname']);//

        // Check if the customer already exists
        // this can be changed when customer login is added
        $query = "SELECT customerID FROM customer WHERE firstname = ? AND lastname = ? AND phone = ?";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $firstname, $lastname, $phonenumber);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $customerID);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // If the customer does not exist, insert a new customer
        //This can be changed when login page is added
        if (!$customerID) {
            $query = "INSERT INTO customer (firstname, lastname, phone) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($db_connection, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $firstname, $lastname, $phonenumber);
            mysqli_stmt_execute($stmt);
            $customerID = mysqli_insert_id($db_connection);
            mysqli_stmt_close($stmt);
        }

        // Prepare and execute the query to insert a new booking
        //firstname and last name will be romoved when login is added
        $query = "INSERT INTO bookings (firstname, lastname, customerID, roomID, roomname, checkin, checkout, phone, extras) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 'ssiisssss', $firstname, $lastname, $customerID, $roomID, $roomname, $checkin, $checkout, $phonenumber, $bookingextras);

        if (mysqli_stmt_execute($stmt)) {
            echo "<h1>Booking Successfully Created!</h1>";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_close($db_connection);
    }
    ?>

    <hr class="horizontal-line">
    <h1>Search for Room Availability</h1>

    <script>
        // JavaScript function to validate search dates
        function validateForm() {
            const checkin = document.getElementById('search-checkin').value;
            const checkout = document.getElementById('search-checkout').value;

            if (new Date(checkin) >= new Date(checkout)) {
                alert('Check-out date must be after check-in date.');
                return false;
            }
            return true;
        }
    </script>

    <!-- Form to search for room availability -->
    <form action="CreateBooking.php" method="get" onsubmit="return validateForm()">
        <label for="search-checkin">Check in date:</label>
        <input type="date" id="search-checkin" name="checkin" required
               value="<?php echo isset($_GET['checkin']) ? htmlspecialchars($_GET['checkin']) : ''; ?>">

        <label for="search-checkout">Check out date:</label>
        <input type="date" id="search-checkout" name="checkout" required
               value="<?php echo isset($_GET['checkout']) ? htmlspecialchars($_GET['checkout']) : ''; ?>">

        <button type="submit">Search</button>
    </form>

    <?php
    // Process room availability search
    if (isset($_GET['checkin']) && isset($_GET['checkout'])) {
        $checkin = clean_input($_GET['checkin']);
        $checkout = clean_input($_GET['checkout']);

        // Query to find rooms that are not booked during the specified dates
        $query = "
            SELECT r.roomID, r.roomname, r.roomtype, r.beds
            FROM room r
            WHERE r.roomID NOT IN (
                SELECT b.roomID
                FROM bookings b
                WHERE ('$checkin' < b.checkout) AND ('$checkout' > b.checkin)
            )
        ";

        $result = mysqli_query($db_connection, $query);
        //Display the avalible rooms
        if ($result) {
            echo "<h1>Available Rooms</h1>";
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr><th>Room #</th><th>Room Name</th><th>Room Type</th><th>Beds</th></tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['roomID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['roomname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['roomtype']) . "</td>";
                echo "<td>" . htmlspecialchars($row['beds']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            mysqli_free_result($result);
        } else {
            echo "Error: " . mysqli_error($db_connection);
        }

        mysqli_close($db_connection);
    } else {
        echo "<h2>Please enter both check-in and check-out dates.</h2>";//error if dates are entered inccorectly
    }
    ?>
</body>

</html>