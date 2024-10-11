<?php
// Read the vacation data from the vacationdatabase.txt file
$vacations = file('../vacationdatabase.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
                    foreach ($vacations as $vacation) {
                        $vacationDetails = explode('@', $vacation);
                        echo '<option value="' . htmlspecialchars(trim($vacationDetails[0])) . '">' . htmlspecialchars(trim($vacationDetails[0])) . '</option>';
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
