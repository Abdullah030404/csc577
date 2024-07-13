<?php
require_once "db_connection.php"; // Uncomment if you need to include database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --hover-color: #3a5f81;
            --background-color: #f0f4f8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: static;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            justify-content: space-between;

        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            max-width: 2000px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
            transition: color 0.3s ease;
        }

        .logo-container a:hover {
            color: #f0f0f0;
        }
        .gap {
            padding: 9rem;
        }
        .navbar-links {
            display: flex;
            gap: 1rem;
        }

        .navbar-links a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-links a:hover {
            background-color: var(--hover-color);
            color: var(--secondary-color);
        }

        main {
            padding-top: 80px; /* Adjust based on navbar height */
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo-container">
                <a href="universalHomepage.php">MAAHAD TAHFIZ AS SYIFA</a>
            </div>
            <div class="gap">
            <div class="navbar-links">
            <a href="universalContactUs.php">CONTACT US</a>
            <a href="universalAboutUs.php">ABOUT US</a>
            <a href="login.php">LOGIN</a>
            <a href="register.php">REGISTER</a>
            
        </div>
        </div>
    </nav>
    
</body>
</html>