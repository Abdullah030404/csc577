<?php
include_once "stuHeader.php";

// Initialize success flag
$updateSuccess = false;

// Fetch student details from database based on session variable
$studentIC = $_SESSION['userID'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated student details from the form
    $studentName = $_POST['studentName'];
    $studentAge = $_POST['studentAge'];
    $studentEmail = $_POST['studentEmail'];
    $studentAddress = $_POST['studentAddress'];
    $guardianName = $_POST['guardianName'];
    $guardianContact = $_POST['guardianContact'];

    // Prepare and execute SQL query to update student details
    $stmt = $conn->prepare("
        UPDATE student 
        SET studentName = ?, studentAge = ?, studentEmail = ?, studentAddress = ?, guardianName = ?, guardianContact = ?
        WHERE studentIC = ?
    ");
    $stmt->bind_param("sisssss", $studentName, $studentAge, $studentEmail, $studentAddress, $guardianName, $guardianContact, $studentIC);

    if ($stmt->execute()) {
        // Set success flag to true
        $updateSuccess = true;
        // Redirect to profile page after successful update
        // header("Location: stuProfile.php");
        // exit;
    } else {
        // Handle error if update fails
        echo "Error: Could not update student details.";
    }

    // Close prepared statement
    $stmt->close();
}

// Fetch student details from database
$stmt = $conn->prepare("
    SELECT s.*, c.className, st.staffName as mentorName 
    FROM student s
    JOIN class c ON s.classID = c.classID
    JOIN staff st ON c.staffID = st.staffID
    WHERE s.studentIC = ?
");
$stmt->bind_param("s", $studentIC);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows === 1) {
    // Fetch student details
    $row = $result->fetch_assoc();
    $studentName = $row['studentName'];
    $studentAge = $row['studentAge'];
    $studentEmail = $row['studentEmail'];
    $studentAddress = $row['studentAddress'];
    $guardianName = $row['guardianName'];
    $guardianContact = $row['guardianContact'];
    $className = $row['className'];
    $mentorName = $row['mentorName'];
} else {
    // Redirect or handle error if student not found
    echo "Error: Student not found.";
    exit;
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Profile</title>
    <style>
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --border-radius: 12px;
            --background-color: #f0f4f8;
        }

        .update-container {
            max-width: 900px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .update-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .update-content {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-size: 0.9em;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(43, 69, 96, 0.2);
        }

        .form-control[readonly] {
            background-color: var(--background-color);
            cursor: not-allowed;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1em;
            cursor: pointer;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--secondary-color);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-primary:hover {
            background-color: #ff4757;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        @media (max-width: 768px) {
            .update-container {
                width: 90%;
                margin: 1rem auto;
            }
        }
    </style>
    <script>
        function validateForm() {
            // Get the values of the inputs
            var studentName = document.getElementsByName('studentName')[0].value;
            var guardianName = document.getElementsByName('guardianName')[0].value;
            var mentorName = document.getElementsByName('mentorName')[0].value;
            var guardianContact = document.getElementsByName('guardianContact')[0].value;

            // Validate student name, guardian name, and mentor name: only letters and spaces
            var namePattern = /^[A-Za-z\s]+$/;
            if (!namePattern.test(studentName)) {
                alert('Student name can only contain letters and spaces.');
                return false;
            }
            if (!namePattern.test(guardianName)) {
                alert('Guardian name can only contain letters and spaces.');
                return false;
            }
            if (!namePattern.test(mentorName)) {
                alert('Mentor name can only contain letters and spaces.');
                return false;
            }

            // Validate guardian contact: 01#-#######
            var contactPattern = /^01\d-\d{7}$/;
            if (!contactPattern.test(guardianContact)) {
                alert('Guardian contact must follow the format 01#-#######.');
                return false;
            }

            // If all validations pass
            return true;
        }

        window.onload = function() {
            // Check if updateSuccess flag is set in PHP
            <?php if ($updateSuccess): ?>
                alert('Data has been updated');
                // Redirect to profile page after showing the alert
                window.location.href = 'stuProfile.php';
            <?php endif; ?>
        };
    </script>
</head>

<body>
    <div class="update-container">
        <div class="update-header">
            <h2>Update Student Profile</h2>
        </div>
        <div class="update-content">
            <form action="stuUpdate.php" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label>Student IC Number</label>
                    <input type="text" name="studentIC" class="form-control"
                        value="<?php echo htmlspecialchars($studentIC); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Student Name</label>
                    <input type="text" name="studentName" class="form-control"
                        value="<?php echo htmlspecialchars($studentName); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Student Age</label>
                    <input type="number" name="studentAge" class="form-control"
                        value="<?php echo htmlspecialchars($studentAge); ?>" required>
                </div>
                <div class="form-group">
                    <label>Student Email</label>
                    <input type="email" name="studentEmail" class="form-control"
                        value="<?php echo htmlspecialchars($studentEmail); ?>" required>
                </div>
                <div class="form-group">
                    <label>Student Address</label>
                    <input type="text" name="studentAddress" class="form-control"
                        value="<?php echo htmlspecialchars($studentAddress); ?>" required>
                </div>
                <div class="form-group">
                    <label>Guardian Name</label>
                    <input type="text" name="guardianName" class="form-control"
                        value="<?php echo htmlspecialchars($guardianName); ?>" pattern="[A-Za-z\s]+"
                        title="Only letters and spaces are allowed" required>
                </div>
                <div class="form-group">
                    <label>Guardian Contact</label>
                    <input type="text" name="guardianContact" class="form-control"
                        value="<?php echo htmlspecialchars($guardianContact); ?>" pattern="01\d-\d{7}"
                        title="Format: 01#-#######" required>
                </div>
                <div class="form-group">
                    <label>Class Name</label>
                    <input type="text" name="className" class="form-control"
                        value="<?php echo htmlspecialchars($className); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Mentor Name</label>
                    <input type="text" name="mentorName" class="form-control"
                        value="<?php echo htmlspecialchars($mentorName); ?>" pattern="[A-Za-z\s]+"
                        title="Only letters and spaces are allowed" readonly>
                </div>
                <div class="btn-container">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <a href="stuProfile.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
