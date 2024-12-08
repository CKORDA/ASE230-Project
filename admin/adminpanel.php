<?php 
// Start the session
session_start();

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    // If not an admin, display a message and redirect them to the homepage after a few seconds
    echo '<div class="alert alert-danger text-center">You are not authorized to access this page. Only admins are allowed.</div>';
    
    // Corrected HTML output
    echo '<div class="text-center mt-4">
            <a href="../homepage.php" class="btn btn-secondary">Back to Home</a>
          </div>';
    exit(); // Ensure no further code is executed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Vacation Matcher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Vacation Matcher</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile.php">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vacations.php">Vacations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/adminpanel.php">Admin Panel</a>
                    </li>
                </ul>
            </div>
            <form action="signout.php" method="post">
                <button type="submit" class="btn btn-danger">Sign Out</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Admin Panel</h1>
        <p class="text-center">Manage Vacations</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="addvacation.php" class="btn btn-success">Add Vacation</a>
            <a href="editvacation.php" class="btn btn-warning">Edit Vacation</a>
            <a href="deletevacation.php" class="btn btn-danger">Delete Vacation</a>
        </div>
        <p class="text-center">Manage Users</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="edituser.php" class="btn btn-primary">Edit User</a>
        </div>
    </div>
</body>
</html>
