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

// Fetch all fee structures along with the related streams and subjects
$query = "SELECT fs.id AS fee_id, s.subject_name, st.stream_name, fs.fee_structure 
          FROM fee_structures fs
          JOIN subjects s ON fs.subject_id = s.id
          JOIN streams st ON fs.stream_id = st.id";
$result = $conn->query($query);
?>

<!-- Fee Structure Management -->
<div class="main-content">
    <h2>Fee Structure Management</h2>
	<form method="POST" action="fee_structure_add.php">
        <button type="submit">Add New Fee Structure</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>SlNo</th>
                <th>Stream</th>
                <th>Subject</th>
                <th>Fee Structure</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $counter = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $row['stream_name']; ?></td>
                        <td><?php echo $row['subject_name']; ?></td>
                        <td><?php echo $row['fee_structure']; ?></td>
                        <td>
                            <a href="fee_structure_edit.php?id=<?php echo $row['fee_id']; ?>">Edit</a> <hr> 
                            <a href="fee_structure_delete.php?id=<?php echo $row['fee_id']; ?>" onclick="return confirm('Are you sure you want to delete this fee structure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No fee structures found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
