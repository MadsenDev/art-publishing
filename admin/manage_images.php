<?php
include('../session.php');
include('../db.php');
include('functions.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to manage images.');
}

// Fetch albums associated with the logged-in user
$stmt = $conn->prepare("SELECT * FROM albums WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$albums = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$selected_album = isset($_GET['album_id']) ? $_GET['album_id'] : null;

// Fetch images
$query = "SELECT * FROM images WHERE user_id = ?";
$params = [$_SESSION['user_id']];
if ($selected_album) {
    $query .= " AND album_id = ?";
    $params[] = $selected_album;
}
$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('i', count($params)), ...$params);
$stmt->execute();
$images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Images</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <?php include('dashboard_sidebar.php'); ?>
        </div>
        <div id="content">
            <div id="album-view">
    <h3>Albums</h3>
    <ul class="album-list">
        <li class="album-list-item"><a href="manage_images.php">All Images</a></li>
        <?php echo generateAlbumListItems($albums); ?>
    </ul>
</div>
            <div id="image-view">
                <h1>Manage Images</h1>
                <p><a href="add_image.php">Add New Image</a></p>
                <div class="image-grid">
                    <?php foreach ($images as $image): ?>
                        <div class="image-thumbnail">
                            <a href="edit_image.php?id=<?php echo $image['id']; ?>" target="_blank">
                                <img src="../<?php echo $image['url']; ?>" alt="<?php echo htmlspecialchars($image['description']); ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        #album-view {
            float: left;
            width: 20%;
        }

        #image-view {
            float: left;
            width: 60%;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .image-thumbnail img {
            width: 100%;
            height: auto;
        }
    </style>
</body>
</html>