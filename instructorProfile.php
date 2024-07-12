<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Instructor') {
    header("Location: login.php");
    exit;
}

require_once "db_connection.php";

$instructorID = $_SESSION['userID'];
$staffName = "";
$staffEmail = "";
$staffContact = "";
$qualification = "";
$staffPass = "";
$staffPass_hashed = "";
$updateSuccess = false;
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (!preg_match('/^\d{3}-\d{3}\s\d{4}$/', $staffContact)) {
        $errorMessages[] = "Contact must be in the form '###-### ####'.";
    }

    if (strlen($staffPass) < 6) {
        $errorMessages[] = "Password must be at least 6 characters long.";
    } else {
        $staffPass_hashed = hash('sha256', $staffPass);
    }

    if (empty($errorMessages)) {
        $query = "UPDATE staff SET staffName = ?, staffEmail = ?, staffContact = ?, qualification = ?, staffPass = ?, staffPass_hashed = ? WHERE staffID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $staffName, $staffEmail, $staffContact, $qualification, $staffPass, $staffPass_hashed, $instructorID);

        if ($stmt->execute()) {
            $updateSuccess = true;
        } else {
            $errorMessages[] = "Error updating record: " . $conn->error;
        }
    }
} else {
    $query = "SELECT staffName, staffEmail, staffContact, qualification, staffPass FROM staff WHERE staffID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $instructorID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $instructor = $result->fetch_assoc();
        $staffName = $instructor['staffName'];
        $staffEmail = $instructor['staffEmail'];
        $staffContact = $instructor['staffContact'];
        $qualification = $instructor['qualification'];
        $staffPass = $instructor['staffPass'];
    } else {
        $errorMessages[] = "Instructor not found.";
    }
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e1e7e0;
        }
        .navbar {
            background-color: #2b4560;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            padding: 0 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .logo-container img {
            height: 50px;
            margin-right: 10px;
        }
        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 10px 10px;
            transition: background-color 0.3s ease;
            font-family: Verdana, sans-serif;
            font-weight: bold;
            font-size: 18px;
        }
        .navbar-links a:hover {
            background-color: #ddd;
            color: black;
        }
        .main-content {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 80%;
            margin: auto;
            margin-top: 80px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        label {
            margin: 10px 0 5px 0;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #2b4560;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #1e2e3b;
        }
        .error {
            color: red;
            font-size: 14px;
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
    <nav class="navbar">
        <div class="logo-container">
            <a href="dashInstructor.php">
                <img src="image/tahfiz.jpg" alt="Logo">
            </a>
        </div>
        <div class="navbar-links">
            <a href="dashInstructor.php">HOME</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </nav>
    <div class="main-content">
        <h2>Instructor Profile</h2>
        <?php if (!empty($errorMessages)): ?>
            <div class="error">
                <?php foreach ($errorMessages as $message): ?>
                    <p><?php echo htmlspecialchars($message); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" onsubmit="return validateForm()">
            <label for="staffName">Name:</label>
            <input type="text" id="staffName" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>" required>

            <label for="staffEmail">Email:</label>
            <input type="email" id="staffEmail" name="staffEmail" value="<?php echo htmlspecialchars($staffEmail); ?>" required>

            <label for="staffContact">Contact:</label>
            <input type="text" id="staffContact" name="staffContact" value="<?php echo htmlspecialchars($staffContact); ?>" required>

            <label for="qualification">Qualification:</label>
            <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($qualification); ?>" required>

            <label for="staffPass">Password:</label>
            <input type="password" id="staffPass" name="staffPass" value="<?php echo htmlspecialchars($staffPass); ?>" required>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
