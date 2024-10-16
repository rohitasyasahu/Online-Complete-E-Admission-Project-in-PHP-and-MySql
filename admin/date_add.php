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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];

    // Insert into database
    $query = "INSERT INTO important_dates (event_name, event_date) VALUES ('$event_name', '$event_date')";
    if ($conn->query($query) === TRUE) {
        echo "<p>Important date added successfully!</p>";
        header('Location: date.php'); // Redirect to date management page
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!-- Form for adding new important date -->
<div class="main-content">
    <h2>Add New Important Date</h2>
    <form method="POST" action="">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" id="event_name" required>

        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" id="event_date" required>

        <button type="submit">Add Date</button>
    </form>
    <a href="date.php">Back to Important Dates</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
