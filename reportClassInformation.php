<?php
include 'db_connection.php';
include_once "principalHeader.php";

// Function to display Class Information Report
function displayClassInformation() {
    global $conn;
    $sql = "SELECT * FROM class";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Class Information</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Class ID</th>
                    <th>Class Name</th>
                    <th>Total Students</th>
                    <th>Assigned Staff</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["classID"] . "</td>
                    <td>" . $row["className"] . "</td>
                    <td>" . $row["classCount"] . "</td>
                    <td>" . $row["staffID"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No classes found.";
    }
}

// Include HTML structure for the report
include 'report_template.php'; // You can create a common report template for consistency

$conn->close();
?>
