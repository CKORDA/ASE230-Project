<?php
include 'db.php'; // Include PDO connection

try {
    $email = 'newuser@example.com';

    // Check if email already exists
    $checkQuery = $pdo->prepare("SELECT COUNT(*) FROM users WHERE Email = ?");
    $checkQuery->execute([$email]);
    $exists = $checkQuery->fetchColumn();

    if ($exists) {
        echo "Email already exists. Please use a different email.";
    } else {
        // Proceed with the insert
        $query = $pdo->prepare("INSERT INTO users (Username, Email, Password, DateOfBirth, Preferences) VALUES (?, ?, ?, ?, ?)");
        $query->execute([
            'newuser',
            $email,
            password_hash('newpassword', PASSWORD_DEFAULT),
            '1995-05-10',
            json_encode(['destination' => 'Rome', 'category' => 'Relaxation'])
        ]);
        echo "User inserted successfully!";
    }
} catch (PDOException $e) {
    echo "Error inserting user: " . $e->getMessage();
}
?>
