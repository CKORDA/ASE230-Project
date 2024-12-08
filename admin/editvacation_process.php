<?php
// Database connection
$host = 'localhost'; // Replace with your database host
$dbname = 'triptinder'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission to update vacation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vacationID = $_POST['vacationID']; // VacationID from the hidden input
    $vacationDescription = $_POST['vacationDescription'];
    $vacationPrice = $_POST['vacationPrice'];
    $vacationDestination = $_POST['vacationDestination'];

    // Prepare SQL statement to update vacation
    $stmt = $pdo->prepare("
        UPDATE vacation 
        SET Description = :description, Price = :price, Destination = :destination 
        WHERE VacationID = :vacationID
    ");
    
    // Execute the query with bound parameters
    $stmt->execute([
        ':description' => $vacationDescription,
        ':price' => $vacationPrice,
        ':destination' => $vacationDestination,
        ':vacationID' => $vacationID
    ]);

    // Redirect to vacations.php after successful update
    header('Location: ../vacations.php');
    exit(); // Always call exit after header redirect to prevent further script execution
}
?>
