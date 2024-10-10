<?php
// Read the vacation data from the vacationdatabase.txt file
$vacations = file('../vacationdatabase.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Check if the vacation is being edited
$vacationToEdit = '';
if (isset($_GET['vacation'])) {
    $vacationToEdit = $_GET['vacation'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vacation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Vacation</h2>
        
        <form action="editvacation_process.php" method="post">
            <div class="mb-3">
                <label for="vacation" class="form-label">Select Vacation to Edit</label>
                <select class="form-select" id="vacation" name="vacation" onchange="loadVacationDetails(this.value)" required>
                    <option value="">-- Choose a Vacation --</option>
                    <?php
                    foreach ($vacations as $vacation) {
                        $vacationDetails = explode('@', $vacation);
                        echo '<option value="' . htmlspecialchars(trim($vacationDetails[0])) . '"' . ($vacationToEdit === trim($vacationDetails[0]) ? ' selected' : '') . '>' . htmlspecialchars(trim($vacationDetails[0])) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div id="vacationDetails" style="display: none;">
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
            </div>

            <button type="submit" class="btn btn-primary">Update Vacation</button>
        </form>
        <div class="mt-3">
            <a href="../vacations.php" class="btn btn-secondary">Back to Vacations</a>
        </div>
    </div>

    <script>
        function loadVacationDetails(vacationName) {
            const vacationData = <?php echo json_encode($vacations); ?>;
            const detailsDiv = document.getElementById('vacationDetails');
            detailsDiv.style.display = vacationName ? 'block' : 'none';

            if (vacationName) {
                const vacationInfo = vacationData.find(vacation => vacation.startsWith(vacationName));
                if (vacationInfo) {
                    const details = vacationInfo.split('@');
                    document.getElementById('vacationDescription').value = details[1].trim();
                    document.getElementById('vacationPrice').value = details[2].trim();
                    document.getElementById('vacationLocation').value = details[3].trim();
                    document.getElementById('vacationImage').value = details[4].trim();
                }
            }
        }
    </script>
</body>
</html>
