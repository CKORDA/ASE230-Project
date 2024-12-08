<?php
// Define the path to the JSON file containing user data
$user_data_file = '../users.json';

// Load existing user data
$users = [];
if (file_exists($user_data_file)) {
    $users = json_decode(file_get_contents($user_data_file), true);
    if (!is_array($users)) {
        $users = [];
    }
}

// Initialize variables
$name = "";
$email = "";
$budget = "";
$preference = "";

// Check if a user is selected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedEmail']) && $_POST['selectedEmail'] !== "") {
    $email = $_POST['selectedEmail'];
    if (isset($users[$email])) {
        $name = $users[$email]['name'];
        $budget = $users[$email]['budget'];
        $preference = $users[$email]['preference'];
    }
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userName'])) {
    $name = trim($_POST['userName']);
    $email = trim($_POST['userEmail']); // Read-only field, so should already be valid
    $budget = trim($_POST['userBudget']);
    $preference = trim($_POST['userPreference']);

    // Validate data
    if ($name && $email && $budget && $preference) {
        // Update user data
        $users[$email] = [
            'name' => $name,
            'email' => $email,
            'budget' => $budget,
            'preference' => $preference,
        ];

        // Save updated users to the JSON file
        file_put_contents($user_data_file, json_encode($users, JSON_PRETTY_PRINT));

        // Success message
        echo "<div class='alert alert-success text-center'>User profile updated successfully!</div>";
    } else {
        // Error message
        echo "<div class='alert alert-danger text-center'>Please fill in all fields correctly.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit User</h2>

        <!-- Form to select user by email -->
        <form method="post" action="edituser.php" class="mb-4">
            <div class="mb-3">
                <label for="selectedEmail" class="form-label">Select User by Email</label>
                <select class="form-select" id="selectedEmail" name="selectedEmail" onchange="this.form.submit()">
                    <option value="">-- Select an Email --</option>
                    <?php foreach ($users as $userEmail => $user) : ?>
                        <option value="<?= htmlspecialchars($userEmail); ?>" <?= (isset($_POST['selectedEmail']) && $_POST['selectedEmail'] === $userEmail) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($userEmail); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Form to edit user details -->
        <?php if ($email) : ?>
        <form method="post" action="edituser.php">
            <div class="mb-3">
                <label for="userName" class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?= htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?= htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="userBudget" class="form-label">Budget</label>
                <input type="number" class="form-control" id="userBudget" name="userBudget" value="<?= htmlspecialchars($budget); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPreference" class="form-label">Vacation Preference</label>
                <select class="form-select" id="userPreference" name="userPreference">
                    <option value="beach" <?= ($preference === 'beach') ? 'selected' : ''; ?>>Beach</option>
                    <option value="adventure" <?= ($preference === 'adventure') ? 'selected' : ''; ?>>Adventure</option>
                    <option value="city" <?= ($preference === 'city') ? 'selected' : ''; ?>>City</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
        <?php endif; ?>

        <!-- Back to Admin Panel Button -->
        <div class="text-center mt-4">
            <a href="adminpanel.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
