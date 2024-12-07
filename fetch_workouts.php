<?php
header("Content-Type: application/json");

// Database connection details
$servername = "database-2.cn4ksqii2unx.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "WorkoutLogDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Prepare SQL query to get all records from the Workouts table
$sql = "SELECT workout_id, user_id, workout_type, date FROM Workouts";
$result = $conn->query($sql);

// Check if query execution was successful
if ($result === false) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to execute query: " . $conn->error]);
    $conn->close();
    exit();
}

// Fetch results
$workouts = [];
while ($row = $result->fetch_assoc()) {
    $workouts[] = $row;
}

// Check if results are empty
if (empty($workouts)) {
    http_response_code(404); // Not Found
    echo json_encode(["message" => "No records found in the Workouts table."]);
} else {
    // Send results as JSON
    echo json_encode($workouts);
}

// Clean up
$conn->close();
?>
