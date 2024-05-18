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

// Retrieve form data
$ser_num = $_POST['ser_num'];
$manufacture = $_POST['manufacture'];
$model = $_POST['model'];
$rating = $_POST['rating'];

// Check if the SerNum already exists
$sql_check = "SELECT * FROM air_planes WHERE SerNum = '$ser_num'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // SerNum already exists, display error
    echo "Error: Serial Number already exists.";
} else {
    // SerNum does not exist, insert the data
    $sql_insert = "INSERT INTO air_planes (SerNum, Manufacture, Model, Booked, Rating)
    VALUES ('$ser_num', '$manufacture', '$model', false, '$rating')";
    
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: all_plane_listing.php");
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
