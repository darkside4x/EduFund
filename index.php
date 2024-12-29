<?php
// Database connection
require 'db.php';

// Fetch hospital data
$stmt = $conn->prepare("SELECT * FROM hospital");
$stmt->execute();
$hospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Data</title>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Name</th>
                <th>State</th>
                <th>City</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hospitals as $hospital): ?>
            <tr>
                <td><?= htmlspecialchars($hospital['name']) ?></td>
                <td><?= htmlspecialchars($hospital['state']) ?></td>
                <td><?= htmlspecialchars($hospital['city']) ?></td>
                <td><a href="<?= htmlspecialchars($hospital['details_page']) ?>">View Details</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
