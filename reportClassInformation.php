<?php
include 'db_connection.php';
include_once "principalHeader.php";

// Function to display Class Information Report
function displayClassInformation() {
    global $conn;
    $sql = "SELECT c.classID, c.className, c.classCount, s.staffName 
            FROM class c 
            LEFT JOIN staff s ON c.staffID = s.staffID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Class Information</h2>";
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
                    <td>" . htmlspecialchars($row["classCount"]) . "</td>
                    <td>" . htmlspecialchars($row["staffName"] ?? 'Not Assigned') . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No classes found.</p>";
    }
}

// Include HTML structure for the report
include 'report_template.php';

$conn->close();
?>