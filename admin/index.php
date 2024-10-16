<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('header.php'); // Include the sidebar and header
?>

<!-- Dashboard Content -->
<div class="main-content">
    <h2>Welcome to the Admin Dashboard</h2>
    <p>Here you can manage subjects, students, and other aspects of the application process.</p>
    <!-- Additional dashboard features can be added here -->
</div>

<?php
include('footer.php'); // Include the footer
?>
