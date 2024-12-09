<?php
include 'db.php'; // Include PDO connection

try {
    $query = $pdo->query("SELECT b.BookingID, u.Username, v.Title, b.DateBooked
                          FROM booking b
                          JOIN users u ON b.UserID = u.UserID
                          JOIN vacation v ON b.VacationID = v.VacationID");
    $bookings = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Bookings:</h3>";
    echo "<pre>";
    print_r($bookings);
    echo "</pre>";
} catch (PDOException $e) {
    echo "Error fetching bookings: " . $e->getMessage();
}
?>
