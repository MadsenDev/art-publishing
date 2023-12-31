<?php
include('../session.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    header("Location: login.php?success=Registration successful, please log in");
} else {
    header("Location: register.php?error=Error registering, please try again");
}
?>