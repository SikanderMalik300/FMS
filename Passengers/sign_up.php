<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = md5($password);
$address = $_POST['address'];
$phone = $_POST['phone'];

$sql = "INSERT INTO passengers (Name, SurName, Email, Password, Address, PhoneNumber) 
        VALUES ('$name', '$surname', '$email', '$hashedPassword', '$address', '$phone')";

if ($conn->query($sql) === TRUE) {
    header("Location: login.html"); 
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
