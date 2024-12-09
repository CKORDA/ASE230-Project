<?php
// Database connection
$host = 'localhost'; // Replace with database host
$dbname = 'triptinder'; // Replace with database name
$username = 'root'; // Replace with database username
$password = ''; // Replace with database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception("Database connection failed: " . $e->getMessage());
}

// Fetch vacations from the database
$stmt = $pdo->query("SELECT Title FROM vacation");
$vacations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vacation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmDeletion() {
            return confirm('Are you sure you want to delete this vacation?');
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Delete a Vacation</h2>
        <form action="deletevacation_process.php" method="post" onsubmit="return confirmDeletion();">
            <div class="mb-3">
                <label for="vacation" class="form-label">Select Vacation to Delete</label>
                <select class="form-select" id="vacation" name="vacation" required>
                    <option value="">-- Choose a Vacation --</option>
                    <?php
                    // Loop through vacations and display them in the select dropdown
                    foreach ($vacations as $vacation) {
                        echo '<option value="' . htmlspecialchars($vacation['Title']) . '">' . htmlspecialchars($vacation['Title']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Delete Vacation</button>
        </form>
        <div class="mt-3">
            <a href="adminpanel.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
