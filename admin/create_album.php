<?php
include('../session.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $parent_album = isset($_POST['parent_album']) ? $_POST['parent_album'] : null;

    $stmt = $conn->prepare("INSERT INTO albums (user_id, name, description, parent_album) VALUES (:user_id, :name, :description, :parent_album)");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':parent_album', $parent_album);
    $stmt->execute();
    header("Location: manage_albums.php");
}
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
                    $stmt = $conn->prepare("SELECT * FROM albums WHERE user_id = :user_id");
                    $stmt->bindParam(':user_id', $_SESSION['user_id']);
                    $stmt->execute();
                    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($albums as $album) {
                        echo "<option value='{$album['id']}'>{$album['name']}</option>";
                    }
                    ?>
                </select>
                <button type="submit">Create Album</button>
            </form>
        </div>
    </div>
</body>
</html>