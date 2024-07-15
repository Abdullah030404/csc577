<?php
include 'db_connection.php';
include_once "principalHeader.php";

// Function to display Staff Information Report
function displayStaffInformation() {
    global $conn;
    $sql = "SELECT * FROM staff";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Information Report</title>
    <style>
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --border-radius: 12px;
            --background-color: #f0f4f8;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            color: var(--text-color);
        }

        .report-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .report-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            text-align: center;
            font-size: 1.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
        }

        .report-header .print-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: var(--accent-color);
            color: var(--secondary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .report-content {
            padding: 2rem;
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.8em;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }

        td {
            font-size: 0.95em;
        }

        @media (max-width: 768px) {
            .report-content {
                padding: 1rem;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 0.75rem;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background-color: #fff; /* Set background color for print */
            }

            .report-container {
                margin: 0 auto; /* Center the report on print */
                box-shadow: none; /* Remove box-shadow for print */
                border-radius: 0; /* Remove border radius for print */
                border: none; /* Remove border for print */
                max-width: 100%; /* Ensure report spans full width on print */
            }

            .report-header {
                background-color: transparent; /* Transparent header background for print */
                color: var(--text-color); /* Text color for print */
                text-align: left; /* Align header text to left for print */
                padding: 0; /* No padding for print */
                font-size: 1.2em; /* Adjust font size for print */
            }

            .report-header .print-btn {
                display: none; /* Hide print button for print */
            }

            .print-header {
                display: block; /* Display custom print header */
                text-align: center; /* Center-align for print */
                font-size: 1.5em; /* Adjust font size */
                margin-bottom: 1rem; /* Add some space below the header */
            }

            .print-header h2, .print-header h3 {
                margin: 0; /* Remove margins */
            }

            table {
                box-shadow: none; /* Remove box-shadow for print */
            }

            th, td {
                border: 1px solid #000; /* Add border for table cells in print */
                padding: 0.5rem; /* Adjust padding for print */
                color: black;
            }

            /* Hide elements for print */
            .no-print {
                display: none !important;
            }
        }

        /* Hide navigation bar for print */
        @media print {
            .navbar, .no-print {
                display: none !important;
            }
        }
    </style>
    <script>
        function setPrintHeader(reportType) {
            const printHeader = document.createElement('div');
            printHeader.className = 'print-header';
            printHeader.innerHTML = `
                <h2>MAAHAD TAHFIZ AS SYIFA'</h2>
                <h3>${reportType} Report</h3>
            `;
            document.body.insertBefore(printHeader, document.querySelector('.report-container'));
        }

        function handlePrint(reportType) {
            setPrintHeader(reportType);
            window.print();
            document.querySelector('.print-header').remove(); // Remove the print header after printing
        }
    </script>
</head>
<body>
    <div class="report-container">
        <div class="report-header no-print">
            <h1>Staff Information Report</h1>
            <button class="print-btn" onclick="handlePrint('Staff Information')">Print</button>
        </div>
        <div class="report-content">
            <?php displayStaffInformation(); ?>
        </div>
    </div>
</body>
</html>
