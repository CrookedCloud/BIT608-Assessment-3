<!--Sky Reekie SN#3809237 BIT608 Assesment 3-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
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

    <h2>Customer Registration</h2>
    <p>Please fill out the form below to register as a new customer.</p>
    <form method="post" action="register.php">
        <label for="firstname">First Name:</label><br>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname">Last Name:</label><br>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="register" value="Register">
    </form>
    <a href="../BIT608-AS3-SkyReekie/index.php">[Return]</a></div>
    <hr class="hr-line">

    <!-- Page Footer -->
<div class="pagefooter">
    <a href="../BIT608-AS3-SkyReekie/PrivacyPolicy.php">Privacy Policy</a>
</div>
</body>
</html>