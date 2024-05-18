<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if session is not set
    header("Location: ../admin_login.html");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch booked planes from the air_planes table
$sql = "SELECT * FROM air_planes WHERE Booked = 1";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Plane Listing</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <form action="all_plane_listing.php" method="post">
        <input type="submit" value="Back">
    </form>
    <h2>Booked Plane Listing</h2>
    <table>
        <thead>
            <tr>
                <th>Serial Number</th>
                <th>Manufacture</th>
                <th>Model</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['SerNum'] . "</td>";
                    echo "<td>" . $row['Manufacture'] . "</td>";
                    echo "<td>" . $row['Model'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No booked planes found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
