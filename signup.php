<?php  
require_once('db.php'); // Include your database connection

// Check if a session is already active before starting one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Already Signed Up</title>
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

            .message-card {
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
            <div class="message-card">
                <div class="alert alert-warning">
                    <strong>Warning!</strong> You are already signed up. Logout to create a new account.
                </div>
                <a href="signout.php" class="btn btn-danger">Logout</a>
                <a href="homepage.php" class="btn btn-primary">Go to Homepage</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

$showForm = true;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all fields are provided
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['role'])) {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password
        $username = $_POST['username'];
        $role = $_POST['role'];

        // Check if the email already exists in the database
        $stmt = $db->prepare("SELECT * FROM users WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // If email exists, show an error
            echo '<div class="alert alert-danger text-center">Error: The email address is already registered.</div>';
        } else {
            try {
                // Prepare the SQL statement to insert data into users table
                $stmt = $db->prepare("INSERT INTO users (Username, Email, Password, Role) VALUES (:username, :email, :password, :role)");

                // Bind the parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':role', $role);

                // Execute the statement
                $stmt->execute();

                // Display success message
                echo '<div class="alert alert-success text-center">Your account has been created. Proceed to the <a href="signin.php">Sign In page</a>.</div>';
                $showForm = false;
            } catch (PDOException $e) {
                // Display error if there is an issue with the SQL execution
                echo '<div class="alert alert-danger text-center">Error: ' . $e->getMessage() . '</div>';
            }
        }
    } else {
        // Display error if any fields are empty
        echo '<div class="alert alert-danger text-center">All fields are required.</div>';
    }
}

if ($showForm) {
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
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
