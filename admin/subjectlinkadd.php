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
$stream_id = '';
$subject_id = '';

// Fetch all streams and subjects for dropdown
$streams_query = "SELECT * FROM streams";
$subjects_query = "SELECT * FROM subjects";

$streams_result = $conn->query($streams_query);
$subjects_result = $conn->query($subjects_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stream_id']) && isset($_POST['subject_id'])) {
        $stream_id = $_POST['stream_id'];
        $subject_id = $_POST['subject_id'];

        // Insert the subject link into the database
        $insert_query = "INSERT INTO subject_links (stream_id, subject_id) VALUES ('$stream_id', '$subject_id')";

        if ($conn->query($insert_query) === TRUE) {
            echo "<p>Subject link added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please select a stream and a subject.</p>";
    }
}
?>

<!-- Add Subject Link Form -->
<div class="main-content">
    <h2>Add New Subject Link</h2>
    <form method="POST" action="">
        <label for="stream_id">Select Stream:</label>
        <select name="stream_id" id="stream_id" required>
            <option value="">Select Stream</option>
            <?php while ($row = $streams_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['stream_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="subject_id">Select Subject:</label>
        <select name="subject_id" id="subject_id" required>
            <option value="">Select Subject</option>
            <?php while ($row = $subjects_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['subject_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Add Subject Link</button>
    </form>
    <a href="subjectlink.php">Back to Subject Links</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
