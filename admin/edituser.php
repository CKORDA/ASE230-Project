<?php
// Load existing user data from JSON
$user_data_file = '../users.json';
$users = [];

if (file_exists($user_data_file)) {
    $users = json_decode(file_get_contents($user_data_file), true);
}

// Initialize variables for pre-filling the form
$name = "";
$email = "";
$budget = "";
$preference = "";

// If an email is selected, load the user's data (check if selectedEmail is set)
if (isset($_POST['selectedEmail']) && $_POST['selectedEmail'] !== "") {
    $email = $_POST['selectedEmail'];

    if (isset($users[$email])) {
        $name = $users[$email]['name'];
        $budget = $users[$email]['budget'];
        $preference = $users[$email]['preference'];
    }
}

// Update the user information if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userName'])) {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $budget = $_POST['userBudget'];
    $preference = $_POST['userPreference'];

    // Update the user's data in the array
    $users[$email] = [
        'name' => $name,
        'email' => $email,
        'budget' => $budget,
        'preference' => $preference
    ];

    // Save the updated users array to the JSON file
    file_put_contents($user_data_file, json_encode($users, JSON_PRETTY_PRINT));

    echo "<div class='alert alert-success text-center'>User profile updated successfully!</div>";
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
                <select class="form-control" id="selectedEmail" name="selectedEmail" onchange="this.form.submit()">
                    <option value="">-- Select an Email --</option>
                    <?php foreach ($users as $email => $user) : ?>
                        <option value="<?php echo htmlspecialchars($email); ?>" <?php if (isset($_POST['selectedEmail']) && $_POST['selectedEmail'] == $email) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($email); ?>
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
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($email); ?>" readonly>
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
