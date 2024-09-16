<!--Sky Reekie SN#3809237 BIT608 Assesment 2-->
<?php
// MySQL credentials
    define( "DBHOST", "localhost");
    define( "DBUSER", "root");
    define( "DBPASSWORD", "root");
    define( "DBDATABASE", "motueka");

$host = 'localhost';
$dbname = 'motueka';
$username = 'root';
$password = 'root';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>