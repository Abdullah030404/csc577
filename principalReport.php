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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            background-color: #2b4560;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            width: 250px;
            text-align: center;
            color: white;
        }
        .card h2 {
            margin-bottom: 20px;
            font-size: 20px;
        }
        .card button {
            background-color: #738ca7;
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .card button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Class Information</h2>
            <button onclick="location.href='reportClassInformation.php'">View Report</button>
        </div>
        <div class="card">
            <h2>Staff Information</h2>
            <button onclick="location.href='reportStaffInformation.php'">View Report</button>
        </div>
        <div class="card">
            <h2>Student Information</h2>
            <button onclick="location.href='reportStudentInformation.php'">View Report</button>
        </div>
        <div class="card">
            <h2>Total Students per Class</h2>
            <button onclick="location.href='reportTotalStudentsPerClass.php'">View Report</button>
        </div>
    </div>
</body>
</html>
