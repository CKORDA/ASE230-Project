<?php
// Database connection
$host = 'localhost'; // Replace with database host
$dbname = 'triptinder'; // Replace with database name
$username = 'root'; // Replace with database username
$password = ''; // Replace with database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception("Database connection failed: " . $e->getMessage());
}

// Check if the vacation title is provided
if (isset($_POST['vacation'])) {
    $vacationToDelete = $_POST['vacation'];

    try {
        // Prepare SQL statement to delete vacation by title
        $stmt = $pdo->prepare("DELETE FROM vacation WHERE Title = :title");
        $stmt->execute([':title' => $vacationToDelete]);

        // Redirect to vacations.php after successful deletion
        header('Location: ../vacations.php?status=deleted');
        exit(); // Always call exit after header redirect
    } catch (PDOException $e) {
        throw new Exception("Failed to remove vacation: " . $e->getMessage());
    }
} else {
    // If no vacation title is provided, redirect with an error
    header('Location: ../vacations.php?status=error');
    exit();
}
