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
$fee_structure = '';

// Fetch all streams and subjects for dropdown
$streams_query = "SELECT * FROM streams";
$subjects_query = "SELECT * FROM subjects";

$streams_result = $conn->query($streams_query);
$subjects_result = $conn->query($subjects_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stream_id']) && isset($_POST['subject_id']) && isset($_POST['fee_structure'])) {
        $stream_id = $_POST['stream_id'];
        $subject_id = $_POST['subject_id'];
        $fee_structure = $_POST['fee_structure'];

        // Insert the fee structure into the database
        $insert_query = "INSERT INTO fee_structures (stream_id, subject_id, fee_structure) VALUES ('$stream_id', '$subject_id', '$fee_structure')";

        if ($conn->query($insert_query) === TRUE) {
            echo "<p>Fee structure added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>

<!-- Add Fee Structure Form -->
<div class="main-content">
    <h2>Add New Fee Structure</h2>
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

        <label for="fee_structure">Fee Structure:</label>
        <input type="number" name="fee_structure" id="fee_structure" required>

        <button type="submit">Add Fee Structure</button>
    </form>
    <a href="fee_structure.php">Back to Fee Structures</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
