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

// Fetch the helpdesk information to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT college_name, college_address, college_phone, college_email FROM helpdesk WHERE id = '$id'";
    $result = $conn->query($query);
    $helpdesk_info = $result->fetch_assoc();
} else {
    header('Location: helpdesk.php'); // Redirect if no ID is provided
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $college_name = $_POST['college_name'];
    $college_address = $_POST['college_address'];
    $college_phone = $_POST['college_phone'];
    $college_email = $_POST['college_email'];

    // Update the helpdesk information in the database
    $query = "UPDATE helpdesk SET college_name = '$college_name', college_address = '$college_address', college_phone = '$college_phone', college_email = '$college_email' WHERE id = '$id'";
    if ($conn->query($query) === TRUE) {
        echo "<p>Helpdesk information updated successfully!</p>";
        header('Location: helpdesk.php'); // Redirect to helpdesk management page
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!-- Form for editing helpdesk information -->
<div class="main-content">
    <h2>Edit Helpdesk Information</h2>
    <form method="POST" action="">
        <label for="college_name">College Name:</label>
        <input type="text" name="college_name" id="college_name" value="<?php echo $helpdesk_info['college_name']; ?>" required>

        <label for="college_address">Address:</label>
        <textarea name="college_address" id="college_address" required><?php echo $helpdesk_info['college_address']; ?></textarea>

        <label for="college_phone">Phone:</label>
        <input type="text" name="college_phone" id="college_phone" value="<?php echo $helpdesk_info['college_phone']; ?>" required>

        <label for="college_email">Email:</label>
        <input type="email" name="college_email" id="college_email" value="<?php echo $helpdesk_info['college_email']; ?>" required>

        <button type="submit">Update Information</button>
    </form>
    <a href="helpdesk.php">Back to Helpdesk Management</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
