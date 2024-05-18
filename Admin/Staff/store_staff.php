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
$emp_num = $_POST['emp_num'];
$surname = $_POST['surname'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$salary = $_POST['salary'];
$designation = $_POST['designation'];

// Set default rating
if ($designation === 'Pilot') {
    $rating = $_POST['rating']; // Use the selected rating value for Pilots
} else {
    $rating = 'N/A'; // Set rating to "N/A" for Crew Members
}

// Check if EmpNum already exists
$check_sql = "SELECT * FROM staffs WHERE EmpNum = '$emp_num'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    echo "Error: Employee number already exists.";
} else {
    // Prepare SQL statement
    $sql = "INSERT INTO staffs (EmpNum, SurName, Name, Address, PhoneNumber, Salary, Designation, Rating, Booked) 
            VALUES ('$emp_num', '$surname', '$name', '$address', '$phone', '$salary', '$designation', '$rating', false)";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        header("Location: all_staff_listing.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
