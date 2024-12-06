<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urbangymdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $phonenumber = trim($_POST['phonenumber']);
    $dob = $_POST['dob'];

    if (empty($username) || empty($password) || empty($firstname) || empty($lastname) || empty($dob)) {
        header("Location: register.html?error=missing_fields");
        exit();
    }

    $full_name = $firstname . ' ' . $lastname;

    // Check if username exists
    $checkUsernameQuery = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: register.html?error=username_in_use");
        exit();
    }

    

    // Insert user into the database
    $insertQuery = "INSERT INTO users (username, password, full_name, phonenumber, dob) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param('sssss', $username, $password, $full_name, $phonenumber, $dob);

    if ($stmt->execute()) {
        header("Location: urban.php?success=registered");
        exit();
    } else {
        header("Location: register.html?error=registration_failed");
        exit();
    }
}

$conn->close();
?>
