<?php
// Database connection
$host = 'localhost'; // Replace with database host
$dbname = 'triptinder'; // Replace with database name
$username = 'root'; // Replace with database username
$password = ''; // Replace with database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize variables for pre-filling the form
$username = "";
$email = "";
$preferences = "";

// If an email is selected, load the user's data (check if selectedEmail is set)
if (isset($_POST['selectedEmail']) && $_POST['selectedEmail'] !== "") {
    $email = $_POST['selectedEmail'];

    // Fetch user data from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['Username'];
        $preferences = json_decode($user['Preferences'], true); // Decoding JSON data for preferences
    }
}

// Update the user information if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userName'])) {
    $username = $_POST['userName'];
    $email = $_POST['userEmail'];
    $preferences = $_POST['userPreference']; // Handle preferences as per your needs

    try {
        // Prepare SQL statement to update user data
        $stmt = $pdo->prepare("UPDATE users SET Username = :username, Preferences = :preferences WHERE Email = :email");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':preferences' => json_encode($preferences), // Encode preferences as JSON
        ]);

        echo "<div class='alert alert-success text-center'>User profile updated successfully!</div>";
    } catch (PDOException $e) {
        die("Failed to update user: " . $e->getMessage());
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
                <select class="form-control" id="selectedEmail" name="selectedEmail" onchange="this.form.submit()">
                    <option value="">-- Select an Email --</option>
                    <?php
                    // Fetch all users' emails from the database
                    $stmt = $pdo->query("SELECT Email FROM users");
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Loop through users and display them in the select dropdown
                    foreach ($users as $user) {
                        echo '<option value="' . htmlspecialchars($user['Email']) . '" ' . ($email == $user['Email'] ? 'selected' : '') . '>' . htmlspecialchars($user['Email']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </form>

        <!-- Form to edit user details -->
        <?php if ($email) : ?>
        <form method="post" action="edituser.php">
            <div class="mb-3">
                <label for="userName" class="form-label">Username</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="userPreference" class="form-label">Vacation Preference</label>
                <select class="form-control" id="userPreference" name="userPreference">
                    <option value="beach" <?php if (isset($preferences) && in_array('beach', $preferences)) echo 'selected'; ?>>Beach</option>
                    <option value="adventure" <?php if (isset($preferences) && in_array('adventure', $preferences)) echo 'selected'; ?>>Adventure</option>
                    <option value="city" <?php if (isset($preferences) && in_array('city', $preferences)) echo 'selected'; ?>>City</option>
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
