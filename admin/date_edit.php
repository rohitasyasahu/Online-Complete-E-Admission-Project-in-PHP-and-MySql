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

// Fetch the date to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT event_name, event_date FROM important_dates WHERE id = '$id'";
    $result = $conn->query($query);
    $date = $result->fetch_assoc();
} else {
    header('Location: date.php'); // Redirect if no ID is provided
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];

    // Update the date in the database
    $query = "UPDATE important_dates SET event_name = '$event_name', event_date = '$event_date' WHERE id = '$id'";
    if ($conn->query($query) === TRUE) {
        echo "<p>Important date updated successfully!</p>";
        header('Location: date.php'); // Redirect to date management page
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!-- Form for editing important date -->
<div class="main-content">
    <h2>Edit Important Date</h2>
    <form method="POST" action="">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" id="event_name" value="<?php echo $date['event_name']; ?>" required>

        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" id="event_date" value="<?php echo $date['event_date']; ?>" required>

        <button type="submit">Update Date</button>
    </form>
    <a href="date.php">Back to Important Dates</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
