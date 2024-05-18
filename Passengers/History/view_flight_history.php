<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if session is not set
    header("Location: login.html");
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

// Retrieve user ID
$user_id = $_SESSION['user_id'];

// Retrieve all flights booked by the logged-in passenger
$sql = "SELECT b.id, b.flightnum, f.status, f.origin, f.Intermediate, f.dest, f.date, f.arr_time, f.dep_time FROM flight f INNER JOIN bookings b ON b.flightnum = f.flightnum WHERE b.passengerid = '$user_id' and f.status='finished'";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight History</title>
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
        <a href="../logout.php" style="float: right;">Logout</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../dashboard.php">Upcoming Flights</a>
        <a href="../Booking/view_bookings.php">Passenger Bookings</a>
        <a href="view_flight_history.php" id='active'>Flight History</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h3>History of Travel</h3>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Flight Number</th>
            <th>Origin</th>
            <th>Intermediate Location</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Arrival Time</th>
            <th>Departure Time</th>
            <th>Flight Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['flightnum'] . "</td>";
                echo "<td>" . $row['origin'] . "</td>";
                echo "<td>" . $row['Intermediate'] . "</td>";
                echo "<td>" . $row['dest'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . date("h:i A", strtotime($row['arr_time'])) . "</td>";
                echo "<td>" . date("h:i A", strtotime($row['dep_time'])) . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No flight history found</td></tr>";
        }
        ?>
    </table>
        </div>
</body>
</html>
