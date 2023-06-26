<?php
// Code to delete an album
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

// Delete the album
$stmt = $conn->prepare("DELETE FROM albums WHERE id = ?");
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$stmt->close();

// Delete all photos associated with the album
$stmt = $conn->prepare("DELETE FROM images WHERE album_id = ?");
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$stmt->close();

// Redirect to manage albums page
header('Location: manage_albums.php');
?>