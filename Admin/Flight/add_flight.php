<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

.b1 input[type="text"],
.b2 input[type="text"],
.b3 input[type="date"],
.b3 input[type="time"],
.b4 select,
.b5 select,
.b6 select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
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
    <form action="all_flight_listing.php" method="post">
    <button type="submit" class="goback-btn"><img src="https://cdn-icons-png.flaticon.com/128/318/318477.png" alt="Go Back"></button>
</form>
    <h2>Enter Flight Details</h2>
    <form action="store_flight.php" method="post" id="flightForm">
        <div class='form-container'>
            <div class='b1'>
        <label for="flightnum">Flight No</label><br>
        <input type="text" id="flightnum" name="flightnum" required><br>
        </div>
        <label for="date">Flight Location</label><br>
        <div class='b2'>
        
        <input type="text" id="origin" name="origin" placeholder="Origin" required ><br>
        <input type="text" id="inter_loc" name="inter_loc" placeholder="Intermediate Location"><br>
        <input type="text" id="dest" name="dest" placeholder="Destination" required><br>
</div>
<label for="date">Flight Date & Timings</label><br>
        <div class='b3'>
        <input type="date" id="date" name="date" required><br>
        <input type="time" id="arr_time" name="arr_time" required><br>
        <input type="time" id="dep_time" name="dep_time" required><br>
</div>
<label for="plane">Select Plane & Pilots</label><br>
        <div class='b4'>
        
        <select id="plane" name="plane" required>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "flight_management_system";

            // Database connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve available planes
            $sql_planes = "SELECT * FROM air_planes WHERE Booked = 0";
            $result_planes = $conn->query($sql_planes);

            if ($result_planes->num_rows > 0) {
                // Output data of each row
                echo "<option value=''>Select</option>";
                while ($row_plane = $result_planes->fetch_assoc()) {
                    echo "<option value='" . $row_plane['SerNum'] . "' data-rating='" . $row_plane['Rating'] . "'>" . $row_plane['SerNum'] . " (" .$row_plane['Model'] . ")" . "</option>";
                }
            } else {
                echo "<option value='' disabled>No available planes</option>";
            }

            // Close connection
            $conn->close();
            ?>
        </select>
        <div id="pilotsDiv" class='b5' style="display: none;">
            <select id="pilot" name="pilot" required></select><br><br>
        </div>
        </div>

        

        <div id="crewMembersDiv" class='b6'>
    <label for="crew">Select Crew Members</label><br>
    <select id="crew" name="crew[]" multiple required>
        <?php
        // Database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve all available crew members
        $sql_crew = "SELECT * FROM staffs WHERE Designation = 'Crew Member' AND Booked = 0";
        $result_crew = $conn->query($sql_crew);

        if ($result_crew->num_rows > 0) {
            // Output data of each row
            while ($row_crew = $result_crew->fetch_assoc()) {
                echo "<option value='" . $row_crew['EmpNum'] . "'>" . $row_crew['Name'] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No available crew members</option>";
        }

        // Close connection
        $conn->close();
        ?>
    </select><br><br>
</div>
        <div style="text-align: center;">
    <input type="submit" value="Add Flight" class='addbtn'>
</div>
    </div>
    </form>

        </div>
        </div>

    <div class="toast" id="toastMessage">Flight added successfully!</div>

    <script>
    $(document).ready(function(){
        // Initialize Select2 for crew members select element
        $('#crew').select2();
        
        $('#plane').change(function(){
            if ($(this).val() === "") {
                $('#pilotsDiv').hide();
                $('#crewMembersDiv').hide();
            } else {
                $('#pilotsDiv').show();
                $('#crewMembersDiv').show();
                var selectedRating = $(this).find(':selected').data('rating');
                $.ajax({
                    type: 'POST',
                    url: 'get_pilots.php',
                    data: { rating: selectedRating },
                    dataType: 'json',
                    success: function(response){
                        $('#pilot').empty();
                        if(response.length > 0){
                            $.each(response, function(index, pilot){
                                $('#pilot').append('<option value="' + pilot.EmpNum + '">' + pilot.Name + '</option>');
                            });
                        } else {
                            $('#pilot').html('<option value="" disabled>* Pilots not found *</option>');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                        alert('Error occurred while retrieving pilots.');
                    }
                });
            }
        });

        // Client-side validation for date and time
        $('#flightForm').submit(function(e) {
            var selectedDate = new Date($('#date').val());
            var selectedTime = new Date('1970-01-01T' + $('#dep_time').val());
            var currentDateTime = new Date();

            if (selectedDate < new Date().setHours(0,0,0,0)) {
                alert('Please select a date equal to or later than today.');
                e.preventDefault();
            } else if (selectedDate === new Date().setHours(0,0,0,0) && selectedTime < currentDateTime) {
                alert('Please select a departure time later than the current time.');
                e.preventDefault();
            } else {
                // Show toast message
                $('.toast').addClass('show');
                setTimeout(function(){
                    $('.toast').removeClass('show');
                }, 3000);
            }
        });
    });
</script>

</body>
</html>
