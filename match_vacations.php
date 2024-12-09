<?php
include 'db.php'; // Include PDO connection

session_start();
$_POST['preferred_destination'] = 'Paris'; // Simulate form submission

try {
    $query = $pdo->prepare("SELECT * FROM vacation WHERE Destination = ?");
    $query->execute([$_POST['preferred_destination']]);
    $matches = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($matches) {
        echo "<h3>Matched Vacations:</h3>";
        echo "<pre>";
        print_r($matches);
        echo "</pre>";
    } else {
        echo "No matches found for destination: " . htmlspecialchars($_POST['preferred_destination']);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
