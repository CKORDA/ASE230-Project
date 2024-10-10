<?php
// Read vacation data from vacationdatabase.txt using @ as the separator
$vacations = file('vacationdatabase.txt', FILE_IGNORE_NEW_LINES);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Vacation Matcher</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="vacations.php">Vacations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin/adminpanel.php">Admin Panel</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Available Vacations</h2>
        <div class="row">
            <?php
            // Read the vacation data from the vacationdatabase.txt file
            $vacations = file('vacationdatabase.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($vacations as $vacation) {
                // Split the line into its components using @ as the separator
                $vacationDetails = explode('@', $vacation);
                
                // Check if the array has enough elements
                if (count($vacationDetails) < 5) {
                    continue; // Skip this entry if it doesn't have enough data
                }

                // Extract vacation details
                $vacationName = trim($vacationDetails[0]);
                $vacationDescription = trim($vacationDetails[1]);
                $vacationPrice = trim($vacationDetails[2]);
                $vacationLocation = trim($vacationDetails[3]);
                $vacationImage = trim($vacationDetails[4]);

                // Display the vacation card
            ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($vacationImage); ?>" class="card-img-top" alt="Vacation Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($vacationName); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($vacationDescription); ?></p>
                            <a href="vacationdetail.php?vacation=<?php echo urlencode($vacationName); ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
