<?php
session_start();

// Include database connection
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

$email = $_SESSION['email']; // Logged-in user's email

// Initialize variables for the profile form
$name = "";
$dateOfBirth = "";
$preferences = [];
$budget = ""; // Assuming "budget" needs to be added manually, as it's not in the database schema.

try {
    // Fetch user details from the database
    $stmt = $db->prepare("SELECT Username, Email, DateOfBirth, Preferences FROM users WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $name = $user['Username'];
        $dateOfBirth = $user['DateOfBirth'];
        $preferences = json_decode($user['Preferences'], true) ?? [];
    } else {
        echo '<div class="alert alert-danger text-center">User profile not found.</div>';
        exit();
    }

    // Handle form submission to update user details
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['userName'];
        $dateOfBirth = $_POST['userDob'];
        $preferences = json_encode([
            "destination" => $_POST['userDestination'],
            "category" => $_POST['userCategory']
        ]);

        // Update user details in the database
        $updateStmt = $db->prepare("UPDATE users SET Username = :name, DateOfBirth = :dob, Preferences = :preferences WHERE Email = :email");
        $updateStmt->bindParam(':name', $name);
        $updateStmt->bindParam(':dob', $dateOfBirth);
        $updateStmt->bindParam(':preferences', $preferences);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->execute();

        $success_message = "Profile updated successfully!";
    }
} catch (PDOException $e) {
    echo '<div class="alert alert-danger text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    exit();
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
                <li class="nav-item">
                    <a class="nav-link" href="admin/adminpanel.php">Admin Panel</a>
                </li>
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
                <select class="form-control" id="userPreference" name="userDestination">
                    <option value="Beach" <?php if (isset($preferences['destination']) && $preferences['destination'] == 'Beach') echo 'selected'; ?>>Beach</option>
                    <option value="Adventure" <?php if (isset($preferences['destination']) && $preferences['destination'] == 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="City" <?php if (isset($preferences['destination']) && $preferences['destination'] == 'City') echo 'selected'; ?>>City</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="userCategory" class="form-label">Category</label>
                <select class="form-control" id="userCategory" name="userCategory">
                    <option value="Adventure" <?php if (isset($preferences['category']) && $preferences['category'] == 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="Relaxation" <?php if (isset($preferences['category']) && $preferences['category'] == 'Relaxation') echo 'selected'; ?>>Relaxation</option>
                    <option value="Cultural" <?php if (isset($preferences['category']) && $preferences['category'] == 'Cultural') echo 'selected'; ?>>Cultural</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success text-center mt-4">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <div class="mt-5">
            <h4 class="text-center">Updated Profile Information:</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                <li class="list-group-item"><strong>Budget:</strong> <?php echo htmlspecialchars($budget); ?></li>
                <li class="list-group-item"><strong>Vacation Preference:</strong> <?php echo htmlspecialchars($preferences['destination'] ?? 'N/A'); ?></li>
                <li class="list-group-item"><strong>Category:</strong> <?php echo htmlspecialchars($preferences['category'] ?? 'N/A'); ?></li>
            </ul>
        </div>

        <div class="text-center mt-4">
            <a href="homepage.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
