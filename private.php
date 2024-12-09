<?php
session_start(); // Ensure session is started
require_once('functions.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    error_log("Unauthorized access attempt to private.php"); // Log the event
    echo '<p>This is a private page. You are not allowed here.</p>';
    echo '<p><a href="index.php">Go back to the login page</a></p>';
    exit(); // End script execution gracefully
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Page</title>
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

        .private-card {
            background-color: rgba(0, 128, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            margin-top: 100px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .private-card h1 {
            font-size: 24px;
        }

        .private-card p {
            font-size: 20px;
        }

        .private-card a {
            color: #1e90ff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .private-card a:hover {
            color: #ff7f50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="private-card">
            <h1>Private</h1>
            <p><?= htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><a href="index.php">Go back to the login page</a></p>
        </div>
    </div>
</body>
</html>
