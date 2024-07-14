<?php
// Include the database connection file
include_once "universalHeader.php";

$success = false; // Flag to track success

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $studentIC = $_POST['studentIC'];
    $studentName = $_POST['studentName'];
    $studentPass = $_POST['studentPass'];
    $studentAge = $_POST['studentAge'];
    $studentEmail = $_POST['studentEmail'];
    $studentAddress = $_POST['studentAddress'];
    $guardianName = $_POST['guardianName'];
    $guardianContact = $_POST['guardianContact'];

    try {
        // Fetch all available classes
        $classQuery = "SELECT classID FROM class WHERE (SELECT COUNT(*) FROM student WHERE student.classID = class.classID) < class.classCount";
        $classResult = $conn->query($classQuery);

        if ($classResult->num_rows > 0) {
            // Store all available classes in an array
            $availableClasses = [];
            while ($row = $classResult->fetch_assoc()) {
                $availableClasses[] = $row['classID'];
            }

            // Randomly select a class
            $randomClassIndex = array_rand($availableClasses);
            $classID = $availableClasses[$randomClassIndex];

            // Check if the studentIC and studentName exist in registered_students
            $checkQuery = "SELECT * FROM registered_students WHERE studentIC = ? AND studentName = ?";
            if ($checkStmt = $conn->prepare($checkQuery)) {
                $checkStmt->bind_param("ss", $studentIC, $studentName);
                $checkStmt->execute();
                $result = $checkStmt->get_result();

                if ($result->num_rows > 0) {
                    // If studentIC and studentName match, proceed with registration
                    $sql = "INSERT INTO student (studentIC, studentName, studentPass, studentAge, studentEmail, studentAddress, guardianName, guardianContact, classID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("sssissssi", $studentIC, $studentName, $studentPass, $studentAge, $studentEmail, $studentAddress, $guardianName, $guardianContact, $classID);

                        if ($stmt->execute()) {
                            $success = true; // Set success flag to true
                        } else {
                            throw new mysqli_sql_exception($conn->error);
                        }
                    } else {
                        throw new mysqli_sql_exception($conn->error);
                    }
                } else {
                    $error_message = "ERROR: Student IC and Name do not match records. Please check your details.";
                }

                $checkStmt->close();
            } else {
                throw new mysqli_sql_exception($conn->error);
            }
        } else {
            $error_message = "ERROR: No available classes. All classes are full.";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Duplicate entry error code
            $error_message = "Cannot register because account has already been created.";
        } else {
            $error_message = "ERROR: " . $e->getMessage();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Maahad Tahfiz As Syifa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary-color: #1a3a63;
            --secondary-color: #ffffff;
            --accent-color: #ffd700;
            --background-color: #f0f4f8;
            --text-color: #333;
            --error-color: #ff6b6b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
            color: var(--text-color);
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            margin-top: 80px;
            width: 600px;
            margin: auto;
            padding: 10px;
            margin-top: 50px;
        }

        .form-container {
            background-color: var(--secondary-color);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
        }

        .button-register {
            margin-top: 1.5rem;
        }

        .button-register button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button-register button:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .account {
            margin-top: 1rem;
        }

        .account a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .account a:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
    </style>
    <script>
        // JavaScript for additional validation
        function validateForm() {
            // Validate studentName
            var studentName = document.getElementById('studentName').value;
            var namePattern = /^[A-Za-z\s]+$/;
            if (!namePattern.test(studentName)) {
                alert('Student Name can only contain alphabets.');
                return false;
            }

            // Validate studentPass
            var studentPass = document.getElementById('studentPass').value;
            if (studentPass.length < 6) {
                alert('Student Password must be at least 6 characters long.');
                return false;
            }

            // Validate guardianName
            var guardianName = document.getElementById('guardianName').value;
            if (!namePattern.test(guardianName)) {
                alert('Guardian Name can only contain alphabets.');
                return false;
            }

            // Validate guardianContact
            var guardianContact = document.getElementById('guardianContact').value;
            var contactPattern = /^01\d-\d{7}$/;
            if (!contactPattern.test(guardianContact)) {
                alert('Guardian Contact must be in the format 01#-#######.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Student Registration</h2>
            <form action="register.php" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="studentIC">Student IC</label>
                    <input type="text" id="studentIC" name="studentIC" maxlength="12" required>
                </div>
                <div class="form-group">
                    <label for="studentName">Student Name</label>
                    <input type="text" id="studentName" name="studentName" pattern="[A-Za-z\s]+" title="Student Name can only contain alphabets." required>
                </div>
                <div class="form-group">
                    <label for="studentPass">Student Password</label>
                    <input type="password" id="studentPass" name="studentPass" minlength="6" title="Password must be at least 6 characters long." required>
                </div>
                <div class="form-group">
                    <label for="studentAge">Student Age</label>
                    <input type="number" id="studentAge" name="studentAge" required>
                </div>
                <div class="form-group">
                    <label for="studentEmail">Student Email</label>
                    <input type="email" id="studentEmail" name="studentEmail" required>
                </div>
                <div class="form-group">
                    <label for="studentAddress">Student Address</label>
                    <input type="text" id="studentAddress" name="studentAddress" required>
                </div>
                <div class="form-group">
                    <label for="guardianName">Guardian Name</label>
                    <input type="text" id="guardianName" name="guardianName" pattern="[A-Za-z\s]+" title="Guardian Name can only contain alphabets." required>
                </div>
                <div class="form-group">
                    <label for="guardianContact">Guardian Contact</label>
                    <input type="text" id="guardianContact" name="guardianContact" pattern="01\d-\d{7}" title="Guardian Contact must be in the format 01#-#######." maxlength="11" required>
                </div>
                <div class="button-register">
                    <button type="submit">Register</button>
                </div>
                <div class="account">
                    Already have an account? <a href="login.php">Login</a>
                </div>
            </form>
            <?php if (isset($error_message)) { ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
                <div class="success-message">Student registered successfully!</div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
