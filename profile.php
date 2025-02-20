<?php
session_start();
require 'db.php'; // Ensure this file contains the correct database connection code

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "
    SELECT 
        u.name, 
        u.email,
        pd.age,
        pd.gender,
        pd.height,
        pd.weight
    FROM users u
    LEFT JOIN personal_details pd ON u.id = pd.user_id
    WHERE u.id = ?
";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Set default values if user data is null
$name = $user_data['name'] ?? '';
$email = $user_data['email'] ?? '';
$age = $user_data['age'] ?? '';
$gender = $user_data['gender'] ?? '';
$height = $user_data['height'] ?? '';
$weight = $user_data['weight'] ?? '';

$stmt->close();

$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Check if personal details already exist for the user
    $check_sql = "SELECT * FROM personal_details WHERE user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Update existing personal details
        $sql = "UPDATE personal_details SET height = ?, weight = ?, age = ?, gender = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iidss", $height, $weight, $age, $gender, $user_id);
    } else {
        // Insert new personal details
        $sql = "INSERT INTO personal_details (user_id, height, weight, age, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iidss", $user_id, $height, $weight, $age, $gender);
    }

    if ($stmt->execute()) {
        $success_message = "Details saved successfully.";
    } else {
        $success_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - FitTrack</title>
    <link rel="stylesheet" href="styles/profile.css">
</head>
<body>
    <div class="header">
        <h1>FitTrack</h1> 
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="workouts.php">Workouts</a></li>
                <li><a href="nutrition.php">Nutrition</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="suggest.php">Suggestion</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <div class="login-box">
            <h2>Profile</h2>
            <?php if ($success_message): ?>
                <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
            <form action="profile.php" method="post">
                <div class="textbox">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" disabled>
                </div>
                <div class="textbox">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
                </div>
                <div class="textbox">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required>
                </div>
                <div class="textbox">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                        <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
                        <option value="other" <?php if ($gender == 'other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="textbox">
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($height); ?>" required>
                </div>
                <div class="textbox">
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($weight); ?>" required>
                </div>
                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>
    </div>
    <div class="footer">
    <p><a href="contactus.php">Contact Us</a> | <a href="aboutus.php">About Us</a></p>
    </div>
</body>
</html>
