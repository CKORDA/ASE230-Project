<?php
session_start();

// Database connection
include 'db.php';

if (!isset($_SESSION['email'])) {
    echo '<div class="alert alert-danger text-center">You are not logged in.</div>';
    header("Refresh: 3; url=index.php");
    exit();
}

// Use session email to fetch user details
$userEmail = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT userid FROM users WHERE email = :email");
$stmt->execute(['email' => $userEmail]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userId = $user['userid'] ?? null;

// Debug: Verify fetched user details
//var_dump($userId); // Ensure userID is fetched correctly

// Get the vacation title from the query string
$requestedVacation = $_GET['vacation'] ?? '';
$userEmail = $_SESSION['email'] ?? null; // Ensure the email is retrieved from the session

if ($requestedVacation) {
    // Fetch vacation details from the database using title
    $stmt = $pdo->prepare("SELECT vacationid, title, description, price, destination FROM vacation WHERE title = :title");
    $stmt->execute(['title' => $requestedVacation]);
    $foundVacation = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $foundVacation = false;
}

// Check if the vacation was found
if ($foundVacation) {
    $vacationId = $foundVacation['vacationid'];
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
                <input type="hidden" name="vacation_id" value="<?php echo htmlspecialchars($vacationId); ?>">
                <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($userEmail); ?>">
                <button type="submit" class="btn btn-success">Book Now</button>
            </form>

            <a href="vacations.php" class="btn btn-secondary mt-3">Back to Vacations</a> <!-- Added mt-3 for spacing -->
        </div>
    </div>
</body>
</html>
