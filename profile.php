<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

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

    echo "<div class='alert alert-success text-center'>Profile updated successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">User Profile</h2>
        
        <!-- Profile Update Form -->
        <form method="post" action="profile.php">
            <div class="mb-3">
                <label for="userName" class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email (Read-Only)</label>
                <input type="email" class="form-control" id="userEmail" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="userBudget" class="form-label">Budget</label>
                <input type="number" class="form-control" id="userBudget" name="userBudget" value="<?php echo htmlspecialchars($budget); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPreference" class="form-label">Vacation Preference</label>
                <select class="form-control" id="userPreference" name="userPreference">
                    <option value="beach" <?php if ($preference == 'beach') echo 'selected'; ?>>Beach</option>
                    <option value="adventure" <?php if ($preference == 'adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="city" <?php if ($preference == 'city') echo 'selected'; ?>>City</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>

        <!-- Display Booked Vacation -->
        <?php if (!empty($bookedVacation)): ?>
            <div class="mt-4">
                <h4>Booked Vacation</h4>
                <p>You have booked: <strong><?php echo htmlspecialchars($bookedVacation); ?></strong></p>
            </div>
        <?php endif; ?>
        
        <!-- Back to Home Button -->
        <div class="text-center mt-4">
            <a href="homepage.php" class="btn btn-secondary">Back to Home</a>
        </div>
        
    </div>
</body>
</html>
