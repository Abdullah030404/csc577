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
            gap: 10px;
            margin-top: 20px;
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

        .error-message {
            color: red;
            display: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const namePattern = /^[A-Za-z\s]+$/;
            const idPattern = /^[A-Za-z0-9]+$/;
            const countPattern = /^[0-9]+$/;

            const classID = document.getElementById("classID");
            const className = document.getElementById("className");
            const classCount = document.getElementById("classCount");

            classID.addEventListener("input", function() {
                validateField(classID, idPattern, "Class ID should be alphanumeric.");
            });

            className.addEventListener("input", function() {
                validateField(className, namePattern, "Class Name should only contain letters and spaces.");
            });

            classCount.addEventListener("input", function() {
                validateField(classCount, countPattern, "Class Count should be a number.");
            });

            function validateField(field, pattern, message) {
                const errorMessage = field.nextElementSibling;
                if (!pattern.test(field.value)) {
                    errorMessage.textContent = message;
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.textContent = "";
                    errorMessage.style.display = "none";
                }
            }
        });

        function validateForm() {
            const namePattern = /^[A-Za-z\s]+$/;
            const idPattern = /^[A-Za-z0-9]+$/;
            const countPattern = /^[0-9]+$/;

            const classID = document.forms["classForm"]["classID"].value;
            const className = document.forms["classForm"]["className"].value;
            const classCount = document.forms["classForm"]["classCount"].value;

            if (!idPattern.test(classID)) {
                alert("Class ID should be alphanumeric.");
                return false;
            }

            if (!namePattern.test(className)) {
                alert("Class Name should only contain letters and spaces.");
                return false;
            }

            if (!countPattern.test(classCount)) {
                alert("Class Count should be a number.");
                return false;
            }

            return true;
        }
    </script>
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

            // Fetch staff data for dropdown
            $staffOptions = "";
            $sqlStaff = "SELECT staffID, staffName FROM staff";
            if ($resultStaff = mysqli_query($dbCon, $sqlStaff)) {
                if (mysqli_num_rows($resultStaff) > 0) {
                    while ($rowStaff = mysqli_fetch_array($resultStaff)) {
                        $staffOptions .= "<option value='" . htmlspecialchars($rowStaff['staffID']) . "'>" . htmlspecialchars($rowStaff['staffName']) . "</option>";
                    }
                    mysqli_free_result($resultStaff);
                } else {
                    echo "<p class='lead'><em>No staff records were found.</em></p>";
                }
            } else {
                echo "ERROR: Could not execute $sqlStaff. " . mysqli_error($dbCon);
            }

            // Edit class functionality
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editClass'])) {
                $editClassID = mysqli_real_escape_string($dbCon, $_POST['classID']);
                $sqlEdit = "SELECT classID, className, classCount, staffID FROM class WHERE classID='$editClassID'";
                if ($resultEdit = mysqli_query($dbCon, $sqlEdit)) {
                    if (mysqli_num_rows($resultEdit) > 0) {
                        $rowEdit = mysqli_fetch_array($resultEdit);
                        $editClassName = htmlspecialchars($rowEdit['className']);
                        $editClassCount = htmlspecialchars($rowEdit['classCount']);
                        $editStaffID = htmlspecialchars($rowEdit['staffID']);
                    }
                    mysqli_free_result($resultEdit);
                } else {
                    echo "ERROR: Could not execute $sqlEdit. " . mysqli_error($dbCon);
                }
            }
            ?>

            <!-- Form for Add/Update Class -->
            <form name="classForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="classID">Class ID:</label>
                    <input type="text" id="classID" name="classID" value="<?php echo isset($editClassID) ? $editClassID : ''; ?>" required>
                    <span class="error-message">Class ID should be alphanumeric.</span>
                </div>
                <div class="form-group">
                    <label for="className">Class Name:</label>
                    <input type="text" id="className" name="className" value="<?php echo isset($editClassName) ? $editClassName : ''; ?>" required>
                    <span class="error-message">Class Name should only contain letters and spaces.</span>
                </div>
                <div class="form-group">
                    <label for="classCount">Class Count:</label>
                    <input type="number" id="classCount" name="classCount" value="<?php echo isset($editClassCount) ? $editClassCount : ''; ?>" required>
                    <span class="error-message">Class Count should be a number.</span>
                </div>
                <div class="form-group">
                    <label for="staffID">Staff Name:</label>
                    <select id="staffID" name="staffID" required>
                        <?php echo $staffOptions; ?>
                    </select>
                </div>
                <div class="btn-container">
                    <?php if (isset($editClassID)) : ?>
                        <button type="submit" name="updateClass" class="btn btn-primary">Update Class</button>
                    <?php else : ?>
                        <button type="submit" name="addClass" class="btn btn-primary">Add Class</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php mysqli_close($dbCon); ?>
