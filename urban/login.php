<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urbangymdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Retrieve user details
    $sql = "SELECT user_id, password, is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['is_admin'] = $row['is_admin']; // Store admin status
            header("Location: home.html");
            exit();
        } else {
            header("Location: urban.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: urban.php?error=invalid_credentials");
        exit();
    }
}

$conn->close();
?>

