<?php
// add_weights_workout.php

// Database connection settings
$servername = "database-2.cn4ksqii2unx.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "WorkoutLogDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$sets = $_POST['sets'];
$reps = $_POST['reps'];
$weight = $_POST['weight'];
$user_id = 'some_user_id'; // Replace this with actual user ID retrieved from session or other mechanism

// Insert into Workouts table first
$sql_workout = "INSERT INTO Workouts (user_id, workout_type, date) VALUES ('$user_id', 'Weights', NOW())";
if ($conn->query($sql_workout) === TRUE) {
    $workout_id = $conn->insert_id;

    // Insert into WeightsWorkouts table
    $sql_weights = "INSERT INTO WeightsWorkouts (workout_id, sets, reps_per_set, weight_kg) VALUES ('$workout_id', '$sets', '$reps', '$weight')";
    if ($conn->query($sql_weights) === TRUE) {
        echo "New weights workout added successfully";
    } else {
        echo "Error: " . $sql_weights . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_workout . "<br>" . $conn->error;
}

$conn->close();
?>
