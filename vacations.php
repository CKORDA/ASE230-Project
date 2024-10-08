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
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Vacations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Admin Panel</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Available Vacations</h2>
        <div class="row">
            <!-- This will be dynamically populated with vacation data -->
            <div class="col-md-4">
                <div class="card">
                    <img src="vacation1.jpg" class="card-img-top" alt="Vacation Image">
                    <div class="card-body">
                        <h5 class="card-title">Tropical Beach Getaway</h5>
                        <p class="card-text">Enjoy a relaxing week on the beach with all-inclusive amenities.</p>
                        <a href="/vacation/1" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Add more vacation cards dynamically -->
        </div>
    </div>
</body>
</html>
