<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Albums</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <?php include('session.php'); ?>
    <div id="container">
        <div id="sidebar">
            <?php include('dashboard_sidebar.php'); ?>
        </div>
        <div id="content">
            <h1>Manage Albums</h1>
            <p><a href="create_album.php">Create New Album</a></p>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
                    $user_id_query->bind_param('s', $_SESSION['username']);
                    $user_id_query->execute();
                    $user_id_query->bind_result($user_id);
                    $user_id_query->fetch();
                    $user_id_query->close();
                    
                    $stmt->bind_param('isi', $user_id, $name, $description);                    
                    foreach ($albums as $album) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($album['name']); ?></td>
                        <td><?php echo htmlspecialchars($album['description']); ?></td>
                        <td>
                            <a href="edit_album.php?id=<?php echo $album['id']; ?>">Edit</a>
                            <a href="delete_album.php?id=<?php echo $album['id']; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>