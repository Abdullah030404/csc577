<?php
include_once "instructorHeader.php"; 
require_once "db_connection.php";

// Fetch instructor ID from session
$instructorID = $_SESSION['userID'];

// Prepare and execute SQL query to fetch the class name assigned to the instructor
$classQuery = "
    SELECT className
    FROM class
    WHERE staffID = ?
";
$stmt = $conn->prepare($classQuery);
$stmt->bind_param("s", $instructorID);
$stmt->execute();
$classResult = $stmt->get_result();
$className = "";
if ($classResult->num_rows > 0) {
    $classNameRow = $classResult->fetch_assoc();
    $className = $classNameRow['className'];
}
$stmt->close();

// Prepare and execute SQL query to fetch students under the instructor's class
$studentQuery = "
    SELECT s.studentIC, s.studentName, s.studentAge, s.studentEmail, s.studentAddress, s.guardianName, s.guardianContact, c.className
    FROM student s
    JOIN class c ON s.classID = c.classID
    WHERE c.staffID = ?
";
$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("s", $instructorID);
$stmt->execute();
$result = $stmt->get_result();

// Fetch student data
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
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
    <title><?php echo htmlspecialchars($className); ?> - Student List</title>
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

        .student-list-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: var(--secondary-color);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .student-list-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
        }

        .student-list-content {
            padding: 2rem;
        }

        .student-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem;
        }

        .student-table th,
        .student-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .student-table th {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .student-table tr:last-child td {
            border-bottom: none;
        }

        .student-table tbody tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.3s ease;
        }

        .student-table th:first-child,
        .student-table td:first-child {
            border-top-left-radius: var(--border-radius);
            border-bottom-left-radius: var(--border-radius);
        }

        .student-table th:last-child,
        .student-table td:last-child {
            border-top-right-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }

        @media (max-width: 1024px) {
            .student-list-container {
                width: 90%;
                margin: 1rem auto;
            }

            .student-table {
                font-size: 0.9em;
            }

            .student-table th,
            .student-table td {
                padding: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .student-table {
                font-size: 0.8em;
            }

            .student-table th,
            .student-table td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="student-list-container">
        <div class="student-list-header">
            <h2>STUDENT LIST</h2>
        </div>
        <div class="student-list-content">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Student IC</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Guardian Name</th>
                        <th>Guardian Contact</th>
                        <th>Class Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['studentIC']); ?></td>
                            <td><?php echo htmlspecialchars($student['studentName']); ?></td>
                            <td><?php echo htmlspecialchars($student['studentAge']); ?></td>
                            <td><?php echo htmlspecialchars($student['studentEmail']); ?></td>
                            <td><?php echo htmlspecialchars($student['studentAddress']); ?></td>
                            <td><?php echo htmlspecialchars($student['guardianName']); ?></td>
                            <td><?php echo htmlspecialchars($student['guardianContact']); ?></td>
                            <td><?php echo htmlspecialchars($student['className']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
