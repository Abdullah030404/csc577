<?php
include_once "stuHeader.php"; 

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
        // Redirect to profile page after successful update
        header("Location: stuProfile.php");
        exit;
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e1e7e0;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        
        .main-content {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px; /* Maximum width for the container */
            width: 50%;
            margin: auto;
            margin-top: 200px;
        }
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-control[readonly] {
            background-color: #e9ecef;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="page-header">
            <h2>Update Student Profile</h2>
        </div>
        <form action="stuUpdate.php" method="post">
            <div class="form-group">
                <label>Student IC Number</label>
                <input type="text" name="studentIC" class="form-control" value="<?php echo htmlspecialchars($studentIC); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Student Name</label>
                <input type="text" name="studentName" class="form-control" value="<?php echo htmlspecialchars($studentName); ?>">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Student Age</label>
                <input type="text" name="studentAge" class="form-control" value="<?php echo htmlspecialchars($studentAge); ?>">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Student Email</label>
                <input type="text" name="studentEmail" class="form-control" value="<?php echo htmlspecialchars($studentEmail); ?>">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Student Address</label>
                <input type="text" name="studentAddress" class="form-control" value="<?php echo htmlspecialchars($studentAddress); ?>">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Guardian Name</label>
                <input type="text" name="guardianName" class="form-control" value="<?php echo htmlspecialchars($guardianName); ?>">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Guardian Contact</label>
                <input type="text" name="guardianContact" class="form-control" value="<?php echo htmlspecialchars($guardianContact); ?>">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Class Name</label>
                <input type="text" name="className" class="form-control" value="<?php echo htmlspecialchars($className); ?>" readonly>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Mentor Name</label>
                <input type="text" name="mentorName" class="form-control" value="<?php echo htmlspecialchars($mentorName); ?>" readonly>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="stuProfile.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
