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
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --border-radius: 12px;
            --background-color: #f0f4f8;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .reports-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .reports-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
        }

        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .report-card {
            background-color: var(--secondary-color);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .report-card h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5em;
        }

        .report-card p {
            color: var(--text-color);
            margin-bottom: 1.5rem;
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
            display: inline-block;
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
    </style>
</head>
<body>
    <div class="reports-container">
        <div class="reports-header">
            <h2>Principal Reports</h2>
        </div>
        <div class="reports-grid">
            <div class="report-card">
                <h2>Class Information</h2>
                <p>View detailed information about all classes, including class sizes, and instructor assigned.</p>
                <a href="reportClassInformation.php" class="btn btn-primary">View Report</a>
            </div>
            <div class="report-card">
                <h2>Staff Information</h2>
                <p>Access comprehensive staff profiles, including qualifications, and responsibilities, </p>
                <a href="reportStaffInformation.php" class="btn btn-primary">View Report</a>
            </div>
            <div class="report-card">
                <h2>Current Student Information</h2>
                <p>Review student data, including personal information,guardian contact and class joined.</p>
                <a href="reportStudentInformation.php" class="btn btn-primary">View Report</a>
            </div>
            <div class="report-card">
                <h2>Former Student Information</h2>
                <p>Review student data, including personal information,guardian contact.</p>
                <a href="reportFormerStudent.php" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
</body>
</html>