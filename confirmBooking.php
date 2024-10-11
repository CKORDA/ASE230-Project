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

// Get vacation name from the form
if (isset($_POST['vacationName'])) {
    $vacationName = htmlspecialchars($_POST['vacationName']);
    
    // Check if the user's profile exists
    if (isset($users[$userEmail])) {
        // Save the booked vacation to the user's profile
        $users[$userEmail]['bookedVacation'] = $vacationName;

        // Save the updated user data back to users.json
        file_put_contents($user_data_file, json_encode($users, JSON_PRETTY_PRINT));

        echo "<div class='alert alert-success text-center'>Booking confirmed for $vacationName!</div>";
        echo "<div class='text-center mt-4'>
                <a href='profile.php' class='btn btn-primary'>Back to Profile</a>
              </div>";
    } else {
        echo "<div class='alert alert-danger text-center'>User profile not found. Unable to confirm booking.</div>";
    }
} else {
    echo "<div class='alert alert-danger text-center'>No vacation selected for booking.</div>";
}
?>
