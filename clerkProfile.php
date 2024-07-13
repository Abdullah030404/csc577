<?php
include_once "clerkHeader.php";

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
            <h2>Clerk Profile</h2>
        </div>
        <div class="profile-content">
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
        </div>
        <div class="btn-container">
            <a href="clerkUpdate.php" class="btn btn-primary">Update Profile</a>
        </div>
    </div>
</body>
</html>