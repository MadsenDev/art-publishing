<?php
include('../session.php');
include('../db.php');
include('functions.php'); // Make sure this includes the generateAlbumTableRows function

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to manage albums.');
}

// Fetch albums associated with the logged-in user
$stmt = $conn->prepare("SELECT * FROM albums WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$albums = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Albums</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
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
                    <?php echo generateAlbumTableRows($albums); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>