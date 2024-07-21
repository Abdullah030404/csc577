<?php
include_once "clerkHeader.php"; 
require_once "db_connection.php"; // Ensure database connection is included

// Fetch all student data along with class names from the database
$query = "
    SELECT s.studentIC, s.studentPass, s.studentName, s.studentAge, s.studentEmail, s.studentAddress, s.guardianName, s.guardianContact, c.className
    FROM student s
    JOIN class c ON s.classID = c.classID
    WHERE s.status like 'A'
    ORDER BY c.classID
";
$result = $conn->query($query);

// Fetch student data
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
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
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
        }
        
        .main-content {
            background-color: var(--secondary-color);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 1300px;
            width: 90%;
            margin: 2rem auto;
        }
        .page-header {
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
        .add-student-btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--accent-color);
            color: var(--secondary-color);
            text-decoration: none;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .add-student-btn:hover {
            background-color: #ff4757; /* Change background color on hover */
            transform: translateY(-2px); /* Lift the button slightly */
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .action-link {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .action-link:hover {
            color: #ff4757; /* Change text color on hover */
            transform: translateY(-2px); /* Lift the link slightly */
        }


        @media (max-width: 1024px) {
            .main-content {
                width: 95%;
                padding: 1rem;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
    <div class="page-header">
            <h1>STUDENT LIST</h1>
        </div>
        <a href="clerkAddStud.php" class="add-student-btn">Add Student</a>
        <div style="overflow-x: auto;">
            <table>
                <tr>
                    <th>Student IC</th>
                    <th>Student Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Guardian Name</th>
                    <th>Guardian Contact</th>
                    <th>Class Name</th>
                    <th>Action</th>
                </tr>
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
                        <td>
                        <a class="action-link" href="clerkUpdateStud.php?studentIC=<?php echo htmlspecialchars($student['studentIC']); ?>">Update</a>  
                        <a class="action-link" href="clerkDeleteStud.php?studentIC=<?php echo htmlspecialchars($student['studentIC']); ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
