<?php
include_once "instructorHeader.php"; 
require_once "db_connection.php";

$instructorID = $_SESSION['userID'];
$staffID = "";
$staffName = "";
$staffEmail = "";
$staffContact = "";
$qualification = "";
$staffPass = "";
$updateSuccess = false;
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_POST['staffID'];
    $staffName = $_POST['staffName'];
    $staffEmail = $_POST['staffEmail'];
    $staffContact = $_POST['staffContact'];
    $qualification = $_POST['qualification'];
    $staffPass = $_POST['staffPass'];

    if (!preg_match('/^[A-Za-z@ ]+$/', $staffName)) {
        $errorMessages[] = "Name can only contain letters, spaces, or @.";
    }

    if (!filter_var($staffEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Invalid email format.";
    }

    if (!preg_match('/^\d{3}-\d{3} \d{4}$/', $staffContact)) {
        $errorMessages[] = "Contact must be in the form '###-### ####'.";
    }

    if (strlen($staffPass) < 6) {
        $errorMessages[] = "Password must be at least 6 characters long.";
    } else {
        $staffPass_hashed = hash('sha256', $staffPass);
    }

    if (empty($errorMessages)) {
        $query = "UPDATE staff SET staffName = ?, staffEmail = ?, staffContact = ?, qualification = ?, staffPass = ? WHERE staffID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $staffName, $staffEmail, $staffContact, $qualification, $staffPass_hashed, $staffID);

        if ($stmt->execute()) {
            $updateSuccess = true;
        } else {
            $errorMessages[] = "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }
} else {
    $query = "SELECT staffID, staffName, staffEmail, staffContact, qualification, staffPass FROM staff WHERE staffID = ?";
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
        $staffPass = $instructor['staffPass'];
    } else {
        $errorMessages[] = "Instructor not found.";
    }
    $stmt->close();
}

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

        form {
            display: flex;
            flex-direction: column;
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
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .btn-submit {
            background-color: var(--accent-color);
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
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background-color: #ff4757;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }

        .error-messages {
            background-color: #fde8e8;
            border: 1px solid #f56565;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            color: #c53030;
        }

        .error-messages p {
            margin: 0.25rem 0;
        }

        @media (max-width: 768px) {
            .profile-container {
                width: 90%;
                margin: 1rem auto;
            }
        }
    </style>
    <script>
        function validateForm() {
            var namePattern = /^[A-Za-z@ ]+$/;
            var staffName = document.getElementById("staffName").value;
            var staffPass = document.getElementById("staffPass").value;
            var staffContact = document.getElementById("staffContact").value;
            var contactPattern = /^\d{3}-\d{3} \d{4}$/;

            if (!namePattern.test(staffName)) {
                alert("Name can only contain letters, spaces, or @.");
                return false;
            }

            if (staffPass.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

            if (!contactPattern.test(staffContact)) {
                alert("Contact must be in the form '###-### ####'.");
                return false;
            }

            return true;
        }

        <?php if ($updateSuccess): ?>
        alert("Data has been updated.");
        <?php endif; ?>
    </script>
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
            <form method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="staffID">Staff ID:</label>
                    <input type="text" id="staffID" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="staffName">Name:</label>
                    <input type="text" id="staffName" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>" required>
                </div>

                <div class="form-group">
                    <label for="staffEmail">Email:</label>
                    <input type="email" id="staffEmail" name="staffEmail" value="<?php echo htmlspecialchars($staffEmail); ?>" required>
                </div>

                <div class="form-group">
                    <label for="staffContact">Contact:</label>
                    <input type="text" id="staffContact" name="staffContact" value="<?php echo htmlspecialchars($staffContact); ?>" required>
                </div>

                <div class="form-group">
                    <label for="qualification">Qualification:</label>
                    <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($qualification); ?>" required>
                </div>

                <div class="form-group">
                    <label for="staffPass">Password:</label>
                    <input type="password" id="staffPass" name="staffPass" value="<?php echo htmlspecialchars($staffPass); ?>" required>
                </div>

                <button type="submit" class="btn-submit">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
