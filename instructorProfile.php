<?php
include_once "instructorHeader.php";
require_once "db_connection.php";

$instructorID = $_SESSION['userID'];
$staffID = "";
$staffName = "";
$staffEmail = "";
$staffContact = "";
$qualification = "";
$errorMessages = [];

$query = "SELECT staffID, staffName, staffEmail, staffContact, qualification FROM staff WHERE staffID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $instructorID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $instructor = $result->fetch_assoc();
    $staffID = $instructor['staffID'];
    $staffName = $instructor['staffName'];
    $staffEmail = $instructor['staffEmail'];
    $staffContact = $instructor['staffContact'];
    $qualification = $instructor['qualification'];
} else {
    $errorMessages[] = "Instructor not found.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Profile</title>
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

        .profile-container {
            max-width: 600px;
            margin: 2rem auto;
            background: var(--secondary-color);
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
        }

        .profile-content {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .btn-update {
            background: linear-gradient(135deg, var(--accent-color), #ff4757);
            color: var(--secondary-color);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            align-self: center;
            margin-top: 2rem;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-update:hover {
            background: linear-gradient(135deg, #ff6b6b, #ff7f7f);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.6);
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Instructor Profile</h2>
        </div>
        <div class="profile-content">
            <?php if (!empty($errorMessages)): ?>
                <div class="error-messages">
                    <?php foreach ($errorMessages as $message): ?>
                        <p><?php echo htmlspecialchars($message); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="staffID">Staff ID:</label>
                <input type="text" id="staffID" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="staffName">Name:</label>
                <input type="text" id="staffName" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="staffEmail">Email:</label>
                <input type="email" id="staffEmail" name="staffEmail" value="<?php echo htmlspecialchars($staffEmail); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="staffContact">Contact:</label>
                <input type="text" id="staffContact" name="staffContact" value="<?php echo htmlspecialchars($staffContact); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="qualification">Qualification:</label>
                <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($qualification); ?>" readonly>
            </div>

            <a href="instructorUpdate.php" class="btn-update">Update Profile</a>
        </div>
    </div>
</body>

</html>
