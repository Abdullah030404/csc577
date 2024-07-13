<?php
include_once "principalHeader.php"; 
require_once "db_connection.php"; // Include database connection

// Initialize variables
$studentIC = "";
$studentPass = "";
$studentName = "";
$studentAge = "";
$studentEmail = "";
$studentAddress = "";
$guardianName = "";
$guardianContact = "";
$classID = "";

// Fetch all classes from the database
$classQuery = "SELECT classID, className FROM class";
$classResult = $conn->query($classQuery);
$classes = [];
while ($classRow = $classResult->fetch_assoc()) {
    $classes[] = $classRow;
}

// Check if studentIC is set in the URL
if (isset($_GET['studentIC'])) {
    $studentIC = $_GET['studentIC'];

    // Fetch the student data from the database
    $query = "
        SELECT studentIC, studentPass, studentName, studentAge, studentEmail, studentAddress, guardianName, guardianContact, classID
        FROM student
        WHERE studentIC = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $studentIC);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the student exists
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $studentPass = $student['studentPass'];
        $studentName = $student['studentName'];
        $studentAge = $student['studentAge'];
        $studentEmail = $student['studentEmail'];
        $studentAddress = $student['studentAddress'];
        $guardianName = $student['guardianName'];
        $guardianContact = $student['guardianContact'];
        $classID = $student['classID'];
    } else {
        // Redirect to the student list if studentIC is invalid
        header("Location: principalStudList.php");
        exit;
    }
} else {
    // Redirect to the student list if studentIC is not set
    header("Location: principalStudList.php");
    exit;
}

// Update the student data in the database
$updateSuccess = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentPass = $_POST['studentPass'];
    $studentName = $_POST['studentName'];
    $studentAge = $_POST['studentAge'];
    $studentEmail = $_POST['studentEmail'];
    $studentAddress = $_POST['studentAddress'];
    $guardianName = $_POST['guardianName'];
    $guardianContact = $_POST['guardianContact'];
    $classID = $_POST['classID'];

    $query = "
        UPDATE student
        SET studentPass = ?, studentName = ?, studentAge = ?, studentEmail = ?, studentAddress = ?, guardianName = ?, guardianContact = ?, classID = ?
        WHERE studentIC = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssissssis", $studentPass, $studentName, $studentAge, $studentEmail, $studentAddress, $guardianName, $guardianContact, $classID, $studentIC);
    if ($stmt->execute()) {
        $updateSuccess = true;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --border-radius: 12px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .profile-content {
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
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            font-size: 1em;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(255, 107, 107, 0.2);
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
            .profile-content {
                padding: 1.5rem;
            }
        }
    </style>
    <script>
        function formatGuardianContact(input) {
            // Remove non-numeric characters from the input value
            var cleaned = input.value.replace(/\D/g, '');

            // Check if the input length is greater than 3, add the dash accordingly
            if (cleaned.length > 3) {
                cleaned = cleaned.substring(0, 3) + '-' + cleaned.substring(3, 10);
            }

            // Update the input value with formatted result
            input.value = cleaned;
        }

        function validateForm() {
            // Validate studentName and guardianName
            var namePattern = /^[A-Za-z@ ]+$/;
            var studentName = document.getElementById("studentName").value;
            var guardianName = document.getElementById("guardianName").value;

            if (!namePattern.test(studentName)) {
                alert("Student name can only contain letters, spaces, or @.");
                return false;
            }

            if (!namePattern.test(guardianName)) {
                alert("Guardian name can only contain letters, spaces, or @.");
                return false;
            }

            // Validate studentPass
            var studentPass = document.getElementById("studentPass").value;
            if (studentPass.length < 6) {
                alert("Student password must be at least 6 characters long.");
                return false;
            }

            // Validate studentAge
            var studentAge = document.getElementById("studentAge").value;
            if (isNaN(studentAge)) {
                alert("Student age must be a number.");
                return false;
            }            

            // Validate guardianContact
            var contactPattern = /^\d{3}-\d{7}$/;
            var guardianContact = document.getElementById("guardianContact").value;

            if (!contactPattern.test(guardianContact)) {
                alert("Guardian contact must be in the form '###-#######'.");
                return false;
            }

            return true;
        }

        <?php if ($updateSuccess): ?>
        alert("Data has been updated.");
        window.location.href = "principalStudList.php";
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Update Student</h2>
        </div>
        <div class="profile-content">
            <form method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="studentPass">Student Password:</label>
                    <input type="text" id="studentPass" name="studentPass" class="form-control" value="<?php echo htmlspecialchars($studentPass); ?>" required>
                </div>

                <div class="form-group">
                    <label for="studentName">Student Name:</label>
                    <input type="text" id="studentName" name="studentName" class="form-control" value="<?php echo htmlspecialchars($studentName); ?>" required>
                </div>

                <div class="form-group">
                    <label for="studentAge">Student Age:</label>
                    <input type="number" id="studentAge" name="studentAge" class="form-control" value="<?php echo htmlspecialchars($studentAge); ?>" required>
                </div>

                <div class="form-group">
                    <label for="studentEmail">Student Email:</label>
                    <input type="email" id="studentEmail" name="studentEmail" class="form-control" value="<?php echo htmlspecialchars($studentEmail); ?>" required>
                </div>

                <div class="form-group">
                    <label for="studentAddress">Student Address:</label>
                    <input type="text" id="studentAddress" name="studentAddress" class="form-control" value="<?php echo htmlspecialchars($studentAddress); ?>" required>
                </div>

                <div class="form-group">
                    <label for="guardianName">Guardian Name:</label>
                    <input type="text" id="guardianName" name="guardianName" class="form-control" value="<?php echo htmlspecialchars($guardianName); ?>" required>
                </div>

                <div class="form-group">
                    <label for="guardianContact">Guardian Contact:</label>
                    <input type="text" id="guardianContact" name="guardianContact" class="form-control" value="<?php echo htmlspecialchars($guardianContact); ?>" oninput="formatGuardianContact(this)" required>
                </div>

                <div class="form-group">
                    <label for="classID">Class:</label>
                    <select id="classID" name="classID" class="form-control" required>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo htmlspecialchars($class['classID']); ?>" <?php echo $class['classID'] == $classID ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['classID'] . '-' . $class['className']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="btn-container">
                    <input type="submit" value="Update" class="btn btn-primary">
                    <a href="principalStudList.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>