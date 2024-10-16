<?php
session_start();
include('../db/db_connect.php'); // Include your database connection file
// Fetch all streams from the database
$stream_query = "SELECT * FROM streams";
$stream_result = $conn->query($stream_query);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission (Add your database insert logic here)
	print_r($_POST);
    // Example database insertion (replace with your actual logic)
    // Assuming your database table is named 'students' and has columns corresponding to the form fields
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
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
    $stream_id = isset($_POST['stream_id']) ? intval($_POST['stream_id']) : null;
    $subject_id = isset($_POST['subject_id']) ? intval($_POST['subject_id']) : null;
	if ($stream_id === null || $subject_id === null) {
        echo "Error: Please select a stream and subject.";
        exit(); 
    } else {

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO students (name, father_name, mother_name, mobile, email, password, gender, caste, religion, present_address, present_post, present_block, present_district, present_state, permanent_address, permanent_post, permanent_block, permanent_district, permanent_state, board_10th, institute_10th, secure_mark_10th, full_mark_10th, percentage_10th, board_intermediate, institute_intermediate, secure_mark_intermediate, full_mark_intermediate, percentage_intermediate, board_graduation, institute_graduation, secure_mark_graduation, full_mark_graduation, percentage_graduation, stream_id, subject_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssssssssssssssssssssssssssssssss", $name, $father_name, $mother_name, $mobile, $email, $password, $gender, $caste, $religion, $present_address, $present_post, $present_block, $present_district, $present_state, $permanent_address, $permanent_post, $permanent_block, $permanent_district, $permanent_state, $board_10th, $institute_10th, $secure_mark_10th, $full_mark_10th, $percentage_10th, $board_intermediate, $institute_intermediate, $secure_mark_intermediate, $full_mark_intermediate, $percentage_intermediate, $board_graduation, $institute_graduation, $secure_mark_graduation, $full_mark_graduation, $percentage_graduation, $stream_id, $subject_id);
	}
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registration completed successfully!";
        header('Location: success.php'); // Redirect to success page
        exit();
    } else {
        // Handle database insertion error
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
    <script>
        // JavaScript function to automatically fill in permanent address
        function fillPermanentAddress() {
            if (document.getElementById('same_address').checked) {
                document.getElementById('permanent_address').value = document.getElementById('present_address').value;
                document.getElementById('permanent_post').value = document.getElementById('present_post').value;
                document.getElementById('permanent_block').value = document.getElementById('present_block').value;
                document.getElementById('permanent_district').value = document.getElementById('present_district').value;
                document.getElementById('permanent_state').value = document.getElementById('present_state').value;
            } else {
                document.getElementById('permanent_address').value = '';
                document.getElementById('permanent_post').value = '';
                document.getElementById('permanent_block').value = '';
                document.getElementById('permanent_district').value = '';
                document.getElementById('permanent_state').value = '';
            }
        }

        function fetchSubjects(streamId) {
            // Fetch subjects based on the selected stream
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_subjects.php?stream_id=' + streamId, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const subjects = JSON.parse(this.responseText);
                    let options = '<option value="">Select Subject</option>';
                    subjects.forEach(subject => {
                        options += `<option value="${subject.id}">${subject.subject_name}</option>`;
                    });
                    document.getElementById('subject').innerHTML = options;
                }
            }
            xhr.send();
        }
		
		
		document.addEventListener("input", function(e) {
    if (e.target.matches("input[name='secure_mark_10th'], input[name='full_mark_10th']")) {
        calculatePercentage('secure_mark_10th', 'full_mark_10th', 'percentage_10th');
    }
    if (e.target.matches("input[name='secure_mark_intermediate'], input[name='full_mark_intermediate']")) {
        calculatePercentage('secure_mark_intermediate', 'full_mark_intermediate', 'percentage_intermediate');
    }
    if (e.target.matches("input[name='secure_mark_graduation'], input[name='full_mark_graduation']")) {
        calculatePercentage('secure_mark_graduation', 'full_mark_graduation', 'percentage_graduation');
    }
});

function calculatePercentage(secureMarkName, fullMarkName, percentageName) {
    const secureMark = parseFloat(document.querySelector(`input[name='${secureMarkName}']`).value) || 0;
    const fullMark = parseFloat(document.querySelector(`input[name='${fullMarkName}']`).value) || 0;
    
    const percentage = fullMark ? (secureMark / fullMark) * 100 : 0;
    document.querySelector(`input[name='${percentageName}']`).value = percentage.toFixed(2);
}

    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 70%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }


        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 15%;
        }

        
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Registration Form</h1>
        <form method="POST" action="">
            <fieldset>
                <legend>Personal Information</legend>
                <table>
                    <tr>
                        <td><label>Name:</label></td>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td><label>Father Name:</label></td>
                        <td><input type="text" name="father_name" required></td>
                    </tr>
                    <tr>
                        <td><label>Mother Name:</label></td>
                        <td><input type="text" name="mother_name" required></td>
                    </tr>
                    <tr>
                        <td><label>Mobile Number:</label></td>
                        <td><input type="number" name="mobile" required></td>
                    </tr>
                    <tr>
                        <td><label>Email:</label></td>
                        <td><input type="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td><label>Password:</label></td>
                        <td><input type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td><label>Gender:</label></td>
                        <td>
                            <select name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Caste:</label></td>
                        <td>
                            <select name="caste" required>
                                <option value="GENERAL">GENERAL</option>
                                <option value="OBC">OBC</option>
                                <option value="SC">SC</option>
								<option value="ST">ST</option>
                            </select>
                        </td>
                    </tr>
					<tr>
                        <td><label>Religion:</label></td>
                        <td>
                            <select name="religion" required>
                                <option value="Hindu">Hindu</option>
                                <option value="Christian">Christian</option>
                                <option value="Muslim">Muslim</option>
								<option value="Sikh">Sikh</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <fieldset>
                <legend>Address Information</legend>
                <h3>Present Address</h3>
                <table>
                    <tr>
                        <td><label>At:</label></td>
                        <td><input type="text" id="present_address" name="present_address" required></td>
                    </tr>
                    <tr>
                        <td><label>Post:</label></td>
                        <td><input type="text" id="present_post" name="present_post" required></td>
                    </tr>
                    <tr>
                        <td><label>Block/Town:</label></td>
                        <td><input type="text" id="present_block" name="present_block" required></td>
                    </tr>
                    <tr>
                        <td><label>District:</label></td>
                        <td><input type="text" id="present_district" name="present_district" required></td>
                    </tr>
                    <tr>
                        <td><label>State:</label></td>
                        <td>
                            <select id="present_state" name="present_state" required>
                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                        <option value="Daman and Diu">Daman and Diu</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Puducherry">Puducherry</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Country:</label></td>
                        <td><input type="text" name="country" value="India" readonly></td>
                    </tr>
                </table>

                <h3>Permanent Address</h3>
                <input type="checkbox" id="same_address" onclick="fillPermanentAddress()"> Same as Present Address
                <table>
                    <tr>
                        <td><label>At:</label></td>
                        <td><input type="text" id="permanent_address" name="permanent_address" required></td>
                    </tr>
                    <tr>
                        <td><label>Post:</label></td>
                        <td><input type="text" id="permanent_post" name="permanent_post" required></td>
                    </tr>
                    <tr>
                        <td><label>Block/Town:</label></td>
                        <td><input type="text" id="permanent_block" name="permanent_block" required></td>
                    </tr>
                    <tr>
                        <td><label>District:</label></td>
                        <td><input type="text" id="permanent_district" name="permanent_district" required></td>
                    </tr>
                    <tr>
                        <td><label>State:</label></td>
                        <td>
                            <select id="permanent_state" name="permanent_state" required>
                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                        <option value="Daman and Diu">Daman and Diu</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Puducherry">Puducherry</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Country:</label></td>
                        <td><input type="text" name="country" value="India" readonly></td>
                    </tr>
                </table>
            </fieldset>

            <fieldset>
                <h2>Educational Qualification</h2>
        <table align="center">
            <tr>
                <th>Class</th>
                <th>Board</th>
                <th>Institute Name</th>
                <th>Secure Mark</th>
                <th>Full Mark</th>
                <th>Percentage</th>
            </tr>
            <tr>
                <td>10th</td>
                <td><input type="text" name="board_10th" required></td>
                <td><input type="text" name="institute_10th" required></td>
                <td><input type="number" name="secure_mark_10th" required></td>
                <td><input type="number" name="full_mark_10th" required></td>
                <td><input type="text" name="percentage_10th" readonly></td>
            </tr>
            <tr>
                <td>Intermediate</td>
                <td><input type="text" name="board_intermediate" required></td>
                <td><input type="text" name="institute_intermediate" required></td>
                <td><input type="number" name="secure_mark_intermediate" required></td>
                <td><input type="number" name="full_mark_intermediate" required></td>
                <td><input type="text" name="percentage_intermediate" readonly></td>
            </tr>
            <tr>
                <td>Graduation</td>
                <td><input type="text" name="board_graduation" required></td>
                <td><input type="text" name="institute_graduation" required></td>
                <td><input type="number" name="secure_mark_graduation" required></td>
                <td><input type="number" name="full_mark_graduation" required></td>
                <td><input type="text" name="percentage_graduation" readonly></td>
            </tr>
        </table>
            </fieldset>

            <fieldset>
                <legend>Subject Apply</legend>
                <table>
                    <tr>
                        <td><label>Choose Stream:</label></td>
            <td>
                <select id="stream" name="stream_id" required onchange="fetchSubjects(this.value)"> 
                    <option value="">Select Stream</option>
                    <?php if ($stream_result->num_rows > 0): ?>
                        <?php while ($row = $stream_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['stream_name']; ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </td>
                    </tr>
                    <tr>
            <td><label>Select Subject:</label></td>
            <td>
                <select id="subject" name="subject_id" required>
                    <option value="">Select Subject</option>
                </select>
            </td>
        </tr>
                </table>
            </fieldset>

            <input type="submit" value="Register">
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your College Name. All rights reserved.</p>
    </footer>
</body>
</html>
