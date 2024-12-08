<?php
// Path to the vacation database
$filePath = '../vacationdatabase.txt';

// Load vacation data
$vacations = file_exists($filePath) ? file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

// Handle empty file or unreadable data
if (!$vacations) {
    $vacations = [];
}
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
        
        <?php if (!empty($vacations)) : ?>
            <form action="deletevacation_process.php" method="post" onsubmit="return confirmDeletion();">
                <div class="mb-3">
                    <label for="vacation" class="form-label">Select Vacation to Delete</label>
                    <select class="form-select" id="vacation" name="vacation" required>
                        <option value="">-- Choose a Vacation --</option>
                        <?php foreach ($vacations as $index => $vacation) : ?>
                            <?php $details = explode('@', $vacation); ?>
                            <option value="<?= $index ?>">
                                <?= htmlspecialchars($details[0]) ?> (<?= htmlspecialchars($details[3]) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger">Delete Vacation</button>
            </form>
        <?php else : ?>
            <p class="text-center text-danger">No vacations available to delete.</p>
        <?php endif; ?>
        
        <div class="mt-3">
            <a href="adminpanel.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
