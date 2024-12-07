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

// Check if email parameter is provided
if (!isset($_GET['email'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Email parameter is required."]);
    $conn->close();
    exit();
}

$email = $_GET['email'];

// Prepare SQL query to fetch records for the provided email
$sql = "SELECT workout_id, user_id, workout_type, date FROM Workouts WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to prepare query: " . $conn->error]);
    $conn->close();
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
$workouts = [];
while ($row = $result->fetch_assoc()) {
    $workouts[] = $row;
}

// Check if results are empty
if (empty($workouts)) {
    http_response_code(404); // Not Found
    echo json_encode(["message" => "No workouts found for the provided email."]);
} else {
    // Send results as JSON
    echo json_encode($workouts);
}

// Clean up
$stmt->close();
$conn->close();
?>
