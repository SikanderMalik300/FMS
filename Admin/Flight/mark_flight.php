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

    // Update flight status to 'finished'
    $sql_update_status = "UPDATE flight SET status = 'finished' WHERE flightnum = $flight_id";
    if ($conn->query($sql_update_status) === TRUE) {
        // Update Booked=0 for pilot, crew members, and plane associated with the flight
        $sql_update_pilot = "UPDATE staffs SET Booked = 0 WHERE EmpNum IN (SELECT pilotid FROM flight WHERE flightnum = $flight_id)";
        $conn->query($sql_update_pilot);

        $sql_get_crew = "SELECT crewmembers FROM flight WHERE flightnum = $flight_id";
$result_get_crew = $conn->query($sql_get_crew);

if ($result_get_crew->num_rows > 0) {
    $row = $result_get_crew->fetch_assoc();
    $crew_members_json = $row['crewmembers'];
    
    // Decode JSON array to PHP array
    $crew_members_array = json_decode($crew_members_json, true);
    
    // Extract crew member IDs
    $crew_member_ids = implode(',', $crew_members_array);

    // Update Booked=0 for crew members
    $sql_update_crew = "UPDATE staffs SET Booked = 0 WHERE EmpNum IN ($crew_member_ids)";
    $conn->query($sql_update_crew);
} else {
    echo "No crew members found for this flight.";
}

        $sql_update_plane = "UPDATE air_planes SET Booked = 0 WHERE SerNum IN (SELECT planeid FROM flight WHERE flightnum = $flight_id)";
        $conn->query($sql_update_plane);

        // Redirect to flight listing page after successful marking of flight
        header("Location: all_flight_listing.php");
        exit();
    } else {
        echo "Error updating flight status: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Flight ID not provided.";
    exit();
}
?>
