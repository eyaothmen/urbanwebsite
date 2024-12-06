<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: urban.php?error=access_denied");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urbangymdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch usernames for dropdown
$user_query = "SELECT user_id, username FROM users";
$user_result = $conn->query($user_query);

// Add Membership
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $membership_type = $_POST['membership_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "INSERT INTO memberships (user_id, membership_type, start_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isss', $user_id, $membership_type, $start_date, $end_date);

    if ($stmt->execute()) {
        $message = "Membership added successfully.";
    } else {
        $message = "Failed to add membership.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Manage Memberships</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bebas Neue', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-image: url('urbangym.jpeg');
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            color: #09814A;
            margin: 0;
        }

        main {
            margin-top: 100px; /* Leave space for the fixed header */
            width: 100%;
            max-width: 500px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 18px;
            color: #140101;
        }

        input, select, button {
            display: block;
            width: calc(100% - 20px);
            margin: 10px auto;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 200px;
            height: 50px;
            margin: 15px auto;
            font-size: 18px;
            font-family: 'Bebas Neue', sans-serif;
            background-color: #09814A;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #067f39;
        }

        .buttons-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .buttons-container button {
            width: 150px;
        }

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
        <h1>Urban Gym Admin</h1>
    </header>

    <main>
        <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>

        <form method="POST" action="admin.php">
            <label for="user_id">User:</label>
            <select id="user_id" name="user_id" required>
                <option value="" disabled selected>Select a user</option>
                <?php
                while ($row = $user_result->fetch_assoc()) {
                    echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                }
                ?>
            </select>

            <label for="membership_type">Membership Type:</label>
            <select id="membership_type" name="membership_type" required>
                <option value="Basic">Basic</option>
                <option value="Premium">Premium</option>
                <option value="Private Coaching">Private Coaching</option>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <button type="submit">Add Membership</button>
        </form>

        <div class="buttons-container">
            <button onclick="location.href='memberships.php'">View Memberships</button>
            <button onclick="location.href='logout.php'">Logout</button>
            <button onclick="location.href='home.html'">Home</button>
        </div>
    </main>
</body>
</html>
