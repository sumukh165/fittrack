<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle delete actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_nutrition'])) {
        $nutrition_id = $_POST['nutrition_id'];
        $sql_delete_nutrition = "DELETE FROM nutrition WHERE id = ? AND user_id = ?";
        $stmt_delete_nutrition = $conn->prepare($sql_delete_nutrition);
        $stmt_delete_nutrition->bind_param("ii", $nutrition_id, $user_id);
        $stmt_delete_nutrition->execute();
        $stmt_delete_nutrition->close();
    } elseif (isset($_POST['delete_workout'])) {
        $workout_id = $_POST['workout_id'];
        $sql_delete_workout = "DELETE FROM workouts WHERE id = ? AND user_id = ?";
        $stmt_delete_workout = $conn->prepare($sql_delete_workout);
        $stmt_delete_workout->bind_param("ii", $workout_id, $user_id);
        $stmt_delete_workout->execute();
        $stmt_delete_workout->close();
    }
}

// Fetch nutrition data
$sql_nutrition = "SELECT * FROM nutrition WHERE user_id = ? ORDER BY log_date DESC";
$stmt_nutrition = $conn->prepare($sql_nutrition);
$stmt_nutrition->bind_param("i", $user_id);
$stmt_nutrition->execute();
$result_nutrition = $stmt_nutrition->get_result();

// Fetch workouts data
$sql_workouts = "SELECT * FROM workouts WHERE user_id = ? ORDER BY workout_date DESC";
$stmt_workouts = $conn->prepare($sql_workouts);
$stmt_workouts->bind_param("i", $user_id);
$stmt_workouts->execute();
$result_workouts = $stmt_workouts->get_result();

// Group data by dates
$nutrition_data = [];
$workouts_data = [];

while ($row = $result_nutrition->fetch_assoc()) {
    $row['log_date_formatted'] = date('d-m-Y', strtotime($row['log_date']));
    $nutrition_data[$row['log_date']][] = $row;
}

while ($row = $result_workouts->fetch_assoc()) {
    $row['workout_date_formatted'] = date('d-m-Y', strtotime($row['workout_date']));
    $workouts_data[$row['workout_date']][] = $row;
}

$stmt_nutrition->close();
$stmt_workouts->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitTrack</title>
    <style>
        <?php include 'dashboard.css'; ?>
    </style>
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
        <div class="content">
            <div class="login-box">
                <h2>Nutrition Logged</h2>
                <?php if (!empty($nutrition_data)): ?>
                    <?php foreach ($nutrition_data as $date => $entries): ?>
                        <h3><?php echo htmlspecialchars($entries[0]['log_date_formatted']); ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Food Name</th>
                                    <th>Calories</th>
                                    <th>Protein</th>
                                    <th>Carbs</th>
                                    <th>Fats</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($entries as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['food_name']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['calories_consumed']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['protein']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['carbs']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['fats']); ?></td>
                                        <td>
                                            <form method="post" action="dashboard.php" style="display:inline;">
                                                <input type="hidden" name="nutrition_id" value="<?php echo $entry['id']; ?>">
                                                <button type="submit" name="delete_nutrition" class="delete-btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No nutrition data logged yet.</p>
                <?php endif; ?>
                
                <h2>Workouts</h2>
                <?php if (!empty($workouts_data)): ?>
                    <?php foreach ($workouts_data as $date => $entries): ?>
                        <h3><?php echo htmlspecialchars($entries[0]['workout_date_formatted']); ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Exercise Name</th>
                                    <th>Muscle Group</th>
                                    <th>Sets</th>
                                    <th>Reps</th>
                                    <th>Weight</th>
                                    <th>Distance</th>
                                    <th>Duration</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($entries as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['exercise_name']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['muscle_group']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['sets']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['reps']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['weight']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['distance']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['duration']); ?></td>
                                        <td>
                                            <form method="post" action="dashboard.php" style="display:inline;">
                                                <input type="hidden" name="workout_id" value="<?php echo $entry['id']; ?>">
                                                <button type="submit" name="delete_workout" class="delete-btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No workouts logged yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer">
        <p><a href="contactus.php">Contact Us</a> | <a href="aboutus.php">About Us</a></p>
    </div>
</body>
</html>
