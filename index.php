
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('data/pexels-jefriwibawa-1387037.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center; 
            align-items: center; 
        }

        h1 {
            color: #333;
            font-weight: 600;
            font-size: 2.5em; 
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .nav-links li {
            margin: 15px 0; 
        }

        .nav-links a {
            text-decoration: none;
            color: black;
            font-weight: 400;
            font-size: 1.5em; 
            padding: 15px 25px; 
            border: 1px solid transparent;
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .nav-links a:hover {
            background-color: #007BFF;
            color: white;
            border-color: #007BFF;
        }

        .content-container {
            background-color: rgba(255, 255, 255, 0.97);
            padding: 40px;
            border-radius: 10px;
            display: inline-block;
            text-align: center; 
        }

    </style>
</head>
<body>

    <div class="content-container">
        <h1>Welcome to TripTinder!</h1>
        <ul class="nav-links">
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="signin.php">Sign In</a></li>
            <li><a href="signout.php">Sign Out</a></li>
            <li><a href="public.php">Public</a></li>
            <li><a href="private.php">Private</a></li>
        </ul>
    </div>

</body>
</html>
