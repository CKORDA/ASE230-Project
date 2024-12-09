<?php
// Database configuration
$host = 'localhost';
$dbname = 'triptinder';
$username = 'root';
$password = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch associative arrays by default
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Use native prepared statements

} catch (PDOException $e) {
    // Handle connection errors
    error_log("Database connection failed: " . $e->getMessage()); // Log the error
    echo "We are experiencing technical difficulties. Please try again later.";
    exit();
}
?>
