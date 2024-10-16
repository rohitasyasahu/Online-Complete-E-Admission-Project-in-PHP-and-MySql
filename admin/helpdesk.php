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

// Fetch all helpdesk information
$query = "SELECT id, college_name, college_address, college_phone, college_email FROM helpdesk";
$result = $conn->query($query);
?>

<!-- Helpdesk Management -->
<div class="main-content">
    <h2>Helpdesk Management</h2>
    <table>
        <thead>
            <tr>
                <th>SlNo</th>
                <th>College Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $sl_no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $sl_no++; ?></td>
                        <td><?php echo $row['college_name']; ?></td>
                        <td><?php echo $row['college_address']; ?></td>
                        <td><?php echo $row['college_phone']; ?></td>
                        <td><?php echo $row['college_email']; ?></td>
                        <td>
                            <a href="helpdesk_edit.php?id=<?php echo $row['id']; ?>">Edit</a> <hr> 
                            <a href="helpdesk_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this helpdesk information?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No helpdesk information found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="helpdesk_add.php">Add New Helpdesk Information</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
