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
            <form action="/logout" method="post">
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
