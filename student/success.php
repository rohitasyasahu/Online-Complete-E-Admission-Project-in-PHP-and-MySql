<?php
session_start();

// Check if there is a success message
if (!isset($_SESSION['success_message'])) {
    // Redirect to registration page if accessed directly
    header('Location: register.php');
    exit();
}

// Store success message for display
$success_message = $_SESSION['success_message'];

// Clear the success message from the session
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Registration Successful!</h1>
        <p><?php echo $success_message; ?></p>
        <p><a href="login.php">Click here to log in</a> or <a href="register.php">register another account</a>.</p>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your College Name. All rights reserved.</p>
    </footer>
</body>
</html>
