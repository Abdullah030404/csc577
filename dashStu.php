<?php
// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Student') {
    // Redirect to login page if not logged in or role is incorrect
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .logo-container img {
            height: 50px; /* Adjust the height as needed */
            margin-right: 10px; /* Adjust the spacing as needed */
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
        .content {
            text-align: center;
            max-width: 600px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo-container">
            <a href="index.html">
                <img src="image/tahfiz.jpg" alt="Logo">
            </a>
        </div>
        <div class="navbar-links">
            <a href="dashStu.php">HOME</a>
            <a href="stuProfile.php">PROFILE</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="content">
            <h1>Welcome Student to Maahad Tahfiz As Syifa' System</h1>
            <p>This is the management system for Maahad Tahfiz As Syifa'.</p>
        </div>
    </div>

</body>
</html>
