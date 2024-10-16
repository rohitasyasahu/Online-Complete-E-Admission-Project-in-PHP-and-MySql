<?php
include('../db/db_connect.php'); // Include the database connection

// Admin username and password
$username = 'Deepak';
$password = 'Deepak@123';

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into the admins table
$query = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";

if ($conn->query($query) === TRUE) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $conn->error;
}

// Close the connection
$conn->close();
?>
