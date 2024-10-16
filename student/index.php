<?php
session_start();
include('header.php'); // Include the sidebar

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('../db/db_connect.php');

// Fetch logged-in student's details using session data
$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- Personal Information Section -->
<div class="print-container">
    <button class="print-btn" onclick="printDiv('printableArea')">Print</button>
</div>

<div id="printableArea"> <!-- Start printable area -->
    <h2>Personal Information</h2>
    <table>
        <tr><th>Name</th><td><?php echo $student['name']; ?></td></tr>
        <tr><th>Father's Name</th><td><?php echo $student['father_name']; ?></td></tr>
        <tr><th>Mother's Name</th><td><?php echo $student['mother_name']; ?></td></tr>
        <tr><th>Mobile</th><td><?php echo $student['mobile']; ?></td></tr>
        <tr><th>Email</th><td><?php echo $student['email']; ?></td></tr>
        <tr><th>Gender</th><td><?php echo $student['gender']; ?></td></tr>
        <tr><th>Caste</th><td><?php echo $student['caste']; ?></td></tr>
        <tr><th>Religion</th><td><?php echo $student['religion']; ?></td></tr>
    </table>

    <!-- Address Information Section -->
    <h2>Address Information</h2>
    <table>
        <tr><th>Present Address</th>
            <td><?php echo $student['present_address'] . ", " . $student['present_post'] . ", " . $student['present_block'] . ", " . $student['present_district'] . ", " . $student['present_state']; ?></td>
        </tr>
        <tr><th>Permanent Address</th>
            <td><?php echo $student['permanent_address'] . ", " . $student['permanent_post'] . ", " . $student['permanent_block'] . ", " . $student['permanent_district'] . ", " . $student['permanent_state']; ?></td>
        </tr>
        <tr><th>Country</th><td><?php echo $student['country']; ?></td></tr>
    </table>

    <!-- Education Information Section -->
    <h2>Educational Information</h2>
    <table>
        <tr>
            <th>Level</th><th>Board</th><th>Institute</th><th>Marks</th><th>Percentage</th>
        </tr>
        <tr>
            <td>10th</td><td><?php echo $student['board_10th']; ?></td><td><?php echo $student['institute_10th']; ?></td>
            <td><?php echo $student['secure_mark_10th'] . "/" . $student['full_mark_10th']; ?></td><td><?php echo $student['percentage_10th']; ?>%</td>
        </tr>
        <tr>
            <td>Intermediate</td><td><?php echo $student['board_intermediate']; ?></td><td><?php echo $student['institute_intermediate']; ?></td>
            <td><?php echo $student['secure_mark_intermediate'] . "/" . $student['full_mark_intermediate']; ?></td><td><?php echo $student['percentage_intermediate']; ?>%</td>
        </tr>
        <tr>
            <td>Graduation</td><td><?php echo $student['board_graduation']; ?></td><td><?php echo $student['institute_graduation']; ?></td>
            <td><?php echo $student['secure_mark_graduation'] . "/" . $student['full_mark_graduation']; ?></td><td><?php echo $student['percentage_graduation']; ?>%</td>
        </tr>
    </table>

    <h2>Applied Subject</h2>
    <table>
        <tr>
            <th>Stream</th>
            <td>
                <?php
                $stream_query = "SELECT stream_name FROM streams WHERE id = ?";
                $stmt = $conn->prepare($stream_query);
                $stmt->bind_param("i", $student['stream_id']);
                $stmt->execute();
                $stream_result = $stmt->get_result();
                $stream = $stream_result->fetch_assoc();
                echo $stream['stream_name']; 
                ?>
            </td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>
                <?php
                $subject_query = "SELECT subject_name FROM subjects WHERE id = ?";
                $stmt = $conn->prepare($subject_query);
                $stmt->bind_param("i", $student['subject_id']);
                $stmt->execute();
                $subject_result = $stmt->get_result();
                $subject = $subject_result->fetch_assoc();
                echo $subject['subject_name']; 
                ?>
            </td>
        </tr>
    </table>
</div> <!-- End printable area -->
