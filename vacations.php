<?php
// Include the database connection
include 'db.php';

try {
    // Fetch all vacations from the database
    $query = $pdo->query("SELECT Title, Description, Price, Destination, Itinerary FROM vacation");
    $vacations = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the error and provide a user-friendly message
    error_log("Error fetching vacations: " . $e->getMessage()); // Log the error
    echo '<div class="alert alert-danger text-center">We are experiencing technical issues. Please try again later.</div>';
    exit(); // Stop script execution after error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/data/manuel-cosentino-n--CMLApjfI-unsplash.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }

        .content {
            background-color: rgba(0, 0, 0, 0.5); 
            padding: 30px; 
            border-radius: 10px; 
            margin-top: 50px; 
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
            <form action="../signout.php" method="post">
                <button type="submit" class="btn btn-danger">Sign Out</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="content">
            <h2 class="text-center">Available Vacations</h2>
            <div class="row">
                <?php
                // Iterate through each vacation and display it as a card
                foreach ($vacations as $vacation) {
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($vacation['Title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($vacation['Description']); ?></p>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($vacation['Destination']); ?></p>
                                <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($vacation['Price'], 2)); ?></p>
                                <a href="vacationdetail.php?vacation=<?php echo urlencode($vacation['Title']); ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
