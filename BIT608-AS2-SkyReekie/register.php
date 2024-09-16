<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<?php
session_start();
include 'config.php';  // Include the database connection

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the query
    try {
        $stmt = $pdo->prepare('INSERT INTO customer (firstname, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$firstname, $lastname, $email, $phone, $hashedPassword]);

        echo "Registration successful!";
        echo '<a href="HomePage.php">Return to Home Page</a>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>