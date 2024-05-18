# Flight-Management-System

This Flight Management System is a web application developed using HTML5, CSS3, JavaScript, AJAX, jQuery, PHP, and MySQL database. It provides a comprehensive set of features for both administrators and passengers, facilitating efficient management of flights and bookings.

**Features:**

**Administrator:**
Create and manage flights, including scheduling, seat availability, and pricing.
Add and manage airplanes, with details like model, seating capacity, and operational status.
Manage staff (crew members), assign roles, and update their information.
View and manage all bookings made by passengers.
View and update flight and airplane details.

**Passenger:**
Search and book flights based on various criteria such as destination, date, and price.
View flight details including departure time, arrival time, and available seats.
Access and manage their bookings.
View travel history including past bookings and flight details.
Setup Instructions:
To run this project locally, follow these steps:

**Install XAMPP:**

Download and install XAMPP from https://www.apachefriends.org/index.html.
Start the Apache and MySQL services.

**Clone the Repository:**
Clone the repository into the htdocs folder of your XAMPP installation.
bash
Copy code
git clone <repository_url> C:\xampp\htdocs\flight-management-system
Alternatively, download the project files and extract them into C:\xampp\htdocs\flight-management-system.

**Import Database:**
Open your web browser and go to http://localhost/phpmyadmin.
Log in with your MySQL credentials (default username is root and password is empty).
Create a new database named flight_management_system.
Import the database schema from flight_management_system.sql file located in the project's root directory.

**Configuration:**
Open config.php file located in the project's root directory.
Update the MySQL database credentials if necessary (default username is root and password is empty).
Run the Application:

Open your web browser and go to http://localhost/flight-management-system.
You should now see the Flight Management System application running.

Login:
Use the following credentials to log in as an administrator:
Username: smith12@gmail.com
Password: 12345678

Use the following credentials to log in as a passenger:
Username: smalik01@gmail.com
Password: 12345678

**Project Structure:**
index.php: Landing page of the application.
admin: Directory containing all admin-related functionality.
passenger: Directory containing all passenger-related functionality.
assets: Contains CSS, JavaScript, and image files.
includes: PHP files containing common functions and database connection.
config.php: Configuration file for database connection.

**Technologies Used:**
Frontend: HTML5, CSS3, JavaScript, AJAX, jQuery
Backend: PHP
Database: MySQL

**Additional Notes:**
This project is designed to simulate a flight management system with features for both administrators and passengers.
The application uses PHP for server-side processing and MySQL for database management.
Ensure XAMPP's Apache and MySQL services are running to use this application.

**Contributors:**
Sikander Malik & Nauman Mirza

**License:**
This project is licensed under the MIT License.


