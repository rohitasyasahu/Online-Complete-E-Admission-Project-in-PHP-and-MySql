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

// Fetch all streams and their associated subjects
$query = "SELECT sl.id AS link_id, s.subject_name, st.stream_name 
          FROM subject_links sl
          JOIN subjects s ON sl.subject_id = s.id
          JOIN streams st ON sl.stream_id = st.id";
$result = $conn->query($query);
?>

<!-- Subject Link Management -->
<div class="main-content">
    <h2>Subject Links Management</h2>
    <form method="POST" action="subjectlinkadd.php">
        <button type="submit">Add New Subject Link</button>
    </form>
    <!-- Table to display streams and subjects -->
    <table>
       
            <tr>
                <th>SlNo</th>
                <th>Stream</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>
        
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $counter = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $row['stream_name']; ?></td>
                        <td><?php echo $row['subject_name']; ?></td>
                        <td>
                            <a href="subjectlinkedit.php?id=<?php echo $row['link_id']; ?>">Edit</a> <hr> 
                            <a href="subjectlinkdelete.php?id=<?php echo $row['link_id']; ?>" onclick="return confirm('Are you sure you want to delete this link?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No subject links found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
