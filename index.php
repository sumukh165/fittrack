<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header('Location: dashboard.php');
            echo "You're now logged in";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this username/email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="header">
        <h1>FitTrack</h1>
    </div>
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="index.php" method="post">
                <div class="textbox">
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>
                <div class="textbox">
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" name="login" class="btn">Log in</button>
                <div class="links">
                    <span>New User? <a href="register.php">Sign Up</a></span>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">
        <table>
            <tr>
                <p><a href="contactus.php">Contact Us</a> | <a href="aboutus.php">About Us</a></p>
            </tr>
        </table>
    </div>
</body>
</html>
