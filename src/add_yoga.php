<?php
// add_yoga_workout.php

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
$duration = $_POST['duration'];
$intensity = $_POST['intensity'];
$user_id = 'some_user_id'; // Replace this with actual user ID retrieved from session or other mechanism

// Insert into Workouts table first
$sql_workout = "INSERT INTO Workouts (user_id, workout_type, date) VALUES ('$user_id', 'Yoga', NOW())";
if ($conn->query($sql_workout) === TRUE) {
    $workout_id = $conn->insert_id;

    // Insert into YogaWorkouts table
    $sql_yoga = "INSERT INTO YogaWorkouts (workout_id, duration, intensity) VALUES ('$workout_id', '$duration', '$intensity')";
    if ($conn->query($sql_yoga) === TRUE) {
        echo "New yoga workout added successfully";
    } else {
        echo "Error: " . $sql_yoga . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_workout . "<br>" . $conn->error;
}

$conn->close();
?>
