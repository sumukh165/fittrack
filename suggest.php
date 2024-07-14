<?php
session_start();
require 'db.php'; // Ensure this file contains the correct database connection code

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

$goal = '';
$success_message = '';

$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session after login
$query = "SELECT height, weight, age, gender FROM personal_details WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Calculate BMR
$height = $user['height'];
$weight = $user['weight'];
$age = $user['age'];
$gender = $user['gender'];

if ($gender == 'Male') {
    $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
} else {
    $bmr = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $goal = $_POST['goal'];

    // Update the user's goal in the database
    $sql = "UPDATE users SET goal = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $goal, $user_id);
    
    if ($stmt->execute()) {
        $success_message = "Goal updated successfully.";
    } else {
        $success_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch user details and goal from the database
$sql = "SELECT goal FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$goal = $user_data['goal'] ?? 'maintenance';

$stmt->close();

// Fetch plans based on the user's goal
function getPlan($goal) {
    // Placeholder function to generate a plan based on the goal
    // You should replace this with actual logic to fetch data from the database
    $plans = [
        'weight_loss' => [
            'Monday' => [
                'diet' => [
                    ['food' => 'Oats', 'amount' => '50g', 'calories' => 150],
                    ['food' => 'Chicken Salad', 'amount' => '200g', 'calories' => 350],
                    ['food' => 'Green Smoothie', 'amount' => '1 glass', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Running', 'duration' => '30 minutes'],
                    ['exercise' => 'Squats', 'sets' => 3, 'reps' => 15],
                    ['exercise' => 'Jumping Jacks', 'sets' => 3, 'reps' => 20],
                ]
            ],
            'Tuesday' => [
                'diet' => [
                    ['food' => 'Grilled Salmon', 'amount' => '150g', 'calories' => 280],
                    ['food' => 'Vegetable Stir Fry', 'amount' => '200g', 'calories' => 150],
                ],
                'workout' => [
                    ['exercise' => 'Burpees', 'sets' => 3, 'reps' => 10],
                    ['exercise' => 'Plank', 'duration' => '1 minute', 'reps' => 3],
                ]
            ],
            'Wednesday' => [
                'diet' => [
                    ['food' => 'Oats', 'amount' => '50g', 'calories' => 150],
                    ['food' => 'Chicken Salad', 'amount' => '200g', 'calories' => 350],
                    ['food' => 'Green Smoothie', 'amount' => '1 glass', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Running', 'duration' => '30 minutes'],
                    ['exercise' => 'Squats', 'sets' => 3, 'reps' => 15],
                    ['exercise' => 'Jumping Jacks', 'sets' => 3, 'reps' => 20],
                ]
            ],
            'Thursday' => [
                'diet' => [
                    ['food' => 'Grilled Salmon', 'amount' => '150g', 'calories' => 280],
                    ['food' => 'Vegetable Stir Fry', 'amount' => '200g', 'calories' => 150],
                ],
                'workout' => [
                    ['exercise' => 'Burpees', 'sets' => 3, 'reps' => 10],
                    ['exercise' => 'Plank', 'duration' => '1 minute', 'reps' => 3],
                ]
            ],
            'Friday' => [
                'diet' => [
                    ['food' => 'Oats', 'amount' => '50g', 'calories' => 150],
                    ['food' => 'Chicken Salad', 'amount' => '200g', 'calories' => 350],
                    ['food' => 'Green Smoothie', 'amount' => '1 glass', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Running', 'duration' => '30 minutes'],
                    ['exercise' => 'Squats', 'sets' => 3, 'reps' => 15],
                    ['exercise' => 'Jumping Jacks', 'sets' => 3, 'reps' => 20],
                ]
            ],
            'Saturday' => [
                'diet' => [
                    ['food' => 'Grilled Salmon', 'amount' => '150g', 'calories' => 280],
                    ['food' => 'Vegetable Stir Fry', 'amount' => '200g', 'calories' => 150],
                ],
                'workout' => [
                    ['exercise' => 'Burpees', 'sets' => 3, 'reps' => 10],
                    ['exercise' => 'Plank', 'duration' => '1 minute', 'reps' => 3],
                ]
            ],
            'Sunday' => [
                'diet' => [
                    ['food' => 'Oats', 'amount' => '50g', 'calories' => 150],
                    ['food' => 'Chicken Salad', 'amount' => '200g', 'calories' => 350],
                    ['food' => 'Green Smoothie', 'amount' => '1 glass', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Running', 'duration' => '30 minutes'],
                    ['exercise' => 'Squats', 'sets' => 3, 'reps' => 15],
                    ['exercise' => 'Jumping Jacks', 'sets' => 3, 'reps' => 20],
                ]
            ],
        ],
        'muscle_gain' => [
            'Monday' => [
                'diet' => [
                    ['food' => 'Protein Shake', 'amount' => '1 serving', 'calories' => 150],
                    ['food' => 'Grilled Chicken', 'amount' => '200g', 'calories' => 300],
                    ['food' => 'Quinoa', 'amount' => '100g', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Bench Press', 'sets' => 4, 'reps' => 10],
                    ['exercise' => 'Deadlift', 'sets' => 4, 'reps' => 8],
                ]
            ],
            'Tuesday' => [
                'diet' => [
                    ['food' => 'Beef Steak', 'amount' => '200g', 'calories' => 450],
                    ['food' => 'Greek Yogurt', 'amount' => '1 cup', 'calories' => 100],
                ],
                'workout' => [
                    ['exercise' => 'Bicep Curls', 'sets' => 3, 'reps' => 12],
                    ['exercise' => 'Tricep Dips', 'sets' => 3, 'reps' => 12],
                ]
            ],
            'Wednesday' => [
                'diet' => [
                    ['food' => 'Protein Shake', 'amount' => '1 serving', 'calories' => 150],
                    ['food' => 'Grilled Chicken', 'amount' => '200g', 'calories' => 300],
                    ['food' => 'Quinoa', 'amount' => '100g', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Bench Press', 'sets' => 4, 'reps' => 10],
                    ['exercise' => 'Deadlift', 'sets' => 4, 'reps' => 8],
                ]
            ],
            'Thursday' => [
                'diet' => [
                    ['food' => 'Beef Steak', 'amount' => '200g', 'calories' => 450],
                    ['food' => 'Greek Yogurt', 'amount' => '1 cup', 'calories' => 100],
                ],
                'workout' => [
                    ['exercise' => 'Bicep Curls', 'sets' => 3, 'reps' => 12],
                    ['exercise' => 'Tricep Dips', 'sets' => 3, 'reps' => 12],
                ]
            ],
            'Friday' => [
                'diet' => [
                    ['food' => 'Protein Shake', 'amount' => '1 serving', 'calories' => 150],
                    ['food' => 'Grilled Chicken', 'amount' => '200g', 'calories' => 300],
                    ['food' => 'Quinoa', 'amount' => '100g', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Bench Press', 'sets' => 4, 'reps' => 10],
                    ['exercise' => 'Deadlift', 'sets' => 4, 'reps' => 8],
                ]
            ],
            'Saturday' => [
                'diet' => [
                    ['food' => 'Beef Steak', 'amount' => '200g', 'calories' => 450],
                    ['food' => 'Greek Yogurt', 'amount' => '1 cup', 'calories' => 100],
                ],
                'workout' => [
                    ['exercise' => 'Bicep Curls', 'sets' => 3, 'reps' => 12],
                    ['exercise' => 'Tricep Dips', 'sets' => 3, 'reps' => 12],
                ]
            ],
            'Sunday' => [
                'diet' => [
                    ['food' => 'Protein Shake', 'amount' => '1 serving', 'calories' => 150],
                    ['food' => 'Grilled Chicken', 'amount' => '200g', 'calories' => 300],
                    ['food' => 'Quinoa', 'amount' => '100g', 'calories' => 120],
                ],
                'workout' => [
                    ['exercise' => 'Bench Press', 'sets' => 4, 'reps' => 10],
                    ['exercise' => 'Deadlift', 'sets' => 4, 'reps' => 8],
                ]
            ],
        ],
        'maintenance' => [
            'Monday' => [
                'diet' => [
                    ['food' => 'Mixed Nuts', 'amount' => '50g', 'calories' => 200],
                    ['food' => 'Fish Curry', 'amount' => '200g', 'calories' => 400],
                ],
                'workout' => [
                    ['exercise' => 'Yoga', 'duration' => '60 minutes'],
                    ['exercise' => 'Push-ups', 'sets' => 3, 'reps' => 15],
                ]
            ],
            'Tuesday' => [
                'diet' => [
                    ['food' => 'Brown Rice', 'amount' => '100g', 'calories' => 110],
                    ['food' => 'Chicken Sandwich', 'amount' => '1 serving', 'calories' => 300],
                ],
                'workout' => [
                    ['exercise' => 'Cycling', 'duration' => '30 minutes'],
                    ['exercise' => 'Pull-ups', 'sets' => 3, 'reps' => 10],
                ]
            ],
            'Wednesday' => [
                'diet' => [
                    ['food' => 'Mixed Nuts', 'amount' => '50g', 'calories' => 200],
                    ['food' => 'Fish Curry', 'amount' => '200g', 'calories' => 400],
                ],
                'workout' => [
                    ['exercise' => 'Yoga', 'duration' => '60 minutes'],
                    ['exercise' => 'Push-ups', 'sets' => 3, 'reps' => 15],
                ]
            ],
            'Thursday' => [
                'diet' => [
                    ['food' => 'Brown Rice', 'amount' => '100g', 'calories' => 110],
                    ['food' => 'Chicken Sandwich', 'amount' => '1 serving', 'calories' => 300],
                ],
                'workout' => [
                    ['exercise' => 'Cycling', 'duration' => '30 minutes'],
                    ['exercise' => 'Pull-ups', 'sets' => 3, 'reps' => 10],
                ]
            ],
            'Friday' => [
                'diet' => [
                    ['food' => 'Mixed Nuts', 'amount' => '50g', 'calories' => 200],
                    ['food' => 'Fish Curry', 'amount' => '200g', 'calories' => 400],
                ],
                'workout' => [
                    ['exercise' => 'Yoga', 'duration' => '60 minutes'],
                    ['exercise' => 'Push-ups', 'sets' => 3, 'reps' => 15],
                ]
            ],
            'Saturday' => [
                'diet' => [
                    ['food' => 'Brown Rice', 'amount' => '100g', 'calories' => 110],
                    ['food' => 'Chicken Sandwich', 'amount' => '1 serving', 'calories' => 300],
                ],
                'workout' => [
                    ['exercise' => 'Cycling', 'duration' => '30 minutes'],
                    ['exercise' => 'Pull-ups', 'sets' => 3, 'reps' => 10],
                ]
            ],
            'Sunday' => [
                'diet' => [
                    ['food' => 'Mixed Nuts', 'amount' => '50g', 'calories' => 200],
                    ['food' => 'Fish Curry', 'amount' => '200g', 'calories' => 400],
                ],
                'workout' => [
                    ['exercise' => 'Yoga', 'duration' => '60 minutes'],
                    ['exercise' => 'Push-ups', 'sets' => 3, 'reps' => 15],
                ]
            ],
        ]
    ];

    return $plans[$goal] ?? $plans['maintenance'];
}

$plan = getPlan($goal);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Plan - FitTrack</title>
    <link rel="stylesheet" href="suggest.css">
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

            <h2>User Details</h2>
            <p>Height: <?php echo $height; ?> cm</p>
            <p>Weight: <?php echo $weight; ?> kg</p>
            <p>Age: <?php echo $age; ?> years</p>
            <p>Gender: <?php echo $gender; ?></p>
            <p>BMR: <?php echo round($bmr); ?> kcal/day</p>
            <h2>Set Your Fitness Goal</h2>
            <?php if ($success_message): ?>
                <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
            <form action="suggest.php" method="post">
                <div class="textbox">
                    <label for="goal">Goal:</label>
                    <select id="goal" name="goal" required>
                        <option value="weight_loss" <?php if ($goal == 'weight_loss') echo 'selected'; ?>>Weight Loss</option>
                        <option value="muscle_gain" <?php if ($goal == 'muscle_gain') echo 'selected'; ?>>Muscle Gain</option>
                        <option value="maintenance" <?php if ($goal == 'maintenance') echo 'selected'; ?>>Maintenance</option>
                    </select>
                </div>
                <button type="submit" class="btn">Update Goal</button>
            </form>

            <h2>Your Fitness Plan</h2>

            <?php foreach ($plan as $day => $details): ?>
                <h3><?php echo $day; ?></h3>
                <h4>Diet Plan</h4>
                <ul class="diet-plan">
                    <?php foreach ($details['diet'] as $diet_item): ?>
                        <li><?php echo htmlspecialchars($diet_item['food']) . ' - ' . htmlspecialchars($diet_item['amount']) . ' (' . htmlspecialchars($diet_item['calories']) . ' calories)'; ?></li>
                    <?php endforeach; ?>
                </ul>

                <h4>Workout Plan</h4>
                <ul class="workout-plan">
                    <?php foreach ($details['workout'] as $workout_item): ?>
                        <li>
                            <?php 
                            echo htmlspecialchars($workout_item['exercise']); 
                            if (isset($workout_item['duration'])) {
                                echo ' - ' . htmlspecialchars($workout_item['duration']);
                            } else {
                                echo ' - ' . htmlspecialchars($workout_item['sets']) . ' sets of ' . htmlspecialchars($workout_item['reps']) . ' reps';
                            }
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="footer">
        <p><a href="contactus.php">Contact Us</a> | <a href="aboutus.php">About Us</a></p>
    </div>
</body>
</html>
