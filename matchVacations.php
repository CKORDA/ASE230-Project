<?php
// Load user data
$user_data_file = 'users.json';
$users = json_decode(file_get_contents($user_data_file), true);

// Load vacation data
$vacation_data_file = 'vacationsdatabase.txt';
$vacations = json_decode(file_get_contents($vacation_data_file), true);

// Assume current user email (in a real app, you’d retrieve this from the session or auth system)
$current_user_email = "john@example.com";

if (isset($users[$current_user_email])) {
    $user_profile = $users[$current_user_email];
    $user_preference = $user_profile['preference'];
    $user_budget = $user_profile['budget'];

    // Find vacations that match the user's preferences and budget
    $matched_vacations = [];
    foreach ($vacations as $vacation) {
        if ($vacation['type'] == $user_preference && $vacation['price'] <= $user_budget) {
            $matched_vacations[] = $vacation;
        }
    }
} else {
    echo "User not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matched Vacations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Recommended Vacations for <?php echo $user_profile['name']; ?></h2>
        <div class="row">
            <?php if (count($matched_vacations) > 0): ?>
                <?php foreach ($matched_vacations as $vacation): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $vacation['name']; ?></h5>
                                <p class="card-text"><?php echo $vacation['description']; ?></p>
                                <p class="card-text"><strong>Price:</strong> $<?php echo $vacation['price']; ?></p>
                                <a href="#" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No vacations match your preferences and budget.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
