<?php
require_once 'db.php';

// Start the session
session_start();

// Redirect if already signed in
if (isset($_SESSION['email'])) {
    header("Location: homepage.php");
    exit();
}


$showForm = true;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $db->prepare("SELECT * FROM users WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        // If the password is correct, set session variables
        $_SESSION['email'] = $user['Email'];   // Store email in session
        $_SESSION['role'] = $user['Role'];     // Store role in session

        // Redirect
        header("Location: homepage.php");   // Redirect to homepage if role is user
        
        exit();
    } else {
        // If credentials are invalid, show an error
        echo '<div class="alert alert-danger text-center">Invalid email or password.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('data/dino-reichmuth-A5rCN8626Ck-unsplash.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: white;
        }

        .signin-card {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            margin-top: 100px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            text-align: center;
        }

        button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signin-card">
            <h1>Sign In</h1>
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
