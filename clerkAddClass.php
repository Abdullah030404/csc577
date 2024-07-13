<?php include_once "clerkHeader.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Update Class</title>
    <style>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="page-header">
            <h1>Add/Update Class</h1>
        </div>

        <!-- Class Section -->
        <div class="section">
            <h2>Classes</h2>
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

            // Handle form submission for adding new class
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addClass'])) {
                $classID = mysqli_real_escape_string($dbCon, $_POST['classID']);
                $className = mysqli_real_escape_string($dbCon, $_POST['className']);
                $classCount = mysqli_real_escape_string($dbCon, $_POST['classCount']);
                $staffID = mysqli_real_escape_string($dbCon, $_POST['staffID']);

                $sql = "INSERT INTO class (classID, className, classCount, staffID) VALUES ('$classID', '$className', '$classCount', '$staffID')";
                if (mysqli_query($dbCon, $sql)) {
                    echo "<p class='lead'>New class added successfully.</p>";
                } else {
                    echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
                    echo "<p>Redirecting you back to Add Class page...</p>";
                    echo "<script>setTimeout(function() { window.location.href = 'clerkAddClass.php'; }, 3000);</script>";
                }
            }

            // Handle form submission for updating class
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateClass'])) {
                $classID = mysqli_real_escape_string($dbCon, $_POST['classID']);
                $className = mysqli_real_escape_string($dbCon, $_POST['className']);
                $classCount = mysqli_real_escape_string($dbCon, $_POST['classCount']);
                $staffID = mysqli_real_escape_string($dbCon, $_POST['staffID']);

                $sql = "UPDATE class SET className='$className', classCount='$classCount', staffID='$staffID' WHERE classID='$classID'";
                if (mysqli_query($dbCon, $sql)) {
                    echo "<p class='lead'>Class updated successfully.</p>";
                } else {
                    echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
                    echo "<a href='clerkAddClass.php' class='button'>Go to Another Page</a>";

                }
            }

            // Fetch class data
            $sql = "SELECT class.classID, class.className, class.classCount, staff.staffName, class.staffID 
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
                    echo "<th>Actions</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['classID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['className']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['classCount']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['staffName']) . "</td>";
                        echo "<td>";
                        echo "<form method='POST' style='display:inline-block;'>";
                        echo "<input type='hidden' name='classID' value='" . htmlspecialchars($row['classID']) . "'>";
                        echo "<button type='submit' name='editClass' class='btn btn-primary'>Edit</button>";
                        echo "</form>";
                        echo "</td>";
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

            <!-- Edit Class Form -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editClass'])) {
                $classID = mysqli_real_escape_string($dbCon, $_POST['classID']);
                $sql = "SELECT * FROM class WHERE classID='$classID'";
                $result = mysqli_query($dbCon, $sql);
                if ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="section">
                        <h2>Edit Class</h2>
                        <form method="POST">
                            <input type="hidden" name="classID" value="<?php echo htmlspecialchars($row['classID']); ?>">
                            <div class="form-group">
                                <label for="className">Class Name:</label>
                                <input type="text" name="className" value="<?php echo htmlspecialchars($row['className']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="classCount">Class Count:</label>
                                <input type="number" name="classCount" value="<?php echo htmlspecialchars($row['classCount']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="staffID">Staff:</label>
                                <select name="staffID" required>
                                    <?php
                                    $staffSql = "SELECT staffID, staffName FROM staff";
                                    $staffResult = mysqli_query($dbCon, $staffSql);
                                    while ($staffRow = mysqli_fetch_array($staffResult)) {
                                        echo "<option value='" . htmlspecialchars($staffRow['staffID']) . "' " . ($row['staffID'] == $staffRow['staffID'] ? 'selected' : '') . ">" . htmlspecialchars($staffRow['staffName']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="updateClass" class="btn btn-primary">Update Class</button>
                        </form>
                    </div>
                    <?php
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No records found for the selected class.</em></p>";
                }
            }
            ?>

            <!-- Add New Class Form -->
            <div class="section">
                <h2>Add New Class</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="classID">Class ID:</label>
                        <input type="text" name="classID" required>
                    </div>
                    <div class="form-group">
                        <label for="className">Class Name:</label>
                        <input type="text" name="className" required>
                    </div>
                    <div class="form-group">
                        <label for="classCount">Class Count:</label>
                        <input type="number" name="classCount" required>
                    </div>
                    <div class="form-group">
                        <label for="staffID">Staff:</label>
                        <select name="staffID" required>
                            <?php
                            $staffSql = "SELECT staffID, staffName FROM staff";
                            $staffResult = mysqli_query($dbCon, $staffSql);
                            while ($staffRow = mysqli_fetch_array($staffResult)) {
                                echo "<option value='" . htmlspecialchars($staffRow['staffID']) . "'>" . htmlspecialchars($staffRow['staffName']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="addClass" class="btn btn-primary">Add Class</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
