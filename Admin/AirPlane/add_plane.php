<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if session is not set
    header("Location: ../admin_login.html");
    exit();
}

$email = $_SESSION['email'];
$name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];
$surname = $_SESSION['surname'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Plane</title>
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

        .addbtn {
            background-color: #101725;
            color: white;
            width: 30%;
            padding: 12px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: semi-bold;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            margin-right: 10px;
        }

        .addbtn:hover {
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

        .goback-btn {
    background-color: white;
    color: #101725;
    border: none;
    cursor: pointer;
    margin-bottom: 20px; /* Adjust margin as needed */
    margin-left: 20px; /* Adjust margin as needed */
    padding: 0;
}

.goback-btn img {
    width: 40px;
    height: 40px;
}

/* Form container styles */
/* Form container styles */
.form-container {
    max-width: 800px; /* Increased max-width for better alignment */
    margin: 20px auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Form section styles */
.b1,
.b2,
.b3,
.b4,
.b6 {
    margin-bottom: 20px;
}

.b2,
.b3 {
    display: flex;
    justify-content: space-between; /* Align elements evenly */
}

label {
    font-weight: bold;
}

/* Form section item styles */
.b1 label,
.b2 label,
.b3 label,
.b4 label,
.b5 label,
.b6 label {
    font-weight: bold;
    font-size: 16px;
}

.b1 {
    width: 30%;
}

.b4,
.b5 { /* Adjust width and display property for better alignment */
    width: 47.5%; /* Equal width for both elements */
    display: flex;
}

.b5{
    width: 100%;
}

.b4 select,
.b5 select {
    width: calc(100% - 10px); /* Adjust width to fit inside container */
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

input[type="text"],
select
 {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

.Designation-block{
 width: 47.5%; /* Equal width for both elements */
    display: flex;
}

#designation{
   
}

#pilotDropdown{
  width: 100%;
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
        <a href="../Flight/all_flight_listing.php" >Manage Flights</a> 
        <a href="../Staff/all_staff_listing.php">Manage Staff</a>
        <a href="../AirPlane/all_plane_listing.php" id='active'>Manage Airplanes</a>
    </div>
    <div class="content">
    <form action="all_plane_listing.php" method="post">
        <button type="submit" class="goback-btn"><img src="https://cdn-icons-png.flaticon.com/128/318/318477.png" alt="Go Back"></button>
    </form>
    <h2>Add Plane</h2>
    <form action="store_plane.php" method="post" class="form-container">
        <label for="ser_num">Serial Number:</label><br>
        <input type="text" id="ser_num" name="ser_num" required><br>
        
        <label for="manufacture">Manufacture:</label><br>
        <input type="text" id="manufacture" name="manufacture" required><br>
        
        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model" required><br><br>

        <label for="rating">Rating:</label><br>
        <select id="rating" name="rating">
        <option value="1">1 star</option>
        <option value="2">2 stars</option>
        <option value="3">3 stars</option>
        <option value="4">4 stars</option>
        <option value="5">5 stars</option>
        </select><br><br>
        
        <div style="text-align: center;">
    <input type="submit" value="Add Airplane" class='addbtn'>
</div>
    </form>
</div>
</body>
</html>
