<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exercise_name = $_POST['exercise_name'];
    $exercise_type = $_POST['exercise_type'];
    $workout_date = $_POST['workout_date'];

    // Initialize variables for query
    $sql = "";
    $success_message = "";

    // Check exercise type to decide which fields to insert into the database
    if ($exercise_type == 'strength') {
        $muscle_group = $_POST['muscle_group'];
        $sets = $_POST['sets'];
        $reps = $_POST['reps'];
        $weight = $_POST['weight'];

        $sql = "INSERT INTO workouts (user_id, exercise_name, muscle_group, sets, reps, weight, workout_date) 
                VALUES ('$user_id', '$exercise_name', '$muscle_group', '$sets', '$reps', '$weight', '$workout_date')";
    } elseif ($exercise_type == 'cardio') {
        $duration = $_POST['duration'];
        $distance = $_POST['distance'];

        $sql = "INSERT INTO workouts (user_id, exercise_name, duration, distance, workout_date) 
                VALUES ('$user_id', '$exercise_name', '$duration', '$distance', '$workout_date')";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Workout logged successfully!";
        header('Location: workouts.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts - FitTrack</title>
    <link rel="stylesheet" href="workouts.css">
    <script>
        // Function to set default current date for workout_date field
        function setDefaultDate() {
            var now = new Date();

            // Format date as YYYY-MM-DD (required by <input type="date">)
            var currentDate = now.toISOString().split('T')[0];

            // Set default value in the form field
            document.getElementById('workout_date').value = currentDate;
        }

        // Function to show fields based on exercise type
        function showFields() {
            var exerciseType = document.getElementById("exercise_type").value;
            var strengthFields = document.getElementById("strength_fields");
            var cardioFields = document.getElementById("cardio_fields");

            if (exerciseType == 'strength') {
                strengthFields.style.display = "block";
                cardioFields.style.display = "none";
            } else if (exerciseType == 'cardio') {
                strengthFields.style.display = "none";
                cardioFields.style.display = "block";
            }
        }
    </script>
</head>
<body onload="setDefaultDate()">
    <header class="header">
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
    </header>
    <div class="container">
        <div class="login-box">
            <h2>Log a Workout</h2>
            <!-- Check if success message exists and display it -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success-message">
                    <?php echo $_SESSION['success_message']; ?>
                </div>
                <?php unset($_SESSION['success_message']); // Clear the session variable ?>
            <?php endif; ?>
            
            <form method="post" action="workouts.php" onsubmit="return validateForm()">
                <div class="textbox">
                    <input type="text" name="exercise_name" placeholder="Exercise Name" required>
                </div>
                <div class="textbox">
                    <select name="exercise_type" id="exercise_type" onchange="showFields()" required>
                        <option value="">Select Exercise Type</option>
                        <option value="strength">Strength</option>
                        <option value="cardio">Cardio</option>
                    </select>
                </div>
                
                <!-- Strength Fields -->
                <div id="strength_fields" style="display: none;">
                    <div class="textbox">
                        <input type="text" name="muscle_group" placeholder="Muscle Group">
                    </div>
                    <div class="textbox">
                        <input type="number" name="sets" placeholder="Sets">
                    </div>
                    <div class="textbox">
                        <input type="number" name="reps" placeholder="Reps">
                    </div>
                    <div class="textbox">
                        <input type="number" name="weight" placeholder="Weight (kg)">
                    </div>
                </div>

                <!-- Cardio Fields -->
                <div id="cardio_fields" style="display: none;">
                    <div class="textbox">
                        <input type="time" name="duration" id="duration" placeholder="Duration (mm:ss)">
                    </div>
                    <div class="textbox">
                        <input type="decimal" name="distance" placeholder="Distance (km)">
                    </div>
                </div>
                <div class="textbox">
                    <input type="date" name="workout_date" id="workout_date" required>
                </div>
                <button type="submit" class="btn">Log Workout</button>
            </form>
        </div>
    </div>
    <div class="footer">
    <p><a href="contactus.php">Contact Us</a> | <a href="aboutus.php">About Us</a></p>
    </div>
</body>
</html>
