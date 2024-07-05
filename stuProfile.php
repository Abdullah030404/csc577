<?php
// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Student') {
    // Redirect to login page if not logged in or role is incorrect
    header("Location: login.php");
    exit;
}

// Include database connection file
require_once "db_connection.php";

// Fetch student details from database based on session variable
$studentIC = $_SESSION['userID'];

// Prepare and execute SQL query to retrieve student details and staff name
$stmt = $conn->prepare("
    SELECT s.*, c.className, st.staffName 
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
    $staffName = $row['staffName'];
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
    <title>Student Profile</title>
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
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .logo-container img {
            height: 50px; /* Adjust the height as needed */
            margin-right: 10px; /* Adjust the spacing as needed */
        }
        .navbar-links {
            display: flex;
            align-items: center;
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
        .wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control-static {
            padding: 7px 12px;
            margin-bottom: 0;
            line-height: 1.5;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }
        .btn-container {
            display: flex;
            gap: 10px; /* Space between the buttons */
            margin-top: 20px; /* Adjust as needed */
            justify-content: center;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo-container">
            <a href="index.html">
                <img src="image/tahfiz.jpg" alt="Logo">
            </a>
        </div>
        <div class="navbar-links">
            <a href="dashStu.php">HOME</a>
            <a href="stuProfile.php">PROFILE</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </nav>
    <div class="wrapper">
        <div class="page-header">
            <h1>View Student Profile</h1>
        </div>
        <div class="form-group">
            <label>Student IC</label>
            <p class="form-control-static"><?php echo htmlspecialchars($studentIC); ?></p>
        </div>
        <div class="form-group">
            <label>Student Name</label>
            <p class="form-control-static"><?php echo htmlspecialchars($studentName); ?></p>
        </div>
        <div class="form-group">
            <label>Student Age</label>
            <p class="form-control-static"><?php echo htmlspecialchars($studentAge); ?></p>
        </div>
        <div class="form-group">
            <label>Student Email</label>
            <p class="form-control-static"><?php echo htmlspecialchars($studentEmail); ?></p>
        </div>
        <div class="form-group">
            <label>Student Address</label>
            <p class="form-control-static"><?php echo htmlspecialchars($studentAddress); ?></p>
        </div>
        <div class="form-group">
            <label>Guardian Name</label>
            <p class="form-control-static"><?php echo htmlspecialchars($guardianName); ?></p>
        </div>
        <div class="form-group">
            <label>Guardian Contact</label>
            <p class="form-control-static"><?php echo htmlspecialchars($guardianContact); ?></p>
        </div>
        <div class="form-group">
            <label>Class Name</label>
            <p class="form-control-static"><?php echo htmlspecialchars($className); ?></p>
        </div>
        <div class="form-group">
            <label>Mentor Name</label>
            <p class="form-control-static"><?php echo htmlspecialchars($staffName); ?></p>
        </div>
        <div class="btn-container">
            <a href="stuUpdate.php" class="btn btn-primary">Update</a>
        </div>
    </div>
</body>
</html>
