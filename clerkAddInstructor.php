<?php include_once "clerkHeader.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Update Instructor</title>
    <style>
    :root {
        --primary-color: #2b4560;
        --secondary-color: #ffffff;
        --accent-color: #ff6b6b;
        --text-color: #333;
        --border-radius: 12px;
        --background-color: #f0f4f8;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--background-color);
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .wrapper {
        max-width: 1200px;
        margin: 2rem auto;
        background: rgba(255, 255, 255, 0.9);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .page-header {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        padding: 2rem;
        text-align: center;
        font-size: 1.5em;
        letter-spacing: 2px;
        text-transform: uppercase;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
    }

    .section {
        margin-bottom: 2rem;
    }

    h2 {
        color: var(--primary-color);
        border-bottom: 2px solid var(--accent-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
        background-color: var(--secondary-color);
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    table th,
    table td {
        padding: 1rem;
        text-align: left;
    }

    table th {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        font-weight: bold;
        text-transform: uppercase;
    }

    .table-striped tbody tr:nth-child(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .btn-container {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-size: 1em;
        cursor: pointer;
        border: none;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .btn-primary {
        background-color: var(--accent-color);
        color: var(--secondary-color);
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }

    .btn-primary:hover {
        background-color: #ff4757;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 1em;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--accent-color);
    }

    .error-message {
        color: var(--accent-color);
        font-size: 0.9em;
        margin-top: 0.5rem;
        display: none;
    }

    .lead {
        font-size: 1.1em;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
</style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const namePattern = /^[A-Za-z\s@]+$/;
            const qualificationPattern = /^[A-Za-z0-9\s]+$/;
            const contactPattern = /^[0-9]{3}-[0-9]{7}$/;

            const staffName = document.getElementById("staffName");
            const qualification = document.getElementById("qualification");
            const staffContact = document.getElementById("staffContact");

            staffName.addEventListener("input", function() {
                validateField(staffName, namePattern, "Name should not contain numbers.");
            });

            qualification.addEventListener("input", function() {
                validateField(qualification, qualificationPattern, "Qualifications should not contain special characters.");
            });

            staffContact.addEventListener("input", function() {
                validateField(staffContact, contactPattern, "Contact must be in the format XXX-XXXXXXX.");
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
            const namePattern = /^[A-Za-z\s@]+$/;
            const qualificationPattern = /^[A-Za-z0-9\s]+$/;
            const contactPattern = /^[0-9]{3}-[0-9]{7}$/;

            const staffName = document.forms["instructorForm"]["staffName"].value;
            const qualification = document.forms["instructorForm"]["qualification"].value;
            const staffContact = document.forms["instructorForm"]["staffContact"].value;

            if (!namePattern.test(staffName)) {
                alert("Name should not contain numbers.");
                return false;
            }

            if (!qualificationPattern.test(qualification)) {
                alert("Qualifications should not contain special characters.");
                return false;
            }

            if (!contactPattern.test(staffContact)) {
                alert("Contact must be in the format XXX-XXXXXXX.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="page-header">
            <h1>Add/Update Instructor</h1>
        </div>

        <!-- Instructor Section -->
        <div class="section">
            <h2>Instructors</h2>
            <?php
            // Database connection
            define('DB_SERVER', 'localhost');
            define('DB_USERNAME', 'root');
            define('DB_PASSWORD', '');
            define('DB_NAME', 'tahfizdb');

            $dbCon = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Check connection
            if ($dbCon === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            // Handle form submission for adding new instructor
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addInstructor'])) {
                $staffID = isset($_POST['staffID']) ? mysqli_real_escape_string($dbCon, $_POST['staffID']) : '';
                $staffName = isset($_POST['staffName']) ? mysqli_real_escape_string($dbCon, $_POST['staffName']) : '';
                $staffEmail = isset($_POST['staffEmail']) ? mysqli_real_escape_string($dbCon, $_POST['staffEmail']) : '';
                $staffContact = isset($_POST['staffContact']) ? mysqli_real_escape_string($dbCon, $_POST['staffContact']) : '';
                $qualification = isset($_POST['qualification']) ? mysqli_real_escape_string($dbCon, $_POST['qualification']) : '';
                $staffPass = isset($_POST['staffPass']) ? mysqli_real_escape_string($dbCon, $_POST['staffPass']) : '';

                $sql = "INSERT INTO staff (staffID, staffName, staffEmail, staffContact, staffRole, qualification, staffPass) 
                        VALUES ('$staffID', '$staffName', '$staffEmail', '$staffContact', 'Instructor', '$qualification', '$staffPass')";
                if (mysqli_query($dbCon, $sql)) {
                    echo "<p class='lead'>New instructor added successfully.</p>";
                } else {
                    echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
                }
            }

            // Handle form submission for update instructor
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateInstructor'])) {
                // Check if all required fields are set
                if (isset($_POST['staffID'], $_POST['staffName'], $_POST['staffEmail'], $_POST['staffContact'], $_POST['qualification'], $_POST['staffPass'])) {
                    // Escape and retrieve form data
                    $staffID = mysqli_real_escape_string($dbCon, $_POST['staffID']);
                    $staffName = mysqli_real_escape_string($dbCon, $_POST['staffName']);
                    $staffEmail = mysqli_real_escape_string($dbCon, $_POST['staffEmail']);
                    $staffContact = mysqli_real_escape_string($dbCon, $_POST['staffContact']);
                    $qualification = mysqli_real_escape_string($dbCon, $_POST['qualification']);
                    $staffPass = mysqli_real_escape_string($dbCon, $_POST['staffPass']);

                    // Update SQL query
                    $sql = "UPDATE staff SET staffName='$staffName', staffEmail='$staffEmail', staffContact='$staffContact',
                            qualification='$qualification', staffPass='$staffPass'
                            WHERE staffID='$staffID'";

                    // Execute the update query
                    if (mysqli_query($dbCon, $sql)) {
                        echo "<p class='lead'>Instructor updated successfully.</p>";
                    } else {
                        echo "ERROR: Could not execute $sql. " . mysqli_error($dbCon);
                        echo "<p>Redirecting you back to Add/Update Instructor page...</p>";
                        echo "<script>setTimeout(function() { window.location.href = 'clerkAddInstructor.php'; }, 3000);</script>";
                    }
                } else {
                    // Handle case where required fields are not set
                    echo "<p class='lead'>All fields are required for updating an instructor.</p>";
                }
            }

            // Fetch instructors (staff with role 'Instructor') data
            $sql = "SELECT * FROM staff WHERE staffRole = 'Instructor'";
            if ($result = mysqli_query($dbCon, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Staff ID</th>";
                    echo "<th>Staff Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Contact</th>";
                    echo "<th>Qualifications</th>";
                    echo "<th>Password</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['staffID'] . "</td>";
                        echo "<td>" . $row['staffName'] . "</td>";
                        echo "<td>" . $row['staffEmail'] . "</td>";
                        echo "<td>" . $row['staffContact'] . "</td>";
                        echo "<td>" . $row['qualification'] . "</td>";
                        echo "<td>" . $row['staffPass'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST' style='display:inline-block;'>";
                        echo "<input type='hidden' name='staffID' value='" . htmlspecialchars($row['staffID']) . "'>";
                        echo "<button type='submit' name='updateInstructor' class='btn btn-primary'>Edit</button>";
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

            // Close connection
            mysqli_close($dbCon);
            ?>
        </div>

        <!-- Update Instructor Form -->
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateInstructor'])) {
                // Re-establish database connection if needed
                $dbCon = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                
                if ($dbCon === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                $staffID = isset($_POST['staffID']) ? mysqli_real_escape_string($dbCon, $_POST['staffID']) : '';
                $sql = "SELECT * FROM staff WHERE staffID='$staffID'";
                $result = mysqli_query($dbCon, $sql);

                if ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="section">
                        <h2>Edit Instructor</h2>
                        <form name="instructorForm" method="POST" onsubmit="return validateForm()">
                            <input type="hidden" name="staffID" value="<?php echo htmlspecialchars($row['staffID']); ?>">
                            <div class="form-group">
                                <label for="staffName">Name:</label>
                                <input type="text" id="staffName" name="staffName" value="<?php echo isset($row['staffName']) ? htmlspecialchars($row['staffName']) : ''; ?>" required>
                                <span class="error-message" id="staffNameError"></span>
                            </div>
                            <div class="form-group">
                                <label for="staffEmail">Email:</label>
                                <input type="email" name="staffEmail" value="<?php echo isset($row['staffEmail']) ? htmlspecialchars($row['staffEmail']) : ''; ?>" required>
                                <span class="error-message" id="staffEmailError"></span>
                            </div>
                            <div class="form-group">
                                <label for="staffContact">Contact:</label>
                                <input type="text" id="staffContact" name="staffContact" value="<?php echo isset($row['staffContact']) ? htmlspecialchars($row['staffContact']) : ''; ?>" required>
                                <span class="error-message" id="staffContactError"></span>
                            </div>
                            <div class="form-group">
                                <label for="qualification">Qualification:</label>
                                <input type="text" id="qualification" name="qualification" value="<?php echo isset($row['qualification']) ? htmlspecialchars($row['qualification']) : ''; ?>" required>
                                <span class="error-message" id="qualificationError"></span>
                            </div>
                            <div class="form-group">
                                <label for="staffPass">Password:</label>
                                <input type="password" name="staffPass" value="<?php echo isset($row['staffPass']) ? htmlspecialchars($row['staffPass']) : ''; ?>" required>
                                <span class="error-message" id="staffPassError"></span>
                            </div>
                            <button type="submit" name="updateInstructor" class="btn btn-primary">Update Instructor</button>
                        </form>
                    </div>
                    <?php
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No records found for the selected instructor.</em></p>";
                }
            }
            ?>


        <!-- Add Instructor Form -->
        <div class="section">
            <h2>Instructor</h2>
            <form name="instructorForm" action="clerkAddInstructor.php" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="staffID">Staff ID</label>
                    <input type="text" id="staffID" name="staffID" required>
                    <span class="error-message" id="staffIDError"></span>
                </div>
                <div class="form-group">
                    <label for="staffName">Name</label>
                    <input type="text" id="staffName" name="staffName" required>
                    <span class="error-message" id="staffNameError"></span>
                </div>
                <div class="form-group">
                    <label for="staffEmail">Email</label>
                    <input type="email" id="staffEmail" name="staffEmail" required>
                    <span class="error-message" id="staffEmailError"></span>
                </div>
                <div class="form-group">
                    <label for="staffContact">Contact</label>
                    <input type="text" id="staffContact" name="staffContact" required>
                    <span class="error-message" id="staffContactError"></span>
                </div>
                <div class="form-group">
                    <label for="qualification">Qualifications</label>
                    <input type="text" id="qualification" name="qualification" required>
                    <span class="error-message" id="qualificationError"></span>
                </div>
                <div class="form-group">
                    <label for="staffPass">Password</label>
                    <input type="password" id="staffPass" name="staffPass" required>
                    <span class="error-message" id="staffPassError"></span>
                </div>
                <div class="btn-container">
                    <button type="submit" name="addInstructor" class="btn btn-primary">Add Instructor</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
