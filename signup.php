<?php
// Include the database connection file
require_once 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $preferences = $_POST['preferences'] ?? '';

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!empty($dob) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        $error = "Invalid date format. Use YYYY-MM-DD.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        try {
            $stmt = $pdo->prepare("INSERT INTO users (Username, Email, Password, DateOfBirth, Preferences) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword, $dob, $preferences ? json_encode($preferences) : null]);

            // Redirect to the signin page
            header("Location: signin.php");
            exit();
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $error = "Email already exists. Please use a different email.";
            } else {
                $error = "An error occurred: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/data/dino-reichmuth-A5rCN8626Ck-unsplash.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: white;
        }

        .signup-card {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            margin-top: 100px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signup-card">
            <h1>Sign Up</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required />
                </div>
                <div class="mb-3">
                    <label for="preferences" class="form-label">Preferences</label>
                    <textarea class="form-control" id="preferences" name="preferences" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
