<?php
// Include the database connection file
include 'db_connection.php';
include_once "universalHeader.php";
session_start();

// Enable error reporting (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $role = $_POST['role'];
    $userID = $_POST['userID'];
    $password = $_POST['password'];

    // Initialize variables for redirect URL and table name
    $redirectURL = "";
    $tableName = "";
    $passwordColumnName = "";
    $columnID = "";
    $roleColumnName = "";

    // Determine the table and column to query based on role
    switch ($role) {
        case 'Student':
            $tableName = 'student';
            $columnID = 'studentIC';
            $passwordColumnName = 'studentPass'; // Updated to use plain text password
            $redirectURL = 'dashStu.php';
            break;
        case 'Clerk':
        case 'Instructor':
        case 'Principal':
            $tableName = 'staff';
            $columnID = 'staffID';
            $passwordColumnName = 'staffPass'; // Updated to use plain text password
            $roleColumnName = 'staffRole';
            switch ($role) {
                case 'Clerk':
                    $redirectURL = 'dashClerk.php';
                    break;
                case 'Instructor':
                    $redirectURL = 'dashInstructor.php';
                    break;
                case 'Principal':
                    $redirectURL = 'dashPrincipal.php';
                    break;
            }
            break;
        default:
            echo "Invalid role.";
            exit();
    }

    // Prepare the SQL statement
    $sql = "SELECT {$columnID}, {$passwordColumnName}" . ($role !== 'Student' ? ", {$roleColumnName}" : "") . " FROM {$tableName} WHERE {$columnID} = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("s", $userID);

        // Attempt to execute the prepared statement
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows == 1) {
            // Bind result variables
            if ($role === 'Student') {
                $stmt->bind_result($db_userID, $db_password);
            } else {
                $stmt->bind_result($db_userID, $db_password, $db_role);
            }
            $stmt->fetch();

            // Verify the password
            if ($password === $db_password) { // Compare plain text passwords
                // Check if the role matches for staff
                if ($role === 'Student' || $role === $db_role) {
                    // Password and role are correct, redirect to appropriate dashboard
                    $_SESSION['userID'] = $db_userID; // Store user ID in session for further use
                    $_SESSION['role'] = $role; // Store role in session for further use
                    echo "<script>alert('Successful login.'); window.location.href='{$redirectURL}';</script>";
                    exit();
                } else {
                    echo "You do not have access to this role's dashboard.";
                }
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that user ID.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "ERROR: Could not prepare query: $sql. " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Maahad Tahfiz As Syifa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary-color: #1a3a63;
            --secondary-color: #ffffff;
            --accent-color: #ffd700;
            --background-color: #f0f4f8;
            --text-color: #333;
            --error-color: #ff6b6b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
            color: var(--text-color);
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            
        }
        .container {
            margin-top: 80px;
            width: 600px;
            margin: auto;
            padding: 10px;
            margin-top: 50px;
        }

        .form-container {
            background-color: var(--secondary-color);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
        }

        .button-confirm {
            margin-top: 1.5rem;
        }

        .button-confirm button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button-confirm button:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>LOGIN</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Student">Student</option>
                        <option value="Clerk">Clerk</option>
                        <option value="Instructor">Instructor</option>
                        <option value="Principal">Principal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="userID">User ID</label>
                    <input type="text" id="userID" name="userID" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="button-confirm">
                    <button type="submit">LOG IN</button>
                </div>
            </form>
            <?php
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>