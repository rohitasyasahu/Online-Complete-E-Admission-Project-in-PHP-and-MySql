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

// Fetch all important dates
$query = "SELECT id, event_name, event_date FROM important_dates";
$result = $conn->query($query);
?>

<!-- Important Dates Management -->
<div class="main-content">
    <h2>Important Dates Management</h2>
    <table>
        <thead>
            <tr>
                <th>SlNo</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $sl_no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $sl_no++; ?></td>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['event_date'])); ?></td>
                        <td>
                            <a href="date_edit.php?id=<?php echo $row['id']; ?>">Edit</a> <hr> 
                            <a href="date_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this date?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No important dates found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="date_add.php">Add New Important Date</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
