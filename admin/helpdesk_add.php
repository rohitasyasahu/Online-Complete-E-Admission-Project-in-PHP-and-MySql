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
    $college_name = $_POST['college_name'];
    $college_address = $_POST['college_address'];
    $college_phone = $_POST['college_phone'];
    $college_email = $_POST['college_email'];

    // Insert into database
    $query = "INSERT INTO helpdesk (college_name, college_address, college_phone, college_email) VALUES ('$college_name', '$college_address', '$college_phone', '$college_email')";
    if ($conn->query($query) === TRUE) {
        echo "<p>Helpdesk information added successfully!</p>";
        header('Location: helpdesk.php'); // Redirect to helpdesk management page
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!-- Form for adding new helpdesk information -->
<div class="main-content">
    <h2>Add New Helpdesk Information</h2>
    <form method="POST" action="">
        <label for="college_name">College Name:</label>
        <input type="text" name="college_name" id="college_name" required>

        <label for="college_address">Address:</label>
        <textarea name="college_address" id="college_address" required></textarea>

        <label for="college_phone">Phone:</label>
        <input type="text" name="college_phone" id="college_phone" required>

        <label for="college_email">Email:</label>
        <input type="email" name="college_email" id="college_email" required>

        <button type="submit">Add Information</button>
    </form>
    <a href="helpdesk.php">Back to Helpdesk Management</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
