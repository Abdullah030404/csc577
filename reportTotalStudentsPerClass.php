<?php
include 'db_connection.php';
include_once "principalHeader.php";
// Function to display Total Students per Class Report
function displayTotalStudentsPerClass() {
    global $conn;
    $sql = "SELECT c.classID, c.className, COUNT(s.studentIC) AS totalStudents 
            FROM class c 
            LEFT JOIN student s ON c.classID = s.classID 
            GROUP BY c.classID, c.className 
            ORDER BY c.classID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Total Students per Class</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Class ID</th>
                    <th>Class Name</th>
                    <th>Total Students</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["classID"] . "</td>
                    <td>" . $row["className"] . "</td>
                    <td>" . $row["totalStudents"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No data available.";
    }
}

// Include HTML structure for the report
include 'report_template.php'; // You can create a common report template for consistency

$conn->close();
?>
