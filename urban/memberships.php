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

$sql = "SELECT memberships.membership_id, memberships.user_id, users.username, memberships.membership_type, memberships.start_date, memberships.end_date
        FROM memberships
        JOIN users ON memberships.user_id = users.user_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memberships</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bebas Neue', sans-serif;
            margin: 0;
            padding: 20px;
            background: url('urbangym.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            color: #000;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #09814A;
            color: white;
        }

        .active {
            color: green;
            font-weight: bold;
        }

        .inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Memberships</h1>
    </header>

    <table>
        <thead>
            <tr>
                <th>Membership ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Membership Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                $status = (strtotime($row['end_date']) >= time()) ? "<span class='active'>Active</span>" : "<span class='inactive'>Inactive</span>";
                echo "<tr>
                        <td>{$row['membership_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['membership_type']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>{$status}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
