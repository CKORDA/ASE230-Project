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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $vacationTitle = $_POST['vacationName'] ?? '';
    $vacationDescription = $_POST['vacationDescription'] ?? '';
    $vacationPrice = $_POST['vacationPrice'] ?? 0;
    $vacationDestination = $_POST['vacationDestination'] ?? '';
    $vacationCategory = $_POST['vacationCategory'] ?? null; // New field for Category
    $vacationAdminID = 1; // Assuming you have an Admin ID to assign (you can change it or get it dynamically)

    try {
        // Insert the vacation data into the database
        $stmt = $pdo->prepare("
            INSERT INTO vacation (title, description, price, destination, category, adminID) 
            VALUES (:title, :description, :price, :destination, :category, :adminID)
        ");
        $stmt->execute([
            ':title' => $vacationTitle,
            ':description' => $vacationDescription,
            ':price' => $vacationPrice,
            ':destination' => $vacationDestination,
            ':category' => $vacationCategory,
            ':adminID' => $vacationAdminID
        ]);

        // Redirect to vacations.php after successful saving
        header('Location: ../vacations.php');
        exit(); // Always call exit after header redirect
    } catch (PDOException $e) {
        die("Failed to save vacation: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Vacation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Add a New Vacation</h2>
        <form action="addvacation.php" method="post"> <!-- Keep the action pointing to this file -->
            <div class="mb-3">
                <label for="vacationName" class="form-label">Vacation Title</label>
                <input type="text" class="form-control" id="vacationName" name="vacationName" required>
            </div>
            <div class="mb-3">
                <label for="vacationDescription" class="form-label">Description</label>
                <textarea class="form-control" id="vacationDescription" name="vacationDescription" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="vacationPrice" class="form-label">Price</label>
                <input type="number" class="form-control" id="vacationPrice" name="vacationPrice" required>
            </div>
            <div class="mb-3">
                <label for="vacationDestination" class="form-label">Location</label>
                <input type="text" class="form-control" id="vacationDestination" name="vacationDestination" required>
            </div>
            <div class="mb-3">
                <label for="vacationCategory" class="form-label">Category</label>
                <input type="text" class="form-control" id="vacationCategory" name="vacationCategory">
            </div>
            <button type="submit" class="btn btn-primary">Save Vacation</button>
        </form>
        <div class="mt-3">
            <a href="adminpanel.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
