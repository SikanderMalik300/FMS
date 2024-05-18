<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $flightnum = $_POST['flightnum'];
    $origin = $_POST['origin'];
    $dest = $_POST['dest'];
    $date = $_POST['date'];
    $arr_time = $_POST['arr_time'];
    $dep_time = $_POST['dep_time'];
    $planeid = $_POST['plane'];
    $pilotid = $_POST['pilot'];
    $crewmembers = json_encode($_POST['crew']);

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

    // Prepare SQL statement to update flight data
    $sql = "UPDATE flight SET origin='$origin', dest='$dest', date='$date', arr_time='$arr_time', dep_time='$dep_time', planeid='$planeid', pilotid='$pilotid', crewmembers='$crewmembers' WHERE flightnum='$flightnum'";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
         header("Location: all_flight_listing.php"); // Redirect to the flight listing page after successful update
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    // Redirect back to the form page if accessed directly
    header("Location: update_flight.php");
    exit();
}
?>
