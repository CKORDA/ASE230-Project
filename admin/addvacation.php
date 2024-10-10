<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and replace empty values with '@'
    $vacationName = !empty($_POST['vacationName']) ? $_POST['vacationName'] : '@';
    $vacationDescription = !empty($_POST['vacationDescription']) ? $_POST['vacationDescription'] : '@';
    $vacationPrice = !empty($_POST['vacationPrice']) ? $_POST['vacationPrice'] : '@';
    $vacationLocation = !empty($_POST['vacationLocation']) ? $_POST['vacationLocation'] : '@';
    $vacationImage = !empty($_POST['vacationImage']) ? $_POST['vacationImage'] : '@';

    // Format the vacation data using @ as a separator
    $vacationData = $vacationName . '@' . $vacationDescription . '@' . $vacationPrice . '@' . $vacationLocation . '@' . $vacationImage . "\n";

    // Write the data to vacationdatabase.txt
    file_put_contents('../vacationdatabase.txt', $vacationData, FILE_APPEND | LOCK_EX);

    // Redirect to vacations.php after successful saving
    header('Location: ../vacations.php');
    exit(); // Always call exit after header redirect to prevent further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Vacation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Add a New Vacation</h2>
        <form action="addvacation.php" method="post"> <!-- Keep the action pointing to this file -->
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
    </div>
</body>
</html>
