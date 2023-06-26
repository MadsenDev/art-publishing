<?php
include('../session.php');
include('../db.php');
include('functions.php'); // Include the functions file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to create an album.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $parent_album = !empty($_POST['parent_album']) ? $_POST['parent_album'] : null;
    $user_id = $_SESSION['user_id'];

    // Input validation can be added here

    // Prepare statement
    if ($stmt = $conn->prepare("INSERT INTO albums (user_id, name, description, parent_album) VALUES (?, ?, ?, ?)")) {
        // Bind parameters
        $stmt->bind_param("isss", $user_id, $name, $description, $parent_album);

        // Execute query
        if ($stmt->execute()) {
            header("Location: manage_albums.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Fetch albums for selection
$stmt = $conn->prepare("SELECT * FROM albums WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$albums = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Album</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <?php include('dashboard_sidebar.php'); ?>
        </div>
        <div id="content">
            <h1>Create Album</h1>
            <form method="post">
                <label for="name">Album Name</label>
                <input type="text" name="name" id="name" required>
                <label for="description">Description</label>
                <textarea name="description" id="description"></textarea>
                <label for="parent_album">Parent Album</label>
                <select name="parent_album" id="parent_album">
                    <option value="">None</option>
                    <?php
                    echo generateAlbumOptions($albums);
                    ?>
                </select>
                <button type="submit" class="btn">Create Album</button>
            </form>
        </div>
    </div>
</body>
</html>