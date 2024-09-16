<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="login" value="Login">
        <button type="button" onclick="window.location.href='HomePage.php'">Home</button>
    </form>
</body>
</html>
<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $stmt = $pdo->prepare('SELECT * FROM customer WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['customerID'] = $user['customerID'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect based on user role
        if ($user['role'] === 'admin') {
            header("Location: AdminDashboard.php");
        } else {
            header("Location: CustomerDashboard.php");
        }
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>