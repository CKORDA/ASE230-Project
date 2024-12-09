<?php
// Include database connection
require 'db.php'; // Assuming db.php contains your PDO connection setup

try {
    // Fetch number of available vacations from the database
    $stmt = $pdo->query("SELECT COUNT(*) FROM vacation"); // Use $pdo here
    $vacationCount = $stmt->fetchColumn();
} catch (PDOException $e) {
    // Log the error for debugging purposes
    error_log("Error fetching vacation count: " . $e->getMessage(), 3, 'error_log.txt');

    // Display a user-friendly error message
    echo "<div style='color: red; text-align: center;'>
            Unable to fetch vacation data. Please try again later.
          </div>";

    // Set a default value to avoid further script issues
    $vacationCount = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Matcher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .background-section {
            background-image: url('data/pexels-emrecan-2079284.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh; 
            display: flex;
            justify-content: center; 
            align-items: center; 
            text-align: center; 
            padding: 50px 0;
            color: white;
        }

        .background-section h1, .background-section p {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
        }

        .background-section .btn {
            margin-top: 20px;
        }
    </style>
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
                        <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vacations.php">Vacations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/adminpanel.php">Admin Panel</a>
                    </li>
                </ul>
            </div>
            <form action="signout.php" method="post">
                <button type="submit" class="btn btn-danger">Sign Out</button>
            </form>
        </div>
    </nav>

    <!-- Background section starts here -->
    <div class="background-section">
        <div>
            <h1>Welcome to TripTinder</h1>
            <p>Find your perfect vacation based on your preferences.</p>
            <p>We currently have <?php echo htmlspecialchars($vacationCount); ?> amazing vacations available for you!</p>
            <a href="vacations.php" class="btn btn-primary">Browse Vacations</a>
        </div>
    </div>
    <!-- End of background section -->

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
