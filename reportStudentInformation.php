<?php
include 'db_connection.php';
include_once "principalHeader.php";
// Function to display Student Information Report
function displayStudentInformation() {
    global $conn;
    $sql = "SELECT * FROM student";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Student Information</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Student IC</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Guardian Name</th>
                    <th>Guardian Contact</th>
                    <th>Class ID</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["studentIC"] . "</td>
                    <td>" . $row["studentName"] . "</td>
                    <td>" . $row["studentAge"] . "</td>
                    <td>" . $row["studentEmail"] . "</td>
                    <td>" . $row["studentAddress"] . "</td>
                    <td>" . $row["guardianName"] . "</td>
                    <td>" . $row["guardianContact"] . "</td>
                    <td>" . $row["classID"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No students found.";
    }
}

// Include HTML structure for the report
include 'report_template.php'; // You can create a common report template for consistency

$conn->close();
?>
