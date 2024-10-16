<?php
session_start();
include('../db/db_connect.php'); // Include database connection

// Initialize an empty error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check the admin credentials
    $query = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($query);

    // If the admin exists
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();

        // Verify the password (assuming it's hashed using password_hash())
        if (password_verify($password, $admin['password'])) {
            // Set session variables for admin login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;

            // Redirect to the admin dashboard
            header('Location: index.php');
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Admin username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
	/* General reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
}

.login-container {
    background-color: #fff;
    padding: 40px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #007bff;
    outline: none;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

p {
    margin-top: 10px;
    font-size: 14px;
    color: red;
}

/* Responsive design */
@media (max-width: 600px) {
    .login-container {
        padding: 20px;
        max-width: 100%;
    }
}
</style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error messages, if any -->
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Login form -->
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>


</body>
</html>
