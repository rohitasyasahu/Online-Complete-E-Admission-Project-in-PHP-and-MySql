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

// Fetch subject details
$subject_id = $_GET['id'];
$query = "SELECT * FROM subjects WHERE id='$subject_id'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['subject_name'];

    // Update subject in database
    $query = "UPDATE subjects SET subject_name='$subject_name' WHERE id='$subject_id'";
    
    if ($conn->query($query) === TRUE) {
        echo "<p>Subject updated successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!-- Subject Edit Form -->
<div class="main-content">
    <h2>Edit Subject</h2>
    <form method="POST" action="">
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" id="subject_name" value="<?php echo $row['subject_name']; ?>" required>
        <button type="submit">Update Subject</button>
    </form>
    <a href="subject_list.php">Back to Subject List</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
