<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: signin.php");
    exit();
}

// Get the logged-in user's email from the session
$userEmail = $_SESSION['email'];

// Load vacation preferences from users.json
$user_data_file = 'users.json';
$users = [];

if (file_exists($user_data_file)) {
    $users = json_decode(file_get_contents($user_data_file), true);
}

// Initialize variables for pre-filling the form
$userName = "";
$budget = "";
$preference = "";

// Check if user preferences exist in users.json
if (isset($users[$userEmail])) {
    $userName = $users[$userEmail]['name'];
    $budget = $users[$userEmail]['budget'];
    $preference = $users[$userEmail]['preference'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated data from the form
    $userName = $_POST['userName'];
    $budget = $_POST['userBudget'];
    $preference = $_POST['userPreference'];

    // Update the user's vacation preferences in users.json
    $users[$userEmail] = [
        'name' => $userName,
        'email' => $userEmail,  // Email is read-only (from session)
        'budget' => $budget,
        'preference' => $preference
    ];

    // Save the updated preferences to users.json
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
        <form method="post" action="profile.php">
            <div class="mb-3">
                <label for="userName" class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($userName); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="userBudget" class="form-label">Budget</label>
                <input type="number" class="form-control" id="userBudget" name="userBudget" value="<?php echo htmlspecialchars($budget); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPreference" class="form-label">Vacation Preference</label>
                <select class="form-control" id="userPreference" name="userPreference" required>
                    <option value="beach" <?php if ($preference == 'beach') echo 'selected'; ?>>Beach</option>
                    <option value="adventure" <?php if ($preference == 'adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="city" <?php if ($preference == 'city') echo 'selected'; ?>>City</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>

        <!-- Back to Home Button -->
        <div class="text-center mt-4">
            <a href="homepage.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>
</html>
