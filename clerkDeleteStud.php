<?php
require_once "db_connection.php"; // Ensure database connection is included

if (isset($_GET['studentIC'])) {
    $studentIC = $_GET['studentIC'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM student WHERE studentIC = ?");
    $stmt->bind_param("s", $studentIC);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the student list
    header("Location: clerkStudList.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
