<?php
// db.php: Database connection file

$host = 'localhost'; // Change if your database is hosted elsewhere
$dbname = 'triptinder'; // Your database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password, empty for local XAMPP setups

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>