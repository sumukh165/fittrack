<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, username, password) VALUES ('$name', '$email', '$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Account created successfully";
            header('Location: login.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="header">
        <h1>FitTrack</h1> 
    </div>
    <div class="container">
        <div class="login-box">
            <h2>Welcome to FitTrack</h2>
            <form action="register.php" method="post">
                <div class="textbox">
                    <input type="text" name="name" placeholder="Name" required>
                </div>
                <div class="textbox">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="textbox">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="textbox">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="textbox">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit" name="Register" class="btn">Sign Up</button>
                <div class="links">
                    <span>Already a User? <a href="login.php">Login</a></span>
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
