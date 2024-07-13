<?php
// Include the database connection file
include 'db_connection.php';
include_once "universalHeader.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $studentIC = $_POST['studentIC'];
    $studentPass = $_POST['studentPass'];
    $studentName = $_POST['studentName'];
    $studentAge = $_POST['studentAge'];
    $studentEmail = $_POST['studentEmail'];
    $studentAddress = $_POST['studentAddress'];
    $guardianName = $_POST['guardianName'];
    $guardianContact = $_POST['guardianContact'];
    $classID = $_POST['classID'];

    // Prepare the SQL statement
    $sql = "INSERT INTO student (studentIC, studentPass, studentName, studentAge, studentEmail, studentAddress, guardianName, guardianContact, classID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("ssisssssi", $studentIC, $studentPass, $studentName, $studentAge, $studentEmail, $studentAddress, $guardianName, $guardianContact, $classID);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo "Record inserted successfully.";
        } else {
            echo "ERROR: Could not execute query: $sql. " . $conn->error;
        }
    } else {
        echo "ERROR: Could not prepare query: $sql. " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Fetch all classes from the database
$classQuery = "SELECT classID, className FROM class";
$classResult = $conn->query($classQuery);
$classes = [];
while ($classRow = $classResult->fetch_assoc()) {
    $classes[] = $classRow;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 180px;
        }
        .form-container {
            position: relative;
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: #2b4560;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
            margin-left: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container select {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .button-register {
            padding: 10px;
        }
        .button-register button {
            width: 50%;
            padding: 10px;
            margin-top: 10px;
            background-color: #738ca7;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
        }
        .button-register button:hover {
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
<div class="container">
    <div class="form-container">
        <h2>Student Registration</h2>
        <form action="register_student.php" method="post">
            <label for="studentIC">Student IC</label>
            <input type="text" id="studentIC" name="studentIC" maxlength="14" required>
            <label for="studentPass">Student Password</label>
            <input type="password" id="studentPass" name="studentPass" required>
            <label for="studentName">Student Name</label>
            <input type="text" id="studentName" name="studentName" maxlength="30" required>
            <label for="studentAge">Student Age</label>
            <input type="number" id="studentAge" name="studentAge" required>
            <label for="studentEmail">Student Email</label>
            <input type="email" id="studentEmail" name="studentEmail" maxlength="30" required>
            <label for="studentAddress">Student Address</label>
            <input type="text" id="studentAddress" name="studentAddress" maxlength="30" required>
            <label for="guardianName">Guardian Name</label>
            <input type="text" id="guardianName" name="guardianName" maxlength="30" required>
            <label for="guardianContact">Guardian Contact</label>
            <input type="text" id="guardianContact" name="guardianContact" maxlength="10" required>
            <label for="classID">Class</label>
            <select id="classID" name="classID" required>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo htmlspecialchars($class['classID']); ?>">
                        <?php echo htmlspecialchars($class['classID'] . '-' . $class['className']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="button-register">
                <button type="submit">REGISTER</button>
            </div>
        </form>
        <br>
        <div class="account">
            <a href="login.php">Already have an account?</a>           
        </div>
    </div>
</div>

</body>
</html>
