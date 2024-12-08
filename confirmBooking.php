<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

// Get the logged-in user's email from the session
$userEmail = $_SESSION['email'];

// Load vacation preferences and existing data from users.json
$user_data_file = 'users.json';
$users = [];

if (file_exists($user_data_file)) {
    $users = json_decode(file_get_contents($user_data_file), true);
}

if (isset($_POST['vacationName'])) {
    $vacationName = htmlspecialchars($_POST['vacationName']);
    
    if (isset($users[$userEmail])) {
        $users[$userEmail]['bookedVacation'] = $vacationName;

        file_put_contents($user_data_file, json_encode($users, JSON_PRETTY_PRINT));
        
        $message = "Congratulations! <br> Your booking is now confirmed for <br> $vacationName!";
    } else {
        $message = "User profile not found. Unable to confirm booking.";
    }
} else {
    $message = "No vacation selected for booking.";
}
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
