<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Page</title>
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

        .public-card {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            margin-top: 100px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .public-card a {
            color: #1e90ff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .public-card a:hover {
            color: #ff7f50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="public-card">
            <h1>Public</h1>
            <p><a href="index.php">Go back to the login page</a></p>
        </div>
    </div>
</body>
</html>
