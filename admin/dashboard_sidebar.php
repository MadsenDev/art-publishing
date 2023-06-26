<?php
session_start();
// Check if user is logged in
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

  } else {
    header("Location: ../auth/login.php");
  }
?>
<!-- Sidebar content goes here -->
<nav>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="manage_albums.php">Albums</a></li>
        <li><a href="manage_images.php">Images</a></li>
        <li><a href="#">Settings</a></li>
    </ul>
</nav>