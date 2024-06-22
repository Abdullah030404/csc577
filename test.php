<?php
// Include the database connection file
include 'db_connection.php';

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

    // Determine the table and column to query based on role
    switch ($role) {
        case 'Student':
            $tableName = 'student';
            $columnID = 'studentIC';
            $passwordColumnName = 'studentPass_hashed';
            $redirectURL = 'dashStu.php';
            break;
        case 'Clerk':
        case 'Instructor':
        case 'Principal':
            $tableName = 'staff';
            $columnID = 'staffID';
            $passwordColumnName = 'staffPass_hashed';
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
    $sql = "SELECT {$columnID}, {$passwordColumnName} FROM {$tableName} WHERE {$columnID} = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("s", $userID);

        // Attempt to execute the prepared statement
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows == 1) {
            // Bind result variables
            $stmt->bind_result($db_userID, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (hash_equals($hashed_password, hash('sha256', $password))) { // Use hash_equals for timing attacks
                // Password is correct, redirect to appropriate dashboard
                $_SESSION['userID'] = $db_userID; // Store user ID in session for further use
                header("Location: {$redirectURL}");
                exit();
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
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #ece0d1;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 60px; /* Adjust to account for navbar height */
        }
        .form-container {
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: #2b4560;
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
            margin-left: 20px;
        }
        /* Adjust select element */
        .form-container select,
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: calc(100% - 20px); /* Subtract padding and border */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px; /* Match font size if needed */
        }
        .button-confirm button {
            width: 50%;
            padding: 10px;
            margin-top: 10px;
            background-color: #738ca7;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        .button-confirm button:hover {
            background-color: #45a049;
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
