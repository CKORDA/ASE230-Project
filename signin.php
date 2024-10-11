<?php
session_start(); // Start the session
require_once('functions.php');

// Check if the user is already signed in
if (isset($_SESSION['email'])) {
    die('You are already signed in.');
}

$showForm = true;

if (count($_POST) > 0) {
    if (isset($_POST['email'][0]) && isset($_POST['password'][0])) {
        // Open the CSV file for reading
        $fp = fopen(__DIR__ . '/data/users.csv.php', 'r');
        if ($fp === false) {
            die('Error opening the file.');
        }

        $found = false; // Flag to check if credentials match

        while (!feof($fp)) {
            $line = fgets($fp); // Read a line from the file
            if ($line === false) continue; // Skip if there was an error reading

            // Ignore invalid lines
            if (strstr($line, '<?php die() ?>') || strlen($line) < 5) continue;

            $line = explode(';', trim($line));

            // Check if the credentials match
            if (count($line) >= 2 && $line[0] == $_POST['email'] && password_verify($_POST['password'], $line[1])) {
                // Sign the user in
                $_SESSION['email'] = $_POST['email'];

                // Redirect to homepage
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
            echo 'Your credentials are wrong';
        }

    } else {
        echo 'Email and password are missing';
    }
}

if ($showForm) {
?>
    <h1>Sign In</h1>
    <form method="POST">
        Email<br />
        <input type="email" name="email" required /><br /><br />
        Password<br />
        <input type="password" name="password" required /><br /><br />
        <button type="submit">Sign in</button>
    </form>
<?php
}
?>
