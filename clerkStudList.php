<?php
include_once "clerkHeader.php"; 

// Fetch all student data from the database
$query = "
    SELECT studentIC, studentPass, studentName, studentAge, studentEmail, studentAddress, guardianName, guardianContact, classID
    FROM student
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e1e7e0;
        }
        
        .main-content {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 80%;
            margin: auto;
            margin-top: 80px; /* Adjust to account for navbar height */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2b4560;
            color: white;
        }
        .action-link {
            color: #2b4560;
            text-decoration: none;
            font-weight: bold;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="main-content">
        <h2>Student List</h2>
        <table>
            <tr>
                <th>Student IC</th>
                <th>Student Pass</th>
                <th>Student Name</th>
                <th>Student Age</th>
                <th>Student Email</th>
                <th>Student Address</th>
                <th>Guardian Name</th>
                <th>Guardian Contact</th>
                <th>Class ID</th>
                <th>Action</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['studentIC']); ?></td>
                    <td><?php echo htmlspecialchars($student['studentPass']); ?></td>
                    <td><?php echo htmlspecialchars($student['studentName']); ?></td>
                    <td><?php echo htmlspecialchars($student['studentAge']); ?></td>
                    <td><?php echo htmlspecialchars($student['studentEmail']); ?></td>
                    <td><?php echo htmlspecialchars($student['studentAddress']); ?></td>
                    <td><?php echo htmlspecialchars($student['guardianName']); ?></td>
                    <td><?php echo htmlspecialchars($student['guardianContact']); ?></td>
                    <td><?php echo htmlspecialchars($student['classID']); ?></td>
                    <td><a class="action-link" href="clerkUpdateStud.php?studentIC=<?php echo htmlspecialchars($student['studentIC']); ?>">Update</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>