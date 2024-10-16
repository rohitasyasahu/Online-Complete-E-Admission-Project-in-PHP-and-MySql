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
$seat_id = '';
$stream_id = '';
$subject_id = '';
$total_seats = '';

// Get the seat ID from the URL
if (isset($_GET['id'])) {
    $seat_id = $_GET['id'];

    // Fetch the current seat allocation data
    $seat_query = "SELECT * FROM seats WHERE id = '$seat_id'";
    $seat_result = $conn->query($seat_query);
    $seat_data = $seat_result->fetch_assoc();

    if ($seat_data) {
        $stream_id = $seat_data['stream_id'];
        $subject_id = $seat_data['subject_id'];
        $total_seats = $seat_data['total_seats'];
    }
}

// Fetch all streams and subjects for dropdown
$streams_query = "SELECT * FROM streams";
$subjects_query = "SELECT * FROM subjects";

$streams_result = $conn->query($streams_query);
$subjects_result = $conn->query($subjects_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stream_id']) && isset($_POST['subject_id']) && isset($_POST['total_seats'])) {
        $stream_id = $_POST['stream_id'];
        $subject_id = $_POST['subject_id'];
        $total_seats = $_POST['total_seats'];

        // Calculate reserved seats
        $general_seats = round($total_seats * 0.40);
        $obc_seats = round($total_seats * 0.27);
        $sc_seats = round($total_seats * 0.16);
        $st_seats = round($total_seats * 0.13);

        // Update the seat allocation in the database
        $update_query = "UPDATE seats SET stream_id = '$stream_id', subject_id = '$subject_id', total_seats = '$total_seats', 
                         general_seats = '$general_seats', obc_seats = '$obc_seats', sc_seats = '$sc_seats', st_seats = '$st_seats' 
                         WHERE id = '$seat_id'";

        if ($conn->query($update_query) === TRUE) {
            echo "<p>Seat allocation updated successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>

<!-- Edit Seat Allocation Form -->
<div class="main-content">
    <h2>Edit Seat Allocation</h2>
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

        <label for="total_seats">Total Seats:</label>
        <input type="number" name="total_seats" id="total_seats" value="<?php echo $total_seats; ?>" required>

        <button type="submit">Update Seat Allocation</button>
    </form>
    <a href="seat_list.php">Back to Seat Allocations</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
