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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $duration = intval($_POST["duration"]);
    $intensity = $_POST["intensity"];
    $user_id = $_POST['email']; // Get user email from form POST

    // Check if user exists in Users table
    $check_user_query = "SELECT * FROM Users WHERE user_id = '$user_id'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows == 0) {
        // User does not exist, insert into Users table
        $insert_user_query = "INSERT INTO Users (user_id) VALUES ('$user_id')";
        if ($conn->query($insert_user_query) === TRUE) {
            echo "User with email '$user_id' has been created.<br>";
        } else {
            die("Error creating user: " . $conn->error);
        }
    }

    // Insert into the `Workouts` table
    $workout_type = 'Yoga';
    $sql_workout = "INSERT INTO Workouts (user_id, workout_type, date) VALUES ('$user_id', '$workout_type', NOW())";

    if ($conn->query($sql_workout) === TRUE) {
        $workout_id = $conn->insert_id;

        // Insert into `YogaWorkouts`
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
