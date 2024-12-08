<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

// Determine if the user is an admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Load existing user data (if any)
$user_data_file = 'users.json';
$users = [];

if (file_exists($user_data_file)) {
    $users = json_decode(file_get_contents($user_data_file), true);
}

// Get logged-in user's email
$userEmail = $_SESSION['email'];

// Initialize variables for pre-filling the form
$name = "";
$email = $userEmail;
$budget = "";
$preference = "";
$bookedVacation = "";

// Check if the user's profile exists
if (isset($users[$email])) {
    $name = $users[$email]['name'];
    $budget = $users[$email]['budget'];
    $preference = $users[$email]['preference'];
    
    // Check if a vacation is booked
    if (isset($users[$email]['bookedVacation'])) {
        $bookedVacation = $users[$email]['bookedVacation'];
    }
}

// Handle form submission to update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['userName'];
    $budget = $_POST['userBudget'];
    $preference = $_POST['userPreference'];

    // Update the user's profile
    $users[$email] = [
        'name' => $name,
        'email' => $email,
        'budget' => $budget,
        'preference' => $preference,
        'bookedVacation' => $bookedVacation // Keep the booked vacation intact
    ];

    // Save to JSON file
    file_put_contents($user_data_file, json_encode($users, JSON_PRETTY_PRINT));

    $success_message = "Profile updated successfully!";
}

// If the user is editing an existing profile, pre-fill the form
if (isset($users[$email])) {
    $name = $users[$email]['name'];
    $budget = $users[$email]['budget'];
    $preference = $users[$email]['preference'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar .btn-signout {
            margin-right: 20px; /* Adjust this value for more or less spacing */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Vacation Matcher</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="profile.php">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vacations.php">Vacations</a>
                </li>
                <!-- Show Admin Panel link only for admins -->
                <?php if ($isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin/adminpanel.php">Admin Panel</a>
                </li>
                <?php endif; ?>
            </ul>
            <form action="signout.php" method="post" class="d-flex ms-auto">
                <button class="btn btn-danger btn-signout" type="submit">Sign Out</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">User Profile</h2>
        <form method="post" action="profile.php">
            <div class="mb-3">
                <label for="userName" class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userBudget" class="form-label">Budget</label>
                <input type="number" class="form-control" id="userBudget" name="userBudget" value="<?php echo htmlspecialchars($budget); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPreference" class="form-label">Vacation Preference</label>
                <select class="form-control" id="userPreference" name="userPreference">
                    <option value="Beach" <?php if ($preference == 'Beach') echo 'selected'; ?>>Beach</option>
                    <option value="Adventure" <?php if ($preference == 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="City" <?php if ($preference == 'City') echo 'selected'; ?>>City</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success text-center mt-4">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($users[$email])): ?>
            <div class="mt-5">
                <h4 class="text-center">Updated Profile Information:</h4>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                    <li class="list-group-item"><strong>Budget:</strong> <?php echo htmlspecialchars($budget); ?></li>
                    <li class="list-group-item"><strong>Vacation Preference:</strong> <?php echo htmlspecialchars($preference); ?></li>
                </ul>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="homepage.php" class="btn btn-secondary">Back to Home</a>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
