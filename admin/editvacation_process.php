<?php
// Read the vacation data
$vacations = file('../vacationdatabase.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Prepare to update the vacation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedVacation = $_POST['vacation'];
    $vacationDescription = $_POST['vacationDescription'];
    $vacationPrice = $_POST['vacationPrice'];
    $vacationLocation = $_POST['vacationLocation'];
    $vacationImage = $_POST['vacationImage'];

    // Create the new vacation string
    $updatedVacation = $selectedVacation . '@' . $vacationDescription . '@' . $vacationPrice . '@' . $vacationLocation . '@' . $vacationImage;

    // Update the vacation data
    foreach ($vacations as $index => $vacation) {
        if (strpos($vacation, $selectedVacation) === 0) {
            $vacations[$index] = $updatedVacation; // Replace old vacation data
            break;
        }
    }

    // Write the updated data back to the file
    file_put_contents('../vacationdatabase.txt', implode("\n", $vacations) . "\n");

    // Redirect to vacations.php after successful update
    header('Location: ../vacations.php');
    exit(); // Always call exit after header redirect to prevent further script execution
}
?>
