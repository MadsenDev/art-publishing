<!DOCTYPE html>
<html lang="en">
<?php include('../head.php'); ?>
<body>
    <?php include('../session.php'); ?>
    <h1>Register</h1>
    <form action="register_process.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Register">
    </form>
    <p><a href="login.php">Already have an account? Login</a></p>
</body>
</html>