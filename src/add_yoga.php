<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "database-2.cn4ksqii2unx.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "WorkoutLogDB";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data from the form
    $duration = intval($_POST["duration"]);
    $intensity = $_POST["intensity"];
    $user_id = "test_user"; // Replace with a real user_id (e.g., from session data)

    // Insert into the `Workouts` table first to create a new workout record
    $workout_type = 'Yoga';
    $sql_workout = "INSERT INTO Workouts (user_id, workout_type, date) VALUES ('$user_id', '$workout_type', NOW())";

    if ($conn->query($sql_workout) === TRUE) {
        // Get the last inserted workout_id to associate with the yoga workout
        $workout_id = $conn->insert_id;

        // Insert into the `YogaWorkouts` table
        $sql_yoga = "INSERT INTO YogaWorkouts (workout_id, duration, intensity) VALUES ('$workout_id', '$duration', '$intensity')";

        if ($conn->query($sql_yoga) === TRUE) {
            echo "Yoga workout added successfully.";
        } else {
            echo "Error adding to YogaWorkouts table: " . $conn->error;
        }
    } else {
        echo "Error adding to Workouts table: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
