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

// Fetch all bookings with passenger and flight details
$sql = "SELECT b.*, p.Name AS PassengerName, p.SurName AS PassengerSurname, p.PhoneNumber, p.Address,
                f.origin AS FlightOrigin, f.dest AS FlightDestination, 
                DATE_FORMAT(f.date, '%Y-%m-%d') AS FlightDate,
                TIME_FORMAT(f.arr_time, '%h:%i %p') AS FlightArrivalTime, 
                TIME_FORMAT(f.dep_time, '%h:%i %p') AS FlightDepartureTime
        FROM bookings b
        INNER JOIN passengers p ON b.passengerid = p.ID
        INNER JOIN flight f ON b.flightnum = f.flightnum";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
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
    margin-top:100px;
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

        #active {
            background-color: #ddd;
            color: #333;
        }



h3 {
    color: #333;
    text-align: center;
    font-size: 32px;
}

form {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
}

input[type="text"] {
    flex: 2;
    width: auto;
    padding: 10px 10px; /* Adjusted padding */
    margin-right: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    font-size:16px;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #101725;
    color: white;
    padding: 10px 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    flex: 1;
    height: 40px; /* Set the height */
}

input[type="submit"]:hover {
    background-color: #191924;
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
        font-size:16px;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
    .book-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #101725;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }
    .book-btn:hover {
        background-color: #191924;
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="#">Flight Management System</a>
        <a href="logout.php" style="float: right;">Logout</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../admin_dashboard.php">Upcoming Flights</a>
        <a href="all_booking_listing.php" id='active'>View Bookings</a>
        <a href="../Flight/all_flight_listing.php">Manage Flights</a>
        <a href="../Staff/all_staff_listing.php">Manage Staff</a>
        <a href="../AirPlane/all_plane_listing.php">Manage Airplanes</a>
    </div>

    <!-- Content -->
    <div class="content">
    <h3>All Booking Listing</h3>
    <table>
        <thead>
            <tr>
                <th>Passenger Name</th>
                <th>Passenger Surname</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Flight Origin</th>
                <th>Flight Destination</th>
                <th>Flight Date</th>
                <th>Flight Arrival Time</th>
                <th>Flight Departure Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['PassengerName'] . "</td>";
                    echo "<td>" . $row['PassengerSurname'] . "</td>";
                    echo "<td>" . $row['PhoneNumber'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['FlightOrigin'] . "</td>";
                    echo "<td>" . $row['FlightDestination'] . "</td>";
                    echo "<td>" . $row['FlightDate'] . "</td>";
                    echo "<td>" . $row['FlightArrivalTime'] . "</td>";
                    echo "<td>" . $row['FlightDepartureTime'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No Bookings found</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
</body>
</html>
