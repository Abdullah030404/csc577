<?php
// Include the database connection file
include 'db_connection.php';

session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $userID = $_POST['userID'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Prepare the SQL statement
    $sql = "SELECT password, role FROM Account WHERE userID = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("s", $userID);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $stmt->store_result();
            
            // Check if the user exists
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($hashed_password, $db_role);
                $stmt->fetch();
                
                // Verify the password
                if (password_verify($password, $hashed_password) && $role == $db_role) {
                    // Redirect to the appropriate homepage based on role
                    if ($role == 'Student') {
                        header("Location: stuProfile.html");
                        exit();
                    } else {
                        echo "Invalid role. This form is only for students.";
                    }
                } else {
                    echo "Invalid user ID, password, or role.";
                }
            } else {
                echo "No account found with that user ID.";
            }
        } else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
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
        .navbar {
            width: 100%;
            background-color: #2b4560;
            padding: 10px 20px;
            box-sizing: border-box;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-container img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar-links {
            display: flex;
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
        .form-container a {
            text-decoration: none;
            color: #cccccc;
            font-size: 14px;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo-container">
            <a href="homepage.html">
                <img src="image/tahfiz.jpg" alt="Logo">
            </a>
        </div>
        <div class="navbar-links">
            <a href="login.html">LOGIN</a>
        </div>
    </nav>
    <div class="container">
        <div class="form-container">
            <h2>LOGIN</h2>
            <form action="login.php" method="post">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="Student">Student</option>
                    <option value="Clerk">Clerk</option>
                    <option value="Principal">Principal</option>
                    <option value="Instructor">Instructor</option>
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
