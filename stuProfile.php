<?php
include_once "stuHeader.php";

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
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --border-radius: 12px;
        }

        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .profile-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-size: 0.9em;
            text-transform: uppercase;
        }

        .form-control-static {
            padding: 0.75rem 1rem;
            background-color: #f0f4f8;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1em;
            color: var(--text-color);
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }

        .form-control-static:hover {
            background-color: #e8ecf1;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            padding-bottom: 2rem;
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

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Student Profile</h2>
        </div>
        <div class="profile-content">
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
        </div>
        <div class="btn-container">
            <a href="stuUpdate.php" class="btn btn-primary">Update Profile</a>
        </div>
    </div>
</body>
</html>