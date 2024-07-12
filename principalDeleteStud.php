<?php
include_once 'db_connection.php';

// Check if studentIC parameter is present in the URL
if (isset($_GET['studentIC'])) {
    // Sanitize the input to prevent SQL injection
    $studentIC = $conn->real_escape_string($_GET['studentIC']);

    // SQL query to delete student based on studentIC
    $query = "DELETE FROM student WHERE studentIC = '$studentIC'";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Redirect back to principalStudList.php after successful deletion
        header("Location: principalStudList.php");
        exit();
    } else {
        echo "Error deleting student: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
