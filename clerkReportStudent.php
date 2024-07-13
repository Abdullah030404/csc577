<?php
include 'db_connection.php';
include_once "clerkHeader.php";

// Function to display Student Information Report sorted by classID
function displayStudentInformation() {
    global $conn;
    $sql = "SELECT s.*, c.className 
            FROM student s
            LEFT JOIN class c ON s.classID = c.classID
            ORDER BY s.classID"; // Adding ORDER BY clause to sort by classID
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        echo "<table>
                <thead>
                    <tr>
                        <th>Student IC</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Guardian Name</th>
                        <th>Guardian Contact</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["studentIC"]) . "</td>
                    <td>" . htmlspecialchars($row["studentName"]) . "</td>
                    <td>" . htmlspecialchars($row["studentAge"]) . "</td>
                    <td>" . htmlspecialchars($row["studentEmail"]) . "</td>
                    <td>" . htmlspecialchars($row["studentAddress"]) . "</td>
                    <td>" . htmlspecialchars($row["guardianName"]) . "</td>
                    <td>" . htmlspecialchars($row["guardianContact"]) . "</td>
                    <td>" . htmlspecialchars($row["className"] ?? 'Not Assigned') . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No students found.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Report</title>
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
                background-color: #fff;
                color: #000;
                font-size: 12pt;
            }

            .report-container {
                margin: 0;
                padding: 0;
                width: 100%;
                box-shadow: none;
                border: none;
            }

            .report-header, .print-btn, .no-print {
                display: none;
            }

            .report-content {
                padding: 0;
            }

            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }

            .print-header h2 {
                font-size: 24pt;
                margin: 0;
                color: #2b4560;
            }

            .print-header h3 {
                font-size: 16pt;
                margin: 5px 0 0 0;
                font-weight: normal;
            }

            .print-header .school-info {
                font-size: 10pt;
                margin-top: 5px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
                font-weight: bold;
                color: black;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

           
        }
    </style>
    <script>
        function setPrintHeader(reportType) {
            const printHeader = document.createElement('div');
            printHeader.className = 'print-header';
            const currentDate = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            printHeader.innerHTML = `
                <h2>MAAHAD TAHFIZ AS SYIFA</h2>
                <h3>${reportType} Report</h3>
                <div class="report-date">Generated on: ${currentDate}</div>
            `;
            document.body.insertBefore(printHeader, document.querySelector('.report-container'));

            const footer = document.createElement('div');
            footer.className = 'footer';
            document.body.appendChild(footer);
        }

        function handlePrint(reportType) {
            setPrintHeader(reportType);
            window.print();
            document.querySelector('.print-header').remove();
            document.querySelector('.footer').remove();
        }
    </script>
</head>
<body>
    <div class="report-container">
        <div class="report-header no-print">
            <h1>Student Information Report</h1>
            <button class="print-btn" onclick="handlePrint('Student Information')">Print</button>
        </div>
        <div class="report-content">
            <?php displayStudentInformation(); ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
