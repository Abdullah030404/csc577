<?php
include_once "principalHeader.php";

// Close prepared statement and database connection

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Reports</title>
</head>
<body>
    <h1>Principal Reports</h1>
    <ul>
        <li><a href="reportClassInformation.php">Class Information</a></li>
        <li><a href="reportStaffInformation.php">Staff Information</a></li>
        <li><a href="reportStudentInformation.php">Student Information</a></li>
        <li><a href="reportTotalStudentsPerClass.php">Total Students per Class</a></li>
    </ul>
</body>
</html>
