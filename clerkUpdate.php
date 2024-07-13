<?php
include_once "clerkHeader.php"; // Include header with session check and navigation

// Fetch clerk details from database based on session variable
$staffID = $_SESSION['userID'];

// Initialize variables
$staffName = "";
$staffEmail = "";
$staffContact = "";
$qualification = "";

// Include database connection file
require_once "db_connection.php";

// Fetch clerk data from the database
$query = "
    SELECT staffName, staffEmail, staffContact, qualification
    FROM staff
    WHERE staffID = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $staffID);
$stmt->execute();
$result = $stmt->get_result();

// Check if clerk exists
if ($result->num_rows === 1) {
    // Fetch clerk details
    $row = $result->fetch_assoc();
    $staffName = $row['staffName'];
    $staffEmail = $row['staffEmail'];
    $staffContact = $row['staffContact'];
    $qualification = $row['qualification'];
} else {
    // Redirect or handle error if clerk not found
    echo "Error: Clerk not found.";
    exit;
}

// Close prepared statement
$stmt->close();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated clerk details from the form
    $staffName = $_POST['staffName'];
    $staffEmail = $_POST['staffEmail'];
    $staffContact = $_POST['staffContact'];
    $qualification = $_POST['qualification'];

    // Prepare and execute SQL query to update clerk details
    $updateQuery = "
        UPDATE staff 
        SET staffName = ?, staffEmail = ?, staffContact = ?, qualification = ?
        WHERE staffID = ?
    ";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssss", $staffName, $staffEmail, $staffContact, $qualification, $staffID);

    if ($updateStmt->execute()) {
        // Redirect to profile page after successful update
        header("Location: clerkProfile.php");
        exit;
    } else {
        // Handle error if update fails
        $error_message = "Error: Could not update clerk details.";
    }

    // Close prepared statement
    $updateStmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Clerk Details</title>
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
            background-color: #f0f4f8;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .update-container {
            max-width: 900px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .update-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .update-content {
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

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            font-size: 1em;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(255, 107, 107, 0.2);
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
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

        .btn-secondary {
            background-color: #6c757d;
            color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .update-container {
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="update-container">
        <div class="update-header">
            <h2>Update Clerk Details</h2>
        </div>
        <div class="update-content">
            <form action="clerkUpdate.php" method="post">
                <div class="form-group">
                    <label for="staffID">Staff ID</label>
                    <input type="text" id="staffID" name="staffID" class="form-control" value="<?php echo htmlspecialchars($staffID); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="staffName">Staff Name</label>
                    <input type="text" id="staffName" name="staffName" class="form-control" value="<?php echo htmlspecialchars($staffName); ?>" required>
                </div>
                <div class="form-group">
                    <label for="staffEmail">Staff Email</label>
                    <input type="email" id="staffEmail" name="staffEmail" class="form-control" value="<?php echo htmlspecialchars($staffEmail); ?>" required>
                </div>
                <div class="form-group">
                    <label for="staffContact">Staff Contact</label>
                    <input type="text" id="staffContact" name="staffContact" class="form-control" value="<?php echo htmlspecialchars($staffContact); ?>" required>
                </div>
                <div class="form-group">
                    <label for="qualification">Qualification</label>
                    <input type="text" id="qualification" name="qualification" class="form-control" value="<?php echo htmlspecialchars($qualification); ?>" required>
                </div>
                <?php if (isset($error_message)): ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="clerkProfile.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>