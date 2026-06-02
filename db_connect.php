<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "VenueBooking"; // Ensure this matches your database name

$conn = new mysqli("localhost", "root", "", "VenueBooking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>  