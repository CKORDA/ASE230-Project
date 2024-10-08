<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Matcher</title>
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Vacations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admin Panel</a>
                    </li>
                </ul>
            </div>
            <form action="/logout" method="post">
				<button type="submit" class="btn btn-danger">Sign Out</button>
			</form>

        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Welcome to Vacation Matcher!</h1>
        <p class="text-center">Find your perfect vacation based on your preferences.</p>
        <div class="text-center">
            <a href="vacations.php" class="btn btn-primary">Browse Vacations</a>
        </div>
    </div>

</body>
</html>
