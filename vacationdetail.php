<?php
// Get the vacation name from the query string
$requestedVacation = $_GET['vacation'] ?? '';

// Read the vacation data from the vacationdatabase.txt file
$vacations = file('vacationdatabase.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$foundVacation = null;

foreach ($vacations as $vacation) {
    $vacationDetails = explode('@', $vacation);
    if (count($vacationDetails) >= 5) {
        // Check for a match with the requested vacation name
        if (trim($vacationDetails[0]) === $requestedVacation) {
            $foundVacation = $vacationDetails;
            break; // Found the vacation, no need to continue looping
        }
    }
}

// Check if the vacation was found
if ($foundVacation) {
    list($vacationName, $vacationDescription, $vacationPrice, $vacationLocation, $vacationImage) = $foundVacation;
} else {
    // Set default values if vacation not found
    $vacationName = "Vacation Not Found";
    $vacationDescription = "The vacation you are looking for does not exist.";
    $vacationPrice = "";
    $vacationLocation = "";
    $vacationImage = "";
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
        <h2 class="text-center"><?php echo htmlspecialchars($vacationName); ?></h2>
        <img src="<?php echo htmlspecialchars($vacationImage); ?>" class="img-fluid mb-3" alt="Vacation Image">
        <p><strong>Location:</strong> <?php echo htmlspecialchars($vacationLocation); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($vacationPrice); ?> per person</p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($vacationDescription); ?></p>
        <div class="text-center">
            <a href="book.php?vacation=<?php echo urlencode($vacationName); ?>" class="btn btn-success">Book Now</a>
            <a href="vacations.php" class="btn btn-secondary">Back to Vacations</a>
        </div>
    </div>
</body>
</html>
