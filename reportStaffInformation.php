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
        echo "<table border='1'>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Qualification</th>
                    <th>Role</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["staffID"] . "</td>
                    <td>" . $row["staffName"] . "</td>
                    <td>" . $row["staffEmail"] . "</td>
                    <td>" . $row["staffContact"] . "</td>
                    <td>" . $row["qualification"] . "</td>
                    <td>" . $row["staffRole"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No staff found.";
    }
}

// Include HTML structure for the report
include 'report_template.php'; // You can create a common report template for consistency

$conn->close();
?>
