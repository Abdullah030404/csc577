<?php
include 'db_connection.php';
include_once "principalHeader.php";

// Function to display Total Students per Class Report
function displayTotalStudentsPerClass() {
    global $conn;
    $sql = "SELECT c.classID, c.className, COUNT(s.studentIC) AS totalStudents, st.staffName
            FROM class c 
            LEFT JOIN student s ON c.classID = s.classID 
            LEFT JOIN staff st ON c.staffID = st.staffID
            GROUP BY c.classID, c.className, st.staffName
            ORDER BY c.classID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Total Students per Class</h2>";
        echo "<table>
                <thead>
                    <tr>
                        <th>Class ID</th>
                        <th>Class Name</th>
                        <th>Total Students</th>
                        <th>Assigned Staff</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["classID"]) . "</td>
                    <td>" . htmlspecialchars($row["className"]) . "</td>
                    <td>" . htmlspecialchars($row["totalStudents"]) . "</td>
                    <td>" . htmlspecialchars($row["staffName"] ?? 'Not Assigned') . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No data available.</p>";
    }
}

// Include HTML structure for the report
include 'report_template.php';

$conn->close();
?>