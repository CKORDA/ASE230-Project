<?php
include 'db.php'; // Include our PDO connection

try {
    $query = $pdo->query("SELECT * FROM vacation");
    $vacations = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($vacations);
    echo "</pre>";
} catch (PDOException $e) {
    echo "Error fetching vacations: " . $e->getMessage();
}
?>
