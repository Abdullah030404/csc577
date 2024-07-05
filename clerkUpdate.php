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

// Close prepared statement (no need to close connection here)
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
        echo "Error: Could not update clerk details.";
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e1e7e0;
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
        .form-control {
            padding: 7px 12px;
            margin-bottom: 0;
            line-height: 1.5;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            width: 100%;
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
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="page-header">
            <h1>Update Clerk Details</h1>
        </div>
        <form action="clerkUpdate.php" method="post">
            <div class="form-group">
                <label for="staffID">Staff ID</label>
                <input type="text" id="staffID" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="staffName">Staff Name</label>
                <input type="text" id="staffName" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>" required>
            </div>
            <div class="form-group">
                <label for="staffEmail">Staff Email</label>
                <input type="email" id="staffEmail" name="staffEmail" value="<?php echo htmlspecialchars($staffEmail); ?>" required>
            </div>
            <div class="form-group">
                <label for="staffContact">Staff Contact</label>
                <input type="text" id="staffContact" name="staffContact" value="<?php echo htmlspecialchars($staffContact); ?>" required>
            </div>
            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($qualification); ?>" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="clerkProfile.php" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
