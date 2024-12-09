<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

// Get the logged-in user's email from the session
$userEmail = $_SESSION['email'];

// Prepare database connection
$db_host = 'localhost';  // Replace with database host (typically localhost)
$db_user = 'root';       // Replace with database username
$db_pass = '';           // Replace with database password (if any)
$db_name = 'triptinder'; // Replace with actual database name
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name); // Replace with your DB credentials
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error); // Log the error
    $message = "We are experiencing technical issues. Please try again later.";
}

$message = "No vacation selected for booking."; // Default message

if (isset($_POST['Title'])) {
    $vacationTitle = $conn->real_escape_string($_POST['Title']);
    
    // Get the VacationID based on the selected vacation Title
    $query = "SELECT VacationID FROM vacation WHERE Title = '$vacationTitle'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $vacation = $result->fetch_assoc();
        $vacationID = $vacation['VacationID'];

        // Get the UserID based on the user's email
        $userQuery = "SELECT UserID FROM users WHERE Email = '$userEmail'";
        $userResult = $conn->query($userQuery);
        
        if ($userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();
            $userID = $user['UserID'];

            // Insert booking into the booking table
            $insertBookingQuery = "INSERT INTO booking (UserID, VacationID) VALUES ('$userID', '$vacationID')";
            if ($conn->query($insertBookingQuery) === TRUE) {
                $message = "Congratulations! <br> Your booking is now confirmed for <br> $vacationTitle!";
            } else {
                $message = "Error confirming your booking. Please try again.";
            }
        } else {
            $message = "User not found.";
        }
    } else {
        $message = "The selected vacation does not exist.";
    }
} else {
    $message = "No vacation selected for booking.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('data/samuel-clara-yUWKDfPLp6w-unsplash.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            text-align: center;
            margin: 0;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
        }

        .alert {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .btn {
            font-size: 1.2rem;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($message)) : ?>
            <div class="alert alert-success text-center"><?php echo $message; ?></div>
            <div class="text-center mt-4">
                <a href="profile.php" class="btn btn-primary">Back to Profile</a>
            </div>
        <?php else : ?>
            <div class="alert alert-danger text-center"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
