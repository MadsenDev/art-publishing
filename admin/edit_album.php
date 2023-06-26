<?php
// Code to edit an album
include('../db.php');
include('../session.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to manage albums.');
}

// Check if the album ID is provided
if (!isset($_GET['id'])) {
    die('Album ID not provided.');
}

// Fetch album details
$stmt = $conn->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$album = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Check if the album exists
if (!$album) {
    die('Album not found.');
}

// Check if the logged-in user owns the album
if ($album['user_id'] != $_SESSION['user_id']) {
    die('You do not have permission to manage this album.');
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Update the album
    $stmt = $conn->prepare("UPDATE albums SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param('ssi', $_POST['name'], $_POST['description'], $_GET['id']);
    $stmt->execute();
    $stmt->close();

    // Redirect to manage albums page
    header('Location: manage_albums.php');
}
?>

<!-- HTML form to edit an album -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Album</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <?php include('dashboard_sidebar.php'); ?>
        </div>
        <div id="content">
            <h1>Edit Album</h1>
            <form action="" method="post">
                <p>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($album['name']); ?>">
                </p>
                <p>
                    <label for="description">Description</label>
                    <textarea name="description" id="description"><?php echo htmlspecialchars($album['description']); ?></textarea>
                </p>
                <p>
                    <button type="submit" class="btn" name="submit">Update</button>
                </p>
            </form>
        </div>
    </div>
</body>
</html>