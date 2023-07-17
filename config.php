<?php
// Replace with your own database credentials
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'login';

// Create a database connection
$db = mysqli_connect($host, $user, $password, $database);

// Check for connection errors
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
