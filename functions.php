<?php
// Start a session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Function to check if the user is logged in.
 * Redirects to the login page if the user is not authenticated.
 */
function isAuthenticated() {
    if (!isset($_SESSION['email'])) {
        header("Location: signin.php");
        exit();
    }
}

/**
 * Function to check access based on user roles.
 * 
 * @param array $allowedRoles Array of allowed roles for the page.
 */
function checkAccess($allowedRoles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
        // Redirect to an unauthorized page
        header("Location: unauthorized.php");
        exit();
    }
}

/**
 * Function to destroy the session and log the user out.
 * Redirects to the signin page after logging out.
 */
function logoutUser() {
    session_destroy();
    header("Location: signin.php");
    exit();
}

/**
 * Function to set user session data.
 * 
 * @param string $email User's email address.
 * @param string $role  User's role (e.g., 'user', 'admin').
 */
function setUserSession($email, $role) {
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
}

/**
 * Utility function to get the current user's role.
 * 
 * @return string|null Returns the role of the current user or null if not logged in.
 */
function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}
?>
