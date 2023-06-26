<?php
include('../session.php');
include('../db.php');
include('functions.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to add an image.');
}

// Fetch albums associated with the logged-in user
$stmt = $conn->prepare("SELECT * FROM albums WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$albums = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $album_id = $_POST['album_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $target_dir = "../uploads/";
    $db_file_path = "uploads/" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or a fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Try to upload file
    if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO images (user_id, album_id, filename, url, title, description) VALUES (?, ?, ?, ?, ?, ?)");
        $filename = basename($_FILES["image"]["name"]);
        $stmt->bind_param("iissss", $user_id, $album_id, $filename, $db_file_path, $title, $description);
        
        // Execute the SQL query
        if ($stmt->execute()) {
            echo "The image has been uploaded.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    $stmt->close();

    header("Location: manage_images.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Image</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <?php include('dashboard_sidebar.php'); ?>
        </div>
        <div id="content">
            <h1>Add New Image</h1>
            <form action="add_image.php" method="post" enctype="multipart/form-data">
            <label for="album">Album:</label>
            <select name="album_id" id="album">
                <option value="">Select Album</option>
                <?php echo generateAlbumOptions($albums); ?>
            </select>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
                <label for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
                <label for="image">Select image:</label>
                <input type="file" name="image" id="image" required>
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </div>
</body>
</html>