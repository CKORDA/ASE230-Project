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

// Fetch vacations for the select dropdown
$stmt = $pdo->query("SELECT VacationID, Title FROM vacation");
$vacations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch selected vacation details if available
$vacationDetails = [];
if (isset($_GET['vacationID'])) {
    $vacationID = $_GET['vacationID'];
    
    $stmt = $pdo->prepare("SELECT * FROM vacation WHERE VacationID = :vacationID");
    $stmt->execute([':vacationID' => $vacationID]);
    $vacationDetails = $stmt->fetch(PDO::FETCH_ASSOC);
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
                        echo '<option value="' . $vacation['VacationID'] . '"' . (isset($vacationID) && $vacationID == $vacation['VacationID'] ? ' selected' : '') . '>' . htmlspecialchars($vacation['Title']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <?php if (!empty($vacationDetails)): ?>
            <div id="vacationDetails">
                <input type="hidden" name="vacationID" value="<?php echo $vacationDetails['VacationID']; ?>">

                <div class="mb-3">
                    <label for="vacationDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="vacationDescription" name="vacationDescription" rows="3" required><?php echo htmlspecialchars($vacationDetails['Description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="vacationPrice" class="form-label">Price</label>
                    <input type="number" class="form-control" id="vacationPrice" name="vacationPrice" value="<?php echo htmlspecialchars($vacationDetails['Price']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="vacationDestination" class="form-label">Destination</label>
                    <input type="text" class="form-control" id="vacationDestination" name="vacationDestination" value="<?php echo htmlspecialchars($vacationDetails['Destination']); ?>" required>
                </div>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Update Vacation</button>
        </form>
        <div class="mt-3">
            <a href="adminpanel.php" class="btn btn-secondary">Back to Admin Panel</a>
        </div>
    </div>

    <script>
        function loadVacationDetails(vacationID) {
            window.location.href = `editvacation.php?vacationID=${vacationID}`;
        }
    </script>
</body>
</html>
