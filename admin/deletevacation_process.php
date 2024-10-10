<?php
// Check if the vacation name is provided
if (isset($_POST['vacation'])) {
    $requestedVacation = $_POST['vacation'];
    
    // Read the vacation data from the vacationdatabase.txt file
    $vacations = file('../vacationdatabase.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $updatedVacations = [];

    // Filter out the vacation to be deleted
    foreach ($vacations as $vacation) {
        $vacationDetails = explode('@', $vacation);
        if (trim($vacationDetails[0]) !== $requestedVacation) {
            $updatedVacations[] = $vacation; // Keep vacations that do not match
        }
    }

    // Write the updated list back to the file
    file_put_contents('../vacationdatabase.txt', implode("\n", $updatedVacations) . "\n", LOCK_EX);

    // Redirect to vacations.php after deletion
    header('Location: ../vacations.php?status=deleted');
    exit();
} else {
    // If no vacation name is provided, redirect with an error
    header('Location: ../vacations.php?status=error');
    exit();
}
?>
