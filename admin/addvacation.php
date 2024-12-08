<?php
// Path to the vacation database file
$filePath = '../vacationdatabase.txt';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form inputs
    $vacationName = !empty($_POST['vacationName']) ? htmlspecialchars($_POST['vacationName']) : null;
    $vacationDescription = !empty($_POST['vacationDescription']) ? htmlspecialchars($_POST['vacationDescription']) : null;
    $vacationPrice = !empty($_POST['vacationPrice']) ? htmlspecialchars($_POST['vacationPrice']) : null;
    $vacationLocation = !empty($_POST['vacationLocation']) ? htmlspecialchars($_POST['vacationLocation']) : null;
    $vacationImage = !empty($_POST['vacationImage']) ? htmlspecialchars($_POST['vacationImage']) : null;

    // Check for required fields
    if ($vacationName && $vacationDescription && $vacationPrice && $vacationLocation && $vacationImage) {
        // Format the new vacation data
        $newVacation = $vacationName . '@' . $vacationDescription . '@' . $vacationPrice . '@' . $vacationLocation . '@' . $vacationImage;

        // Ensure a newline before appending
        $existingContent = file_get_contents($filePath);
        if (substr($existingContent, -1) !== "\n") {
            $newVacation = "\n" . $newVacation;
        }

        // Append new vacation to the file
        $result = file_put_contents($filePath, $newVacation . "\n", FILE_APPEND | LOCK_EX);
        
        if ($result === false) {
            die('Error writing to file. Please check file permissions.');
        }

        // Redirect to vacations.php
        header('Location: ../vacations.php');
        exit();
    } else {
        // Redirect back with error if fields are missing
        header('Location: addvacation.php?error=missing_fields');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Vacation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Add a New Vacation</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'missing_fields') : ?>
            <div class="alert alert-danger">Please fill out all fields!</div>
        <?php endif; ?>
        <form action="addvacation.php" method="post">
            <div class="mb-3">
                <label for="vacationName" class="form-label">Vacation Name</label>
                <input type="text" class="form-control" id="vacationName" name="vacationName" required>
            </div>
            <div class="mb-3">
                <label for="vacationDescription" class="form-label">Description</label>
                <textarea class="form-control" id="vacationDescription" name="vacationDescription" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="vacationPrice" class="form-label">Price</label>
                <input type="number" class="form-control" id="vacationPrice" name="vacationPrice" required>
            </div>
            <div class="mb-3">
                <label for="vacationLocation" class="form-label">Location</label>
                <input type="text" class="form-control" id="vacationLocation" name="vacationLocation" required>
            </div>
            <div class="mb-3">
                <label for="vacationImage" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="vacationImage" name="vacationImage" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Vacation</button>
        </form>
        <div class="mt-3">
            <a href="adminpanel.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
