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

// Initialize variables
$link_id = '';
$stream_id = '';
$subject_id = '';

// Get the link ID from the URL
if (isset($_GET['id'])) {
    $link_id = $_GET['id'];

    // Fetch the current subject link data
    $link_query = "SELECT * FROM subject_links WHERE id = '$link_id'";
    $link_result = $conn->query($link_query);
    $link_data = $link_result->fetch_assoc();

    if ($link_data) {
        $stream_id = $link_data['stream_id'];
        $subject_id = $link_data['subject_id'];
    }
}

// Fetch all streams and subjects for dropdown
$streams_query = "SELECT * FROM streams";
$subjects_query = "SELECT * FROM subjects";

$streams_result = $conn->query($streams_query);
$subjects_result = $conn->query($subjects_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stream_id']) && isset($_POST['subject_id'])) {
        $stream_id = $_POST['stream_id'];
        $subject_id = $_POST['subject_id'];

        // Update the subject link in the database
        $update_query = "UPDATE subject_links SET stream_id = '$stream_id', subject_id = '$subject_id' WHERE id = '$link_id'";

        if ($conn->query($update_query) === TRUE) {
            echo "<p>Subject link updated successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please select a stream and a subject.</p>";
    }
}
?>

<!-- Edit Subject Link Form -->
<div class="main-content">
    <h2>Edit Subject Link</h2>
    <form method="POST" action="">
        <label for="stream_id">Select Stream:</label>
        <select name="stream_id" id="stream_id" required>
            <option value="">Select Stream</option>
            <?php while ($row = $streams_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $stream_id) ? 'selected' : ''; ?>><?php echo $row['stream_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="subject_id">Select Subject:</label>
        <select name="subject_id" id="subject_id" required>
            <option value="">Select Subject</option>
            <?php while ($row = $subjects_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $subject_id) ? 'selected' : ''; ?>><?php echo $row['subject_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Update Subject Link</button>
    </form>
    <a href="subjectlink.php">Back to Subject Links</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
