<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Registration</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Customer Registration</h1>
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
    <a href="../BIT608-AS2-SkyReekie/HomePage.php">[Return]</a>
</body>
</html>