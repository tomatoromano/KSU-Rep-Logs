<?php
header("Content-Type: application/json");

$servername = "database-2.cn4ksqii2unx.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "WorkoutLogDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

if (!isset($_GET['workout_id']) || !isset($_GET['type'])) {
    echo json_encode(["error" => "Workout ID and type are required."]);
    exit();
}

$workoutId = $_GET['workout_id'];
$type = $_GET['type'];
$data = [];

if ($type === 'Cardio') {
    $sql = "SELECT duration, intensity FROM CardioWorkouts WHERE workout_id = ?";
} elseif ($type === 'Yoga') {
    $sql = "SELECT duration, intensity FROM YogaWorkouts WHERE workout_id = ?";
} elseif ($type === 'Weights') {
    $sql = "SELECT sets, reps_per_set, weight_lbs FROM WeightsWorkouts WHERE workout_id = ?";
} else {
    echo json_encode(["error" => "Invalid workout type."]);
    exit();
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $workoutId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = ["error" => "No details found for the specified workout."];
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
