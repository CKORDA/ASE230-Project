<?php
require_once('functions.php');

// If the user is already signed in, redirect to homepage.php
if (isset($_SESSION['email'])) {
    header("Location: homepage.php");
    exit();
}

$showForm = true;

if (count($_POST) > 0) {
    if (isset($_POST['email'][0]) && isset($_POST['password'][0])) {
        // Open the CSV file for reading
        $fp = fopen(__DIR__ . '/data/users.csv.php', 'r');
        if ($fp === false) {
            error_log("Error opening the file: data/users.csv.php"); // Log the error
            echo '<div class="alert alert-danger text-center">We are experiencing technical issues. Please try again later.</div>';
            exit();
        }

        $found = false;

        while (!feof($fp)) {
            $line = fgets($fp); 
            if ($line === false) continue; 

            // Ignore invalid lines
            if (strstr($line, '<?php die() ?>') || strlen($line) < 5) continue;

            $line = explode(';', trim($line));

            // Check if the credentials match
            if (count($line) >= 2 && $line[0] == $_POST['email'] && password_verify($_POST['password'], $line[1])) {
                // Sign the user in
                $_SESSION['email'] = $_POST['email'];

                // Redirect to homepage.php after login
                header("Location: homepage.php");
                exit();

                $showForm = false;
                $found = true; // Set flag to true if found
                break; // Exit loop on successful login
            }
        }

        fclose($fp); // Close the file

        // If no matching credentials were found
        if (!$found) {
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
