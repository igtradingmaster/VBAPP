<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hotel_booking_app_new");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];

// Sanitize input
$email = $conn->real_escape_string($email);
$name = $conn->real_escape_string($name);
$mobile = $conn->real_escape_string($mobile);
$password = $conn->real_escape_string($password);

// Check for duplicates
$sql = "SELECT * FROM users WHERE email = '$email' OR name = '$name' OR mobile = '$mobile'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'User with this email, name, or mobile already exists']);
} else {
    // Insert new user
    $sql = "INSERT INTO users (email, name, mobile, password) VALUES ('$email', '$name', '$mobile', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
}

$conn->close();
?>
