<?php
include 'db_connection.php';
include_once "principalHeader.php";

// Function to display Staff Information Report
function displayStaffInformation() {
    global $conn;
    $sql = "SELECT * FROM staff";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Staff Information</h2>";
        echo "<table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Qualification</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["staffID"]) . "</td>
                    <td>" . htmlspecialchars($row["staffName"]) . "</td>
                    <td>" . htmlspecialchars($row["staffEmail"]) . "</td>
                    <td>" . htmlspecialchars($row["staffContact"]) . "</td>
                    <td>" . htmlspecialchars($row["qualification"]) . "</td>
                    <td>" . htmlspecialchars($row["staffRole"]) . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No staff found.</p>";
    }
}

// Include HTML structure for the report
include 'report_template.php';

$conn->close();
?>