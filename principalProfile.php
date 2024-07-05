<?php
include_once "principalHeader.php";

// Fetch clerk details from database based on session variable
$staffID = $_SESSION['userID'];

// Prepare and execute SQL query to retrieve clerk details
$stmt = $conn->prepare("
    SELECT *
    FROM staff
    WHERE staffID = ?
");
$stmt->bind_param("s", $staffID);
$stmt->execute();
$result = $stmt->get_result();

// Check if clerk exists
if ($result->num_rows === 1) {
    // Fetch clerk details
    $row = $result->fetch_assoc();
    $staffID = $row['staffID'];
    $staffName = $row['staffName'];
    $staffEmail = $row['staffEmail'];
    $staffContact = $row['staffContact'];
    $qualification = $row['qualification'];
    // staffPass should not be displayed directly in a profile page for security reasons
    // If needed, it should only be displayed in a form for update purposes
} else {
    // Redirect or handle error if clerk not found
    echo "Error: Clerk not found.";
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
    <title>Clerk Profile</title>
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
        .form-control-static {
            padding: 7px 12px;
            margin-bottom: 0;
            line-height: 1.5;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
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
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="page-header">
            <h1>Principal Profile</h1>
        </div>
        <div class="form-group">
            <label>Staff ID</label>
            <p class="form-control-static"><?php echo htmlspecialchars($staffID); ?></p>
        </div>
        <div class="form-group">
            <label>Staff Name</label>
            <p class="form-control-static"><?php echo htmlspecialchars($staffName); ?></p>
        </div>
        <div class="form-group">
            <label>Staff Email</label>
            <p class="form-control-static"><?php echo htmlspecialchars($staffEmail); ?></p>
        </div>
        <div class="form-group">
            <label>Staff Contact</label>
            <p class="form-control-static"><?php echo htmlspecialchars($staffContact); ?></p>
        </div>
        <div class="form-group">
            <label>Qualification</label>
            <p class="form-control-static"><?php echo htmlspecialchars($qualification); ?></p>
        </div>
        <div class="btn-container">
            <!-- Update button or link -->
            <a href="principalUpdate.php" class="btn btn-primary">Update</a>
        </div>
    </div>
</body>
</html>
