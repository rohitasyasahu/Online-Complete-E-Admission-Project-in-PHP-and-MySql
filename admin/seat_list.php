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

// Fetch all seat allocations along with the related subjects and streams
$query = "SELECT seats.id, s.subject_name, st.stream_name, seats.total_seats, seats.general_seats, seats.obc_seats, seats.sc_seats, seats.st_seats 
          FROM seats 
          JOIN subjects s ON seats.subject_id = s.id 
          JOIN streams st ON seats.stream_id = st.id";
$result = $conn->query($query);
?>

<!-- Seat Management -->
<div class="main-content">
    <h2>Seat Allocations Management</h2>
    <table>
        <thead>
            <tr>
                <th>SlNo</th> <!-- Add SlNo header -->
                <th>Stream</th>
                <th>Subject</th>
                <th>Total Seats</th>
                <th>General</th>
                <th>OBC</th>
                <th>SC</th>
                <th>ST</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $sl_no = 1; // Initialize SlNo counter ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $sl_no++; // Increment and display SlNo ?></td> <!-- Display SlNo -->
                        <td><?php echo $row['stream_name']; ?></td>
                        <td><?php echo $row['subject_name']; ?></td>
                        <td><?php echo $row['total_seats']; ?></td>
                        <td><?php echo $row['general_seats']; ?></td>
                        <td><?php echo $row['obc_seats']; ?></td>
                        <td><?php echo $row['sc_seats']; ?></td>
                        <td><?php echo $row['st_seats']; ?></td>
                        <td>
                            <a href="seat_edit.php?id=<?php echo $row['id']; ?>">Edit</a> <hr> 
                            <a href="seat_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this allocation?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No seat allocations found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="seat_add.php">Add New Seat Allocation</a>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
