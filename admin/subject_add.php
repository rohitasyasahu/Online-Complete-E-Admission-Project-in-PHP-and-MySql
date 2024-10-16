<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('header.php'); // Include the sidebar and header

// Database connection
include('../db/db_connect.php');

// Initialize subject name variable
$subject_name = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['subject_name'])) {
        $subject_name = $_POST['subject_name'];

        // Insert subject into the database
        $query = "INSERT INTO subjects (subject_name) VALUES ('$subject_name')";
        
        if ($conn->query($query) === TRUE) {
            echo "<p>Subject added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please provide a subject name.</p>";
    }
}
?>

<!-- Subject Add Form -->
<div class="main-content">
    <h2>Add New Subject</h2>
    <form method="POST" action="">
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" id="subject_name" required>
        <button type="submit">Add Subject</button>
    </form>
    <a href="subject_list.php">Back to Subject List</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
