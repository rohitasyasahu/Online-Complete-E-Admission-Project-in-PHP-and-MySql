<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');

// Get the student ID from the session
$student_id = $_SESSION['student_id'];

// Fetch the student's details
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Check if student exists
if (!$student) {
    echo "Student not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $caste = $_POST['caste'];
    $religion = $_POST['religion'];
    $present_address = $_POST['present_address'];
    $present_post = $_POST['present_post'];
    $present_block = $_POST['present_block'];
    $present_district = $_POST['present_district'];
    $present_state = $_POST['present_state'];
    $permanent_address = $_POST['permanent_address'];
    $permanent_post = $_POST['permanent_post'];
    $permanent_block = $_POST['permanent_block'];
    $permanent_district = $_POST['permanent_district'];
    $permanent_state = $_POST['permanent_state'];
    $board_10th = $_POST['board_10th'];
    $institute_10th = $_POST['institute_10th'];
    $secure_mark_10th = $_POST['secure_mark_10th'];
    $full_mark_10th = $_POST['full_mark_10th'];
    $percentage_10th = $_POST['percentage_10th'];
    $board_intermediate = $_POST['board_intermediate'];
    $institute_intermediate = $_POST['institute_intermediate'];
    $secure_mark_intermediate = $_POST['secure_mark_intermediate'];
    $full_mark_intermediate = $_POST['full_mark_intermediate'];
    $percentage_intermediate = $_POST['percentage_intermediate'];
    $board_graduation = $_POST['board_graduation'];
    $institute_graduation = $_POST['institute_graduation'];
    $secure_mark_graduation = $_POST['secure_mark_graduation'];
    $full_mark_graduation = $_POST['full_mark_graduation'];
    $percentage_graduation = $_POST['percentage_graduation'];
    $stream_id = $_POST['stream_id'];
    $subject_id = $_POST['subject_id'];

    // Update the student information in the database
    $update_query = "UPDATE students SET 
    name=?, 
    father_name=?, 
    mother_name=?, 
    mobile=?, 
    email=?, 
    gender=?, 
    caste=?, 
    religion=?, 
    present_address=?, 
    present_post=?, 
    present_block=?, 
    present_district=?, 
    present_state=?, 
    permanent_address=?, 
    permanent_post=?, 
    permanent_block=?, 
    permanent_district=?, 
    permanent_state=?, 
    board_10th=?, 
    institute_10th=?, 
    secure_mark_10th=?, 
    full_mark_10th=?, 
    percentage_10th=?, 
    board_intermediate=?, 
    institute_intermediate=?, 
    secure_mark_intermediate=?, 
    full_mark_intermediate=?, 
    percentage_intermediate=?, 
    board_graduation=?, 
    institute_graduation=?, 
    secure_mark_graduation=?, 
    full_mark_graduation=?, 
    percentage_graduation=?, 
    stream_id=?, 
    subject_id=? 
WHERE id=?";
    
    // Prepare statement
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssssssssssssssssssssssssssssssi", 
        $name, 
        $father_name, 
        $mother_name, 
        $mobile, 
        $email, 
        $gender, 
        $caste, 
        $religion, 
        $present_address, 
        $present_post, 
        $present_block, 
        $present_district, 
        $present_state, 
        $permanent_address, 
        $permanent_post, 
        $permanent_block, 
        $permanent_district, 
        $permanent_state, 
        $board_10th, 
        $institute_10th, 
        $secure_mark_10th, 
        $full_mark_10th, 
        $percentage_10th, 
        $board_intermediate, 
        $institute_intermediate, 
        $secure_mark_intermediate, 
        $full_mark_intermediate, 
        $percentage_intermediate, 
        $board_graduation, 
        $institute_graduation, 
        $secure_mark_graduation, 
        $full_mark_graduation, 
        $percentage_graduation, 
        $stream_id, 
        $subject_id, 
        $student_id
    );

    // Execute the update query
    if ($stmt->execute()) {
        echo "Student information updated successfully!";
    } else {
        echo "Error updating student information: " . $stmt->error;
    }
}

// Display the form with student information
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script>
        function calculatePercentage(secureMark, fullMark, percentageField) {
            const secure = parseFloat(document.getElementById(secureMark).value) || 0;
            const full = parseFloat(document.getElementById(fullMark).value) || 0;
            const percentage = (secure / full) * 100;
            document.getElementById(percentageField).value = isNaN(percentage) ? 0 : percentage.toFixed(2);
        }
    </script>
</head>
<body>

<!-- Include header -->
<?php include('header.php'); ?>

<div class="container">
    <h2>Edit Student Information</h2>
    
    <?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
    
	<h3>Personal Information<h3><br>
    <table>
        <tr>
            <td>Name:</td><td>Father's Name:</td><td>Mother's Name:</td><td>Mobile:</td>
		</tr>
		<tr>
            <td><input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required></td>
			<td><input type="text" name="father_name" value="<?php echo htmlspecialchars($student['father_name']); ?>" required></td>
			<td><input type="text" name="mother_name" value="<?php echo htmlspecialchars($student['mother_name']); ?>" required></td>
			<td><input type="text" name="mobile" value="<?php echo htmlspecialchars($student['mobile']); ?>" required></td>
        </tr>
        <tr>
            <td>Email:</td><td>Gender:</td><td>Caste:</td><td>Religion:</td>
		</tr>
            <td><input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required></td>
			<td>
                <select name="gender">
                    <option value="Male" <?php if ($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </td>
			<td><input type="text" name="caste" value="<?php echo htmlspecialchars($student['caste']); ?>"></td>
			<td><input type="text" name="religion" value="<?php echo htmlspecialchars($student['religion']); ?>"></td>
        </tr>
    </table>
        
     <h3>Address Information</h3><br>
    <table>
        <tr>
            <td>Present Address:</td><td>Present Post:</td> <td>Present Block:</td> <td>Present District:</td><td>Present State:</td>
			</tr>
            <td><input type="text" name="present_address" value="<?php echo htmlspecialchars($student['present_address']); ?>"></td>
            <td><input type="text" name="present_post" value="<?php echo htmlspecialchars($student['present_post']); ?>"></td>
			<td><input type="text" name="present_block" value="<?php echo htmlspecialchars($student['present_block']); ?>"></td>
			<td><input type="text" name="present_district" value="<?php echo htmlspecialchars($student['present_district']); ?>"></td>
			<td><input type="text" name="present_state" value="<?php echo htmlspecialchars($student['present_state']); ?>"></td>
        </tr>
        <tr>
            <td>Permanent Address:</td><td>Permanent Post:</td><td>Permanent Block:</td><td>Permanent District:</td><td>Permanent State:</td>
			</tr>
            <td><input type="text" name="permanent_address" value="<?php echo htmlspecialchars($student['permanent_address']); ?>"></td>
            <td><input type="text" name="permanent_post" value="<?php echo htmlspecialchars($student['permanent_post']); ?>"></td>
			<td><input type="text" name="permanent_block" value="<?php echo htmlspecialchars($student['permanent_block']); ?>"></td>
			<td><input type="text" name="permanent_district" value="<?php echo htmlspecialchars($student['permanent_district']); ?>"></td>
			<td><input type="text" name="permanent_state" value="<?php echo htmlspecialchars($student['permanent_state']); ?>"></td>
        </tr>
    </table>
    
    <h3>Educational Information</h3><br>
    <table>
	<tr><th>Class</th><th>Board Name</th><th>Institute Name</th><th>Secure Mark</th><th>Full Mark</th><th>Percentage</th>
		</tr>
        <tr>
            <td>10th</td>
            <td><input type="text" name="board_10th" value="<?php echo htmlspecialchars($student['board_10th']); ?>" required></td>
            <td><input type="text" name="institute_10th" value="<?php echo htmlspecialchars($student['institute_10th']); ?>" required></td>
            <td><input type="number" id="secure_mark_10th" name="secure_mark_10th" value="<?php echo htmlspecialchars($student['secure_mark_10th']); ?>" oninput="calculatePercentage('secure_mark_10th', 'full_mark_10th', 'percentage_10th')" required></td>
            <td><input type="number" id="full_mark_10th" name="full_mark_10th" value="<?php echo htmlspecialchars($student['full_mark_10th']); ?>" oninput="calculatePercentage('secure_mark_10th', 'full_mark_10th', 'percentage_10th')" required></td>
            <td><input type="text" id="percentage_10th" name="percentage_10th" value="<?php echo htmlspecialchars($student['percentage_10th']); ?>" readonly></td>
        </tr>
        <tr>
            <td>Intermediate (+2)</td>
            <td><input type="text" name="board_intermediate" value="<?php echo htmlspecialchars($student['board_intermediate']); ?>" required></td>
            <td><input type="text" name="institute_intermediate" value="<?php echo htmlspecialchars($student['institute_intermediate']); ?>" required></td>
            <td><input type="number" id="secure_mark_intermediate" name="secure_mark_intermediate" value="<?php echo htmlspecialchars($student['secure_mark_intermediate']); ?>" oninput="calculatePercentage('secure_mark_intermediate', 'full_mark_intermediate', 'percentage_intermediate')" required></td>
            <td><input type="number" id="full_mark_intermediate" name="full_mark_intermediate" value="<?php echo htmlspecialchars($student['full_mark_intermediate']); ?>" oninput="calculatePercentage('secure_mark_intermediate', 'full_mark_intermediate', 'percentage_intermediate')" required></td>
            <td><input type="text" id="percentage_intermediate" name="percentage_intermediate" value="<?php echo htmlspecialchars($student['percentage_intermediate']); ?>" readonly></td>
        </tr>
        <tr>
            <td>Graduation</td>
            <td><input type="text" name="board_graduation" value="<?php echo htmlspecialchars($student['board_graduation']); ?>" required></td>
            <td><input type="text" name="institute_graduation" value="<?php echo htmlspecialchars($student['institute_graduation']); ?>" required></td>
            <td><input type="number" id="secure_mark_graduation" name="secure_mark_graduation" value="<?php echo htmlspecialchars($student['secure_mark_graduation']); ?>" oninput="calculatePercentage('secure_mark_graduation', 'full_mark_graduation', 'percentage_graduation')" required></td>
            <td><input type="number" id="full_mark_graduation" name="full_mark_graduation" value="<?php echo htmlspecialchars($student['full_mark_graduation']); ?>" oninput="calculatePercentage('secure_mark_graduation', 'full_mark_graduation', 'percentage_graduation')" required></td>
            <td><input type="text" id="percentage_graduation" name="percentage_graduation" value="<?php echo htmlspecialchars($student['percentage_graduation']); ?>" readonly></td>
        </tr>
    </table>

    <h3>Applied Subject</h3><br>
    <table>
        <tr>
            <th>Stream:</th><th>Subject:</th>
			</tr>
			<tr>
            <td>
                <select name="stream_id" required>
                    <?php
                    $stream_query = "SELECT * FROM streams";
                    $stream_result = $conn->query($stream_query);
                    while ($stream = $stream_result->fetch_assoc()) {
                        echo '<option value="' . $stream['id'] . '" ' . ($student['stream_id'] == $stream['id'] ? 'selected' : '') . '>' . htmlspecialchars($stream['stream_name']) . '</option>';
                    }
                    ?>
                </select>
            </td>
			<td>
                <select name="subject_id" required>
                    <?php
                    $subject_query = "SELECT * FROM subjects";
                    $subject_result = $conn->query($subject_query);
                    while ($subject = $subject_result->fetch_assoc()) {
                        echo '<option value="' . $subject['id'] . '" ' . ($student['subject_id'] == $subject['id'] ? 'selected' : '') . '>' . htmlspecialchars($subject['subject_name']) . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

        <button type="submit">Update Information</button>
    </form>
</div>
</body>
</html>
