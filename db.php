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
    // Log the error to a file
    error_log("Database connection failed: " . $e->getMessage(), 3, 'error_log.txt');

    // Display a user-friendly error message
    echo "<div style='color: red; text-align: center;'>
            We are currently experiencing technical issues. Please try again later.
          </div>";

    // Optionally, redirect to a custom error page
    // header("Location: error.php");
    // exit();
}
?>
