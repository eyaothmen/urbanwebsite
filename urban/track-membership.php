<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: urban.php?error=not_logged_in");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urbangymdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['user_id'];

$sql = "SELECT membership_type, start_date, end_date FROM memberships WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Gym - Track Membership</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-image: url('urbangym.jpeg');
            background-size: cover;
            height: 100vh;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        header {
            width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
            text-align: center;
        }

        header h1 {
            font-family: 'Bebas Neue', sans-serif;
            margin: 0;
            color: #09814A;
        }

        main {
            margin-top: 80px; /* To give space for the fixed header */
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        button {
            display: inline-block;
            width: 150px;
            height: 50px;
            font-size: 18px;
            font-family: 'Bebas Neue', sans-serif;
            background-color: #09814A;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px;
        }

        button:hover {
            background-color: #067f39;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        /* Add blur effect to the background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(10px);
            z-index: -1;
        }
    </style>
</head>
<body>
    <header>
        <h1>Urban Gym</h1>
    </header>
    <main>
        <section>
            <h2>Your Membership Details</h2>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p>Membership Type: " . htmlspecialchars($row["membership_type"]) . "</p>";
                    echo "<p>Start Date: " . htmlspecialchars($row["start_date"]) . "</p>";
                    echo "<p>End Date: " . htmlspecialchars($row["end_date"]) . "</p>";
                }
            } else {
                echo "<p>No membership found for this user.</p>";
            }

            $conn->close();
            ?>
        </section>

        <!-- Buttons Container (for Logout and Home) -->
        <div class="buttons-container">
            <button onclick="location.href='logout.php'">Logout</button>
            <button onclick="location.href='home.html'">Home</button>
        </div>
    </main>
</body>
</html>
