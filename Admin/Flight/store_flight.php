<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $flightnum = $_POST['flightnum'];
    $origin = $_POST['origin'];
    $inter = isset($_POST['inter_loc']) ? $_POST['inter_loc'] : "Not available";
    $dest = $_POST['dest'];
    $date = $_POST['date'];
    $arr_time = $_POST['arr_time'];
    $dep_time = $_POST['dep_time'];
    $planeid = $_POST['plane'];
    $pilotid = $_POST['pilot'];
    $status = 'pending';
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

    // Prepare SQL statement to insert data into flight table
    $sql = "INSERT INTO flight (flightnum, origin, Intermediate, dest, date, arr_time, dep_time, planeid, pilotid, crewmembers, status)
            VALUES ('$flightnum', '$origin', '$inter', '$dest', '$date', '$arr_time', '$dep_time', '$planeid', '$pilotid', '$crewmembers','$status')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Update 'Booked' status for pilot
        $sql_update_pilot = "UPDATE staffs SET Booked = 1 WHERE EmpNum = '$pilotid'";
        $conn->query($sql_update_pilot);

        // Update 'Booked' status for crew members
        $crew_members = json_decode($crewmembers);
        foreach ($crew_members as $crew_member) {
            $sql_update_crew = "UPDATE staffs SET Booked = 1 WHERE EmpNum = '$crew_member'";
            $conn->query($sql_update_crew);
        }

        // Update 'Booked' status for the selected plane
        $sql_update_plane = "UPDATE air_planes SET Booked = 1 WHERE SerNum = '$planeid'";
        $conn->query($sql_update_plane);

        // Redirect to the listing page
        header("Location: all_flight_listing.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    // Redirect back to form page if accessed directly
    header("Location: add_flight.php");
    exit();
}
?>
