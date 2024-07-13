<?php
include 'db_connection.php';
include_once "principalHeader.php";

// Function to display Student Information Report
function displayStudentInformation() {
    global $conn;
    $sql = "SELECT s.*, c.className 
            FROM student s
            LEFT JOIN class c ON s.classID = c.classID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Student Information</h2>";
        echo "<table>
                <thead>
                    <tr>
                        <th>Student IC</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Guardian Name</th>
                        <th>Guardian Contact</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["studentIC"]) . "</td>
                    <td>" . htmlspecialchars($row["studentName"]) . "</td>
                    <td>" . htmlspecialchars($row["studentAge"]) . "</td>
                    <td>" . htmlspecialchars($row["studentEmail"]) . "</td>
                    <td>" . htmlspecialchars($row["studentAddress"]) . "</td>
                    <td>" . htmlspecialchars($row["guardianName"]) . "</td>
                    <td>" . htmlspecialchars($row["guardianContact"]) . "</td>
                    <td>" . htmlspecialchars($row["className"] ?? 'Not Assigned') . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No students found.</p>";
    }
}

// Include HTML structure for the report
include 'report_template.php';

$conn->close();
?>