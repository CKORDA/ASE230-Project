<?php
require_once('db.php');

// Check if a session is already active before starting a new one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If the user is already signed in, redirect to homepage.php
if (isset($_SESSION['email'])) {
    // Check if the user is an admin and redirect accordingly
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/adminpanel.php");  // Redirect to the admin panel
    } else {
        header("Location: homepage.php");  // Redirect to the homepage
    }
    exit();
}

$showForm = true;

if (count($_POST) > 0) {
    if (isset($_POST['email'][0]) && isset($_POST['password'][0])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Query the database to check if the user exists
        $stmt = $db->prepare("SELECT * FROM users WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user exists and the password matches
        if ($user && password_verify($password, $user['Password'])) {
            // Start session and set session variables
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['Role']; // User role from the database

            // Redirect based on role after login
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin/adminpanel.php");  // Redirect to admin panel if admin
            } else {
                header("Location: homepage.php");  // Redirect to homepage if user
            }
            exit();
        } else {
            echo '<div class="alert alert-danger text-center">Your credentials are wrong</div>';
        }
    } else {
        echo '<div class="alert alert-warning text-center">Email and password are missing</div>';
    }
}

if ($showForm) {
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
                font-family: 'Arial', sans-serif; 
                font-weight: bold; 
                text-align: center; 
            }

            button {
                width: 100%; 
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="signin-card mx-auto">
                <h1>Sign In</h1>
                <form method="POST" class="mt-4">
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
    <?php
}
?>
