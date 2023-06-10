<!DOCTYPE html>
<html lang="en">
<?php include('../head.php'); ?>
<body>
    <?php include('../session.php'); ?>
    <h1>Login</h1>
    <form action="login_process.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <p><a href="register.php">Don't have an account? Register</a></p>
</body>
</html>