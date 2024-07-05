<?php
// Start the session
session_start();

// Check if the user is logged in and is a principal
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Principal') {
    // Redirect to login page if not logged in or if role is incorrect
    header("Location: login.php");
    exit;
}

// Include database connection file
require_once "db_connection.php";

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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e1e7e0;
        }
        .navbar {
            background-color: #2b4560;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            padding: 0 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .logo-container img {
            height: 50px;
            margin-right: 10px;
        }
        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 10px 10px;
            transition: background-color 0.3s ease;
            font-family: Verdana, sans-serif;
            font-weight: bold;
            font-size: 18px;
        }
        .navbar-links a:hover {
            background-color: #ddd;
            color: black;
        }
        .main-content {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 80%;
            margin: auto;
            margin-top: 80px; /* Adjust to account for navbar height */
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        label {
            margin: 10px 0 5px 0;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #2b4560;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #1e2e3b;
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
    <nav class="navbar">
        <div class="logo-container">
            <a href="dashPrincipal.php">
                <img src="image/tahfiz.jpg" alt="Logo">
            </a>
        </div>
        <div class="navbar-links">
            <a href="dashPrincipal.php">HOME</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </nav>
    <div class="main-content">
        <h2>Update Student</h2>
        <form method="post" onsubmit="return validateForm()">
            <label for="studentPass">Student Password:</label>
            <input type="text" id="studentPass" name="studentPass" value="<?php echo htmlspecialchars($studentPass); ?>" required>

            <label for="studentName">Student Name:</label>
            <input type="text" id="studentName" name="studentName" value="<?php echo htmlspecialchars($studentName); ?>" required>

            <label for="studentAge">Student Age:</label>
            <input type="number" id="studentAge" name="studentAge" value="<?php echo htmlspecialchars($studentAge); ?>" required>

            <label for="studentEmail">Student Email:</label>
            <input type="email" id="studentEmail" name="studentEmail" value="<?php echo htmlspecialchars($studentEmail); ?>" required>

            <label for="studentAddress">Student Address:</label>
            <input type="text" id="studentAddress" name="studentAddress" value="<?php echo htmlspecialchars($studentAddress); ?>" required>

            <label for="guardianName">Guardian Name:</label>
            <input type="text" id="guardianName" name="guardianName" value="<?php echo htmlspecialchars($guardianName); ?>" required>

            <label for="guardianContact">Guardian Contact:</label>
            <input type="text" id="guardianContact" name="guardianContact" value="<?php echo htmlspecialchars($guardianContact); ?>" oninput="formatGuardianContact(this)" required>

            <label for="classID">Class ID:</label>
            <input type="text" id="classID" name="classID" value="<?php echo htmlspecialchars($classID); ?>" required>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
