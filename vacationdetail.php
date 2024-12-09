<?php
// Database connection
include 'db.php';

// Get the vacation title from the query string
$requestedVacation = $_GET['vacation'] ?? '';

if ($requestedVacation) {
    // Fetch vacation details from the database using title
    $stmt = $pdo->prepare("SELECT title, description, price, destination FROM vacation WHERE title = :title");
    $stmt->execute(['title' => $requestedVacation]);
    $foundVacation = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $foundVacation = false;
}

// Check if the vacation was found
if ($foundVacation) {
    $vacationTitle = $foundVacation['title'];
    $vacationDescription = $foundVacation['description'];
    $vacationPrice = $foundVacation['price'];
    $vacationDestination = $foundVacation['destination'];
} else {
    // Set default values if vacation not found
    $vacationTitle = "Vacation Not Found";
    $vacationDescription = "The vacation you are looking for does not exist.";
    $vacationPrice = "";
    $vacationDestination = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center"><?php echo htmlspecialchars($vacationTitle); ?></h2>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($vacationDestination); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($vacationPrice); ?> per person</p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($vacationDescription); ?></p>
        <div class="text-center">
            <form action="confirmBooking.php" method="POST">
                <input type="hidden" name="vacationTitle" value="<?php echo htmlspecialchars($vacationTitle); ?>">
                <button type="submit" class="btn btn-success">Book Now</button>
            </form>
            <a href="vacations.php" class="btn btn-secondary mt-3">Back to Vacations</a> <!-- Added mt-3 for spacing -->
        </div>
    </div>
</body>
</html>
