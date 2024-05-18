<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if session is not set
    header("Location: login.html");
    exit();
}

// Check if flight ID is provided in the URL
if (isset($_GET['flightnum'])) {
    $flightnum = $_GET['flightnum'];

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

    // Retrieve flight details
    $sql = "SELECT * FROM flight WHERE flightnum = '$flightnum'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Flight details
        $origin = $row['origin'];
        $dest = $row['dest'];
        $date = $row['date'];
        $arr_time = $row['arr_time'];
        $dep_time = $row['dep_time'];

        // Close connection
        $conn->close();
    } else {
        echo "Flight not found.";
        exit();
    }
} else {
    echo "Flight ID not provided.";
    exit();
}

// If the user submits the form to confirm the booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and perform booking process
    $passenger_id = $_SESSION['user_id']; // Assuming user ID is used as passenger ID
    $flight_id = $flightnum; // Assuming flight number is used as flight ID

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert booking into the database
    $sql = "INSERT INTO bookings (passengerid, flightnum) VALUES ('$passenger_id', '$flight_id')";

    if ($conn->query($sql) === TRUE) {
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking - FMS</title>
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

        /* Sidebar styles */
        .content {
    max-width: 1300px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-left: 270px; /* Adjust sidebar width + some extra space */
    margin-right: 20px; /* Adjust as needed */
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

        /* Content styles */

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

h3 {
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
    padding: 10px 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
    width: 200px; /* Optional: Adjust the width as needed */
}

    .confirm:hover {
        background-color: #191924;
    }

    #active {
            background-color: #ddd;
            color: #333;
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

        .toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
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
        <a href="../dashboard.php" id='active'>Upcoming Flights</a>
        <a href="view_bookings.php">Passenger Bookings</a>
        <a href="../History/view_flight_history.php">Flight History</a>
    </div>

    <div class="content">
    <h3>Booking Details</h3>
    <table>
        <tr>
            <td><strong>Flight Number</strong></td>
            <td><?php echo $flightnum; ?></td>
        </tr>
        <tr>
            <td><strong>Origin</strong></td>
            <td><?php echo $origin; ?></td>
        </tr>
        <tr>
            <td><strong>Destination</strong></td>
            <td><?php echo $dest; ?></td>
        </tr>
        <tr>
            <td><strong>Date</strong></td>
            <td><?php echo $date; ?></td>
        </tr>
        <tr>
    <td><strong>Arrival Time</strong></td>
    <td><?php echo date("g:i a", strtotime($arr_time)); ?></td>
</tr>
<tr>
    <td><strong>Departure Time</strong></td>
    <td><?php echo date("g:i a", strtotime($dep_time)); ?></td>
</tr>
    </table>

    <div class="confirm-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?flightnum=' . $flightnum; ?>" method="post">
            <input type="submit" value="Confirm Booking" class="confirm">
        </form>
    </div>
</div>

    <!-- Toast message -->
    <div id="toast" class="toast">Flight booked successfully!</div>

    <script>
        // Show toast message
        function showToast() {
            var toast = document.getElementById("toast");
            toast.className = "toast show";
            setTimeout(function(){
                toast.className = toast.className.replace("show", ""); 
            }, 3000);
        }

        // Check if booking is successful and show toast message
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
            showToast();
        <?php } ?>
    </script>
</body>
</html>

