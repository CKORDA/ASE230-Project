<?php
// Define the path to the vacation database
$filePath = '../vacationdatabase.txt';

// Check if the vacation index is provided in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vacation'])) {
    $vacationIndex = (int)$_POST['vacation'];

    // Ensure the file exists and read its contents
    $vacations = file_exists($filePath) ? file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

    // Validate the index
    if (isset($vacations[$vacationIndex])) {
        // Remove the selected vacation
        unset($vacations[$vacationIndex]);

        // Write the updated list back to the file
        file_put_contents($filePath, implode(PHP_EOL, $vacations) . PHP_EOL, LOCK_EX);

        // Redirect with a success message
        header('Location: ../vacations.php?status=deleted');
        exit();
    } else {
        // Redirect with an error if the index is invalid
        header('Location: ../vacations.php?status=invalid');
        exit();
    }
} else {
    // Redirect with an error if no valid data is provided
    header('Location: ../vacations.php?status=error');
    exit();
}
?>
