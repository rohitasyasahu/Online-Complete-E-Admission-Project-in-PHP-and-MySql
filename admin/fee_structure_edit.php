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
$fee_id = '';
$stream_id = '';
$subject_id = '';
$fee_structure = '';

// Get the fee ID from the URL
if (isset($_GET['id'])) {
    $fee_id = $_GET['id'];

    // Fetch the current fee structure data
    $fee_query = "SELECT * FROM fee_structures WHERE id = '$fee_id'";
    $fee_result = $conn->query($fee_query);
    $fee_data = $fee_result->fetch_assoc();

    if ($fee_data) {
        $stream_id = $fee_data['stream_id'];
        $subject_id = $fee_data['subject_id'];
        $fee_structure = $fee_data['fee_structure'];
    }
}

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

        // Update the fee structure in the database
        $update_query = "UPDATE fee_structures SET stream_id = '$stream_id', subject_id = '$subject_id', fee_structure = '$fee_structure' WHERE id = '$fee_id'";

        if ($conn->query($update_query) === TRUE) {
            echo "<p>Fee structure updated successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>

<!-- Edit Fee Structure Form -->
<div class="main-content">
    <h2>Edit Fee Structure</h2>
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

        <label for="fee_structure">Fee Structure:</label>
        <input type="number" name="fee_structure" id="fee_structure" value="<?php echo $fee_structure; ?>" required>

        <button type="submit">Update Fee Structure</button>
    </form>
    <a href="fee_structure.php">Back to Fee Structures</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
