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
                    header("Location: {$redirectURL}");
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
    <title>Login</title>
    <style>
       body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 30px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            width: 400px;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .form-container h2 {
            color: #2b4560;
            margin-bottom: 30px;
            font-size: 28px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            color: #2b4560;
            font-weight: 600;
            font-size: 14px;
        }

        .form-container select,
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-container select:focus,
        .form-container input[type="text"]:focus,
        .form-container input[type="password"]:focus {
            outline: none;
            border-color: #3a6186;
            box-shadow: 0 0 0 2px rgba(58, 97, 134, 0.2);
        }

        .button-confirm {
            text-align: center;
        }

        .button-confirm button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background-color: #3a6186;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .button-confirm button:hover {
            background-color: #89253e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .button-confirm button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>LOGIN</h2>
            <form action="login.php" method="post">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="Student">Student</option>
                    <option value="Clerk">Clerk</option>
                    <option value="Instructor">Instructor</option>
                    <option value="Principal">Principal</option>
                </select>
                <label for="userID">User ID</label>
                <input type="text" id="userID" name="userID" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="button-confirm">
                    <button type="submit">LOG IN</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
