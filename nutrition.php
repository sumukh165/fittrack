<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_name = $_POST['food_name'];
    $calories_consumed = $_POST['calories_consumed'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $fats = $_POST['fats'];
    $log_date = $_POST['log_date'];

    if ($food_name === 'Other') {
        $food_name = $_POST['other_food_name'];

        // Insert new food into foods table
        $sql = "INSERT INTO foods (food_name, calories, protein, carbs, fats) 
                VALUES ('$food_name', '$calories_consumed', '$protein', '$carbs', '$fats')";
        
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Log nutrition
    $sql = "INSERT INTO nutrition (user_id, food_name, calories_consumed, protein, carbs, fats, log_date) 
            VALUES ('$user_id', '$food_name', '$calories_consumed', '$protein', '$carbs', '$fats', '$log_date')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Food logged successfully!";
        header('Location: nutrition.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch foods data
$foods = [];
$sql = "SELECT * FROM foods";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $foods[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition - FitTrack</title>
    <link rel="stylesheet" href="nutrition.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const foodData = <?php echo json_encode($foods); ?>;
            const foodSelect = document.getElementById('food_name');
            const otherFields = document.getElementById('other-fields');

            foodSelect.addEventListener('change', function () {
                if (this.value === 'Other') {
                    otherFields.style.display = 'block';
                    document.getElementById('calories_consumed').readOnly = false;
                    document.getElementById('protein').readOnly = false;
                    document.getElementById('carbs').readOnly = false;
                    document.getElementById('fats').readOnly = false;
                } else {
                    const selectedFood = foodData.find(food => food.food_name === this.value);
                    if (selectedFood) {
                        document.getElementById('calories_consumed').value = selectedFood.calories;
                        document.getElementById('protein').value = selectedFood.protein;
                        document.getElementById('carbs').value = selectedFood.carbs;
                        document.getElementById('fats').value = selectedFood.fats;
                        document.getElementById('calories_consumed').readOnly = true;
                        document.getElementById('protein').readOnly = true;
                        document.getElementById('carbs').readOnly = true;
                        document.getElementById('fats').readOnly = true;
                    } else {
                        document.getElementById('calories_consumed').value = '';
                        document.getElementById('protein').value = '';
                        document.getElementById('carbs').value = '';
                        document.getElementById('fats').value = '';
                    }
                    otherFields.style.display = 'none';
                }
            });
        });
    </script>
</head>
<body>
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
            <h2>Log Nutrition</h2>
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success-message">
                    <?php echo $_SESSION['success_message']; ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            <form method="post" action="nutrition.php">
                <div class="textbox">
                    <select id="food_name" name="food_name" required>
                        <option value="">Select Food</option>
                        <?php foreach ($foods as $food): ?>
                            <option value="<?php echo $food['food_name']; ?>"><?php echo $food['food_name']; ?></option>
                        <?php endforeach; ?>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div id="other-fields" style="display:none;">
                    <div class="textbox">
                        <input type="text" id="other_food_name" name="other_food_name" placeholder="Food Name">
                    </div>
                </div>
                <div class="textbox">
                    <input type="number" id="calories_consumed" name="calories_consumed" placeholder="Calories" required readonly>
                </div>
                <div class="textbox">
                    <input type="number" id="protein" name="protein" placeholder="Protein (g)" required readonly>
                </div>
                <div class="textbox">
                    <input type="number" id="carbs" name="carbs" placeholder="Carbs (g)" required readonly>
                </div>
                <div class="textbox">
                    <input type="number" id="fats" name="fats" placeholder="Fats (g)" required readonly>
                </div>
                <div class="textbox">
                    <input type="date" name="log_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit" class="btn">Log Food</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p><a href="contactus.php">Contact Us</a> | <a href="aboutus.php">About Us</a></p>
    </div>
</body>
</html>
