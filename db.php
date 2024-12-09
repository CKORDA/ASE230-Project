<?php
// db.php: Database connection file

$host = 'localhost'; 
$dbname = 'triptinder'; 
$username = 'root'; 
$password = ''; 

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

    // exit();
}
?>
