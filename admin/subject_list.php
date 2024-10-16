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

// Fetch subjects from the database
$query = "SELECT * FROM subjects"; // Make sure you have a subjects table
$result = $conn->query($query);
?>

<!-- Subject List Content -->
<div class="main-content">
    <h2>Subject List</h2>
    
    <form method="POST" action="subject_add.php">
        <button type="submit">Add New Subject</button>
    </form>

    <!-- Search Feature -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search Subjects" required>
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>SlNo</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM subjects WHERE subject_name LIKE '%$search%'"; // Add search functionality
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $slNo = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$slNo}</td>
                        <td>{$row['subject_name']}</td>
                        <td>
                            <a href='subject_edit.php?id={$row['id']}'>Edit</a> <hr> 
                            <a href='subject_delete.php?id={$row['id']}'>Delete</a>
                        </td>
                    </tr>";
                    $slNo++;
                }
            } else {
                echo "<tr><td colspan='3'>No subjects found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include('footer.php'); // Include the footer
$conn->close(); // Close the database connection
?>
