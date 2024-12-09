<?php
// Include the database connection
require 'db.php';

// Ensure session is started
session_start();

// Fetch vacation details if a valid vacation is requested
$requestedVacation = $_GET['vacation'] ?? '';
$foundVacation = false;


if ($requestedVacation) {
    try {
        // Fetch vacation details by title
        $stmt = $pdo->prepare("SELECT * FROM vacation WHERE title = :title");
        $stmt->execute(['title' => $requestedVacation]);
        $foundVacation = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching vacation: " . $e->getMessage());
    }
}

// Booking logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use session email to fetch user details
	$userEmail = $_SESSION['email'];
	$stmt = $pdo->prepare("SELECT userid FROM users WHERE email = :email");
	$stmt->execute(['email' => $userEmail]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	$userId = (int)$user['userid'] ?? null;
	
	$vacationId = (int) $_POST['vacation_id']; // Convert to integer
	
    // Debug: Check if both vacationId and userId are set
    //var_dump($vacationId, $userId);

    if ($vacationId && $userId) {
        $bookingDate = date('Y-m-d H:i:s'); // Current date/time
        try {
            // Insert booking details into the database
            $stmt = $pdo->prepare(
                "INSERT INTO bookings (VacationID, userID, DateBooked) 
                 VALUES (:vacation_id, :userid, :booking_date)"
            );
            $stmt->bindParam(':vacation_id', $vacationId, PDO::PARAM_INT);
            $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':booking_date', $bookingDate, PDO::PARAM_STR);
            $stmt->execute();

            $message = "Booking confirmed for vacation ID $vacationId!";
        } catch (PDOException $e) {
            error_log("Booking error: " . $e->getMessage());
            $message = "Error processing booking. Please try again.";
        }
    } else {
        $message = "Vacation ID and User ID are required.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('data/samuel-clara-yUWKDfPLp6w-unsplash.jpg');
            background-size: cover;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($message)) : ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php elseif ($foundVacation) : ?>
            <h2><?php echo htmlspecialchars($foundVacation['title']); ?></h2>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($foundVacation['description']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($foundVacation['price'], 2); ?></p>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($foundVacation['destination']); ?></p>

            <form method="POST">
                <!-- Pass the vacation ID from the database -->
                <input type="hidden" name="vacation_id" value="<?php echo $foundVacation['vacationid']; ?>">

                <!-- Retrieve user ID from the session -->
                <?php
                // Assuming you have the user's email in the session, fetch the user ID from the database
                $userEmail = $_SESSION['email'] ?? null;
                if ($userEmail) {
                    $stmt = $pdo->prepare("SELECT userid FROM users WHERE email = :email");
                    $stmt->execute(['email' => $userEmail]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $userId = $user['userid'] ?? null;
                }
                ?>
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>" required>

                <button class="btn btn-primary" type="submit">Book Now</button>
            </form>
        <?php else : ?>
            <p class="alert alert-danger">Vacation not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
