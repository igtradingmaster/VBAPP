<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hotel_booking_app_new");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['loginEmail'];
$password = $_POST['loginPassword'];

// Sanitize input
$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

$sql = "SELECT name FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'name' => $row['name']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
}

$conn->close();
?>
