<?php
include_once "clerkHeader.php"; 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
$success_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentIC = $_POST['studentIC'];
    $studentName = $_POST['studentName'];

    // Validate studentIC (only numbers, max length 12)
    if (!preg_match('/^\d{12}$/', $studentIC)) {
        die('Invalid student IC format. It should be numeric and exactly 12 characters.');
    }

    // Validate studentName (no numbers allowed)
    if (preg_match('/\d/', $studentName)) {
        die('Invalid student name format. Numbers are not allowed.');
    }

    // Insert into registered_students table
    require_once "db_connection.php"; // Ensure database connection is included
    $stmt = $conn->prepare("INSERT INTO registered_students (studentIC, studentName) VALUES (?, ?)");
    
    // Check for statement preparation errors
    if ($stmt === false) {
        die('Prepare() failed: ' . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("ss", $studentIC, $studentName);
    
    // Execute statement and check for errors
    if ($stmt->execute() === false) {
        die('Execute() failed: ' . htmlspecialchars($stmt->error));
    } else {
        $success_message = 'Student has successfully been registered.';
    }

    $stmt->close();
}

// Fetch data from registered_students table
$query = "SELECT studentIC, studentName FROM registered_students";
$result = $conn->query($query);

// Check for query execution errors
if ($result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

$registered_students = [];
while ($row = $result->fetch_assoc()) {
    $registered_students[] = $row;
}

// Fetch data from student table to check if created
$student_query = "SELECT studentIC FROM student";
$student_result = $conn->query($student_query);

// Check for query execution errors
if ($student_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

$existing_students = [];
while ($row = $student_result->fetch_assoc()) {
    $existing_students[] = $row['studentIC'];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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
            max-width: 900px;
            width: 90%;
            margin: 2rem auto;
        }

        h1, h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
        }

        .form-section {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .form-group {
            width: 100%;
            max-width: 400px;
        }

        label {
            font-size: 1.2rem;
            color: var(--text-color);
            display: block;
            margin-bottom: 0.5rem;
        }

        input {
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            width: 100%;
        }

        button {
            padding: 0.75rem 1.5rem;
            background-color: var(--accent-color);
            color: var(--secondary-color);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 1.2rem;
            transition: background-color 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #ff4757;
        }

        .table-section {
            margin-top: 3rem;
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

        .success-message {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-top: 1rem;
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .main-content {
                width: 95%;
                padding: 1rem;
            }

            .form-section, .table-section {
                padding: 1rem;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Add Student</h1>
        
        <div class="form-section">
            <form method="POST" action="clerkAddStud.php">
                <div class="form-group">
                    <label for="studentIC">Student IC:</label>
                    <input type="text" id="studentIC" name="studentIC" pattern="\d{12}" title="Please enter exactly 12 digits" required>
                </div>
                <div class="form-group">
                    <label for="studentName">Student Name:</label>
                    <input type="text" id="studentName" name="studentName" pattern="[A-Za-z\s]+" title="Please enter letters only" required>
                </div>
                <button type="submit">Add Student</button>
            </form>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <div class="table-section">
            <h2>Registered Students</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student IC</th>
                        <th>Student Name</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registered_students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['studentIC']); ?></td>
                            <td><?php echo htmlspecialchars($student['studentName']); ?></td>
                            <td>
                                <?php echo in_array($student['studentIC'], $existing_students) ? 'Done' : 'Not yet'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>