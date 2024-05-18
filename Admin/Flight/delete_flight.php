<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if session is not set
    header("Location: ../admin_login.html");
    exit();
}

// Check if flight ID is provided in the URL
if (isset($_GET['flightnum'])) {
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

    $flight_id = $_GET['flightnum'];

    // Retrieve pilots, crew members, and plane ID associated with the flight
    $sql_flight = "SELECT pilotid, crewmembers, planeid FROM flight WHERE flightnum = $flight_id";
    $result_flight = $conn->query($sql_flight);

    if ($result_flight->num_rows > 0) {
        $row = $result_flight->fetch_assoc();
        $pilot_id = $row['pilotid'];
        $crew_members = json_decode($row['crewmembers']);
        $plane_id = $row['planeid'];

        // Delete flight record from the database
        $sql_delete_flight = "DELETE FROM flight WHERE flightnum = $flight_id";
        if ($conn->query($sql_delete_flight) === TRUE) {
            // Update pilots, crew members, and plane to set Booked=0
            $sql_update_pilot = "UPDATE staffs SET Booked = 0 WHERE EmpNum = '$pilot_id'";
            $conn->query($sql_update_pilot);

            foreach ($crew_members as $crew_member_id) {
                $sql_update_crew = "UPDATE staffs SET Booked = 0 WHERE EmpNum = '$crew_member_id'";
                $conn->query($sql_update_crew);
            }

            $sql_update_plane = "UPDATE air_planes SET Booked = 0 WHERE SerNum = '$plane_id'";
            $conn->query($sql_update_plane);

            // Redirect to flight listing page after successful deletion
            header("Location: all_flight_listing.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Flight not found.";
    }

    // Close connection
    $conn->close();
} else {
    echo "Flight ID not provided.";
    exit();
}
?>
