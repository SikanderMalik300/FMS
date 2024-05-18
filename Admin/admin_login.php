<?php
// Start session
session_start();

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

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE Email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();
    $hashedPassword = $row['Password'];
    if (md5($password) === $hashedPassword) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['Name'];
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['surname'] = $row['SurName']; 
        // Redirect to dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Password is incorrect
        echo "Invalid credentials";
    }
} else {
    // User not found
    echo "Invalid credentials";
}

// Close connection
$conn->close();
?>
