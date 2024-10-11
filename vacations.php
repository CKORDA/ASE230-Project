<?php
// Load vacation data from the file
$vacation_file = 'vacationdatabase.txt';
$vacations = file($vacation_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Available Vacations</h2>
        <div class="row">
            <?php
            // Iterate through each vacation and display it as a card
            foreach ($vacations as $vacation) {
                $vacationDetails = explode('@', $vacation);
                if (count($vacationDetails) >= 5) {
                    list($vacationName, $vacationDescription, $vacationPrice, $vacationLocation, $vacationImage) = $vacationDetails;
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="<?php echo htmlspecialchars($vacationImage); ?>" class="card-img-top" alt="Vacation Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($vacationName); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($vacationDescription); ?></p>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($vacationLocation); ?></p>
                                <p><strong>Price:</strong> $<?php echo htmlspecialchars($vacationPrice); ?></p>
                                <a href="vacationdetail.php?vacation=<?php echo urlencode($vacationName); ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

    </div>
	<!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
