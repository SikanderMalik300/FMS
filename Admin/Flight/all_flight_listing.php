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

// Fetch all flights from the flight table
$sql = "SELECT f.*, a.SerNum AS planeSerNum, a.Model AS planeModel, s.Name AS pilotName FROM flight f
        INNER JOIN air_planes a ON f.planeid = a.SerNum
        INNER JOIN staffs s ON f.pilotid = s.EmpNum";
$result = $conn->query($sql);

// Function to fetch crew members for a flight
function getCrewMembers($conn, $flightnum) {
    $crewMembers = "";
    $sql = "SELECT crewmembers FROM flight WHERE flightnum = '$flightnum'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $crewMemberList = json_decode($row['crewmembers'], true);
        if (!empty($crewMemberList)) {
            $crewMembers = implode(", ", $crewMemberList);
        } else {
            $crewMembers = "No Crew Members";
        }
    } else {
        $crewMembers = "No Crew Members";
    }
    return $crewMembers;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Global styles */
        body {
            font-family: 'Poppins', sans-serif; /* Use Poppins font */
            margin: 0;
            padding: 0;
        }

        /* Navbar styles */
        .navbar {
            background-color: #191924;
            overflow: hidden;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: top 0.3s;
        }

        .navbar.fixed {
            top: -80px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }

   .content {
    max-width: 1300px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-left: 270px; /* Adjust sidebar width + some extra space */
    margin-right: 20px; /* Adjust as needed */
    margin-top:100px
}


.sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    z-index: 1;
    top: 62px;
    left: 0;
    background-color: #090917;
    padding-top: 20px;
    margin-top: 10px;
    float: left; /* Float the sidebar to the left */
}

        .sidebar a {
            display: block;
            color: white;
            padding: 16px;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #ddd;
            color: #333;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #090917;
            color: white;
            font-size: 16px;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        h2 {
            color: #333;
            text-align: center;
            font-size: 32px;
        }

        .confirm-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .confirm {
            background-color: #101725;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: semi-bold;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            margin-right: 10px;
        }
        .addbtn {
            background-color: #101725;
            color: white;
            padding: 12px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: semi-bold;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            margin-right: 10px;
        }

        .confirm:hover {
            background-color: #191924;
        }

        /* Toast message styles */
        .toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
        }

        #active {
            background-color: #ddd;
            color: #333;
        }

        .toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from { bottom: 0; opacity: 0; }
            to { bottom: 30px; opacity: 1; }
        }

        @keyframes fadein {
            from { bottom: 0; opacity: 0; }
            to { bottom: 30px; opacity: 1; }
        }

        @-webkit-keyframes fadeout {
            from { bottom: 30px; opacity: 1; }
            to { bottom: 0; opacity: 0; }
        }

        @keyframes fadeout {
            from { bottom: 30px; opacity: 1; }
            to { bottom: 0; opacity: 0; }
        }
    </style>
</head>
<body>
 <div class="navbar">
        <a href="#">Flight Management System</a>
        <a href="../logout.php" style="float: right;">Logout</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../admin_dashboard.php">Upcoming Flights</a>
        <a href="../Booking/all_booking_listing.php">View Bookings</a>
        <a href="all_flight_listing.php" id='active'>Manage Flights</a> 
        <a href="../Staff/all_staff_listing.php">Manage Staff</a>
        <a href="../AirPlane/all_plane_listing.php">Manage Airplanes</a>
    </div>

    <div class="content">

    <form action="add_flight.php" method="post">
        <input type="submit" class='addbtn' value="Add New Flight +">
    </form>
    <h2>All Flight Listing</h2>
    <table>
        <thead>
            <tr>
                <th>Flight No</th>
                <th>Origin</th>
                <th>Dest</th>
                <th>Date</th>
                <th>Arrival Time</th>
                <th>Departure Time</th>
                <th>Plane Model </th>
                <th>Pilot</th>
                <th>Crew Members</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['flightnum'] . "</td>";
                    echo "<td>" . $row['origin'] . "</td>";
                    echo "<td>" . $row['dest'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . date("h:i a", strtotime($row['arr_time'])) . "</td>";
                    echo "<td>" . date("h:i a", strtotime($row['dep_time'])) . "</td>";
                    echo "<td>" . $row['planeSerNum'] . " (" . $row['planeModel'] . ")" . "</td>";
                    echo "<td>" . $row['pilotName'] . "</td>";
                    echo "<td>" . getCrewMembers($conn, $row['flightnum']) . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td> <a class='confirm' href='delete_flight.php?flightnum=" . $row['flightnum'] . "'>Delete</a> </td>";
 echo "<td> <a class='confirm' href='mark_flight.php?flightnum=" . $row['flightnum'] . "'>Finish</a> </td>";
 echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No Flights found</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
</body>
</html>
