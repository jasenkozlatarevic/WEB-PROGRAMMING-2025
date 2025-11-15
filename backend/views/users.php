<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users list</title>
</head>
<body>
    <h1>Users</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['username']); ?>
                (<?php echo htmlspecialchars($user['email']); ?>)
                - role: <?php echo htmlspecialchars($user['role']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
