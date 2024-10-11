<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
         body {
            background-image: url('data/vacation.jpg');
            background-size: cover; /* Ensures the image covers the whole page */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents repeating the image */
            font-family: Arial, sans-serif;
            margin: 0; /* Removes default margin */
            padding: 20px; /* Adds padding */
            text-align: center; /* Centers the text */
            height: 100vh; /* Full height */
        }
        h1 {
            color: #333;
        }
        .nav-links {
            list-style: none;
            padding: 0;
        }
        .nav-links li {
            margin: 10px 0;
        }
        .nav-links a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .nav-links a:hover {
            background-color: #007BFF;
            color: white;
            border-color: #007BFF;
        }
    </style>
</head>
<body>

    <h1>Welcome to TripTinder!</h1>
    <ul class="nav-links">
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="signin.php">Sign In</a></li>
        <li><a href="signout.php">Sign Out</a></li>
        <li><a href="public.php">Public</a></li>
        <li><a href="private.php">Private</a></li>
    </ul>

</body>
</html>
