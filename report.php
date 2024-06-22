<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahfiz Database Report</title>
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
        .navbar-links {
            display: flex;
            align-items: center;
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
        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .table-striped tbody tr:nth-child(even) {
            background-color: #fff;
        }
        .btn-container {
            display: flex;
            gap: 10px; /* Space between the buttons */
            margin-top: 20px; /* Adjust as needed */
            justify-content: center;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
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
            <a href="index.php">HOME</a>
            <a href="report.php">REPORT</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </nav>
    <div class="wrapper">
        <div class="page-header">
            <h1>Tahfiz Database Report</h1>
        </div>

        <!-- Staff Section -->
        <div class="section">
            <h2>Staff</h2>
            <?php
            // Connect to the database
            define('DB_SERVER', 'localhost');
            define('DB_USERNAME', 'root');
            define('DB_PASSWORD', '');
            define('DB_NAME', 'tahfizdb');

            $dbCon = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Check connection
            if ($dbCon === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            // Fetch staff data
            $sql = "SELECT staffID, staffName, staffEmail, staffContact, qualification, staffRole FROM staff";
            if ($result = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Staff ID</th>";
                    echo "<th>Staff Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Contact</th>";
                    echo "<th>Qualification</th>";
                    echo "<th>Role</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['staffID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staffName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staffEmail']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staffContact']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['qualification']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staffRole']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
            } else {
                echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
            }
            ?>
        </div>

        <!-- Class Section -->
        <div class="section">
            <h2>Classes</h2>
            <?php
            // Fetch class data
            $sql = "SELECT class.classID, class.className, class.classCount, staff.staffName 
                    FROM class 
                    JOIN staff ON class.staffID = staff.staffID";
            if ($result = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Class ID</th>";
                    echo "<th>Class Name</th>";
                    echo "<th>Class Count</th>";
                    echo "<th>Staff Name</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['classID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['className']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['classCount']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staffName']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
            } else {
                echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
            }
            ?>
        </div>

        <!-- Students Section -->
        <div class="section">
            <h2>Students</h2>
            <?php
            // Fetch student data
            $sql = "SELECT student.studentIC, student.studentName, student.studentAge, student.studentEmail, 
                           student.studentAddress, student.guardianName, student.guardianContact, class.className 
                    FROM student 
                    JOIN class ON student.classID = class.classID";
            if ($result = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Student IC</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Age</th>";
                    echo "<th>Email</th>";
                    echo "<th>Address</th>";
                    echo "<th>Guardian Name</th>";
                    echo "<th>Guardian Contact</th>";
                    echo "<th>Class Name</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['studentIC']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['studentName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['studentAge']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['studentEmail']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['studentAddress']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['guardianName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['guardianContact']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['className']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
            } else {
                echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
            }

            // Close the connection
            mysqli_close($dbCon);
            ?>
        </div>
        <div class="btn-container">
            <a href="dashPrincipal.php" class="btn btn-primary">Back</a>
        </div>
    </div>
</body>

</html>
