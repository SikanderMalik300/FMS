<?php
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

// Retrieve rating from POST data
$rating = $_POST['rating'];

// Retrieve pilots with matching rating
$sql = "SELECT EmpNum, Name, Surname FROM staffs WHERE Designation = 'Pilot' AND Booked = 0 AND Rating = '$rating'";
$result = $conn->query($sql);

$pilots = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pilots[] = $row;
    }
}

// Close connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($pilots);
?>
