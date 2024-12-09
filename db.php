<?php
// Database connection settings
$db_host = 'localhost';  // Replace with your host
$db_name = 'triptinder'; // Replace with your database name
$db_user = 'root';       // Replace with your database username
$db_pass = '';           // Replace with your database password

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
     // Log the error for debugging
    error_log("Database Error: " . $e->getMessage());

    // Provide a user-friendly message
    $vacations = [];
    $error_message = "We're sorry, we're experiencing problems at this time.";
}
?>
