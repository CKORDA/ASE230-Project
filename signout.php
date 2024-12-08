<?php
require_once('functions.php');

// Check if a session is active before attempting to destroy it
if (session_status() === PHP_SESSION_ACTIVE) {
    // Start the session if not already started
    if (!isset($_SESSION)) {
        session_start();
    }

    // Retrieve and log the user's role before signing out
    if (isset($_SESSION['role'])) {
        $userEmail = $_SESSION['email'] ?? 'unknown';
        $userRole = $_SESSION['role'];

        // Example: Log the signout event (optional)
        $logFile = __DIR__ . '/logs/signout.log';
        file_put_contents(
            $logFile,
            "User: $userEmail with Role: $userRole signed out at " . date('Y-m-d H:i:s') . PHP_EOL,
            FILE_APPEND
        );
    }

    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Redirect users to different pages based on their role
if (isset($userRole) && $userRole === 'admin') {
    header("Location: admin_login.php"); // Redirect to admin login page
} else {
    header("Location: signin.php"); // Redirect to general sign-in page
}

exit();
?>
