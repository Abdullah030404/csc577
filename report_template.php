<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    // Call the appropriate function based on the report type
    if (function_exists('displayClassInformation')) {
        displayClassInformation();
    }
    if (function_exists('displayStaffInformation')) {
        displayStaffInformation();
    }
    if (function_exists('displayStudentInformation')) {
        displayStudentInformation();
    }
    if (function_exists('displayTotalStudentsPerClass')) {
        displayTotalStudentsPerClass();
    }
    // Add other reports here using similar logic
    ?>
</body>
</html>
