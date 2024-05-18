<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if session is not set
    header("Location: ../admin_login.html");
    exit();
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    // Redirect to all_plane_listing.php if ID is not provided
    header("Location: all_plane_listing.php");
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

// Get ID from URL parameter
$id = $_GET['id'];

// Delete plane record from the database
$sql_delete = "DELETE FROM air_planes WHERE ID = $id";

if ($conn->query($sql_delete) === TRUE) {
    header("Location: all_plane_listing.php");
} else {
    echo "Error deleting plane: " . $conn->error;
}

// Close connection
$conn->close();
?>
