<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">My Profile</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-3">
                <label for="userName" class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : 'John Doe'; ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo isset($_POST['userEmail']) ? htmlspecialchars($_POST['userEmail']) : 'john@example.com'; ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPreference" class="form-label">Vacation Preference</label>
                <select class="form-control" id="userPreference" name="userPreference">
                    <option value="beach" <?php echo (isset($_POST['userPreference']) && $_POST['userPreference'] == 'beach') ? 'selected' : ''; ?>>Beach</option>
                    <option value="city" <?php echo (isset($_POST['userPreference']) && $_POST['userPreference'] == 'city') ? 'selected' : ''; ?>>City</option>
                    <option value="adventure" <?php echo (isset($_POST['userPreference']) && $_POST['userPreference'] == 'adventure') ? 'selected' : ''; ?>>Adventure</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>

        <?php
        // This PHP code is to handle the form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST['userName']);
            $email = htmlspecialchars($_POST['userEmail']);
            $preference = ucfirst(htmlspecialchars($_POST['userPreference'])); 
            
            // Displaying updated information
            echo "<div class='alert alert-success mt-4'>Profile Updated Successfully!</div>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Vacation Preference:</strong> $preference</p>";
        }
        ?>
    </div>
</body>
</html>
