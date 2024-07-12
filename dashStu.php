<?php
include_once "stuHeader.php"; 

// Assuming you have stored the student's ID in the session during login
$studentID = $_SESSION['userID']; 

// Database connection (adjust the connection details as needed)
include 'db_connection.php';

// Fetch the student's name from the database
$query = "SELECT studentName FROM student WHERE studentIC = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $studentID);
$stmt->execute();
$stmt->bind_result($studentName);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --border-radius: 12px;
            --background-color: #f0f4f8;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-banner {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.5em;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .dashboard-card {
            background-color: var(--secondary-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .dashboard-card h2 {
            color: var(--primary-color);
            font-size: 1.25em;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.5rem;
        }

        .dashboard-card p {
            margin: 0.5rem 0;
            color: var(--text-color);
        }

        .dashboard-card a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .dashboard-card a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-banner">
            <h1>Welcome, <?php echo htmlspecialchars($studentName); ?>!</h1>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2>Quote of the Day</h2>
                <p>"Knowledge doesn't come, but you have to go to it."</p>
                <p>"Knowledge is life and a cure."</p>
                <p>"Everything diminishes when it is used except knowledge."</p>
            </div>

            <div class="dashboard-card">
                <h2>Upcoming Events</h2>
                <p>Azan Competition: August 8th</p>
                <p>Ceramah Ustaz Azhar Idrus: August 15th</p>
                <p>Gotong-royong Perdana: August 17th</p>
            </div>

            <div class="dashboard-card">
                <h2>Study Materials</h2>
                <p><a href="https://cepatquran.com/blog/wp-content/uploads/2018/01/NOTA-RINGKASAN-ASAS-TAJWID-21.pdf">Reciting Al-Quran</a></p>
                <p><a href="https://online.fliphtml5.com/wcvya/heur/#p=1">Islamic Sharia education</a></p>
                <p><a href="https://www.perkim.net.my/wp-content/uploads/2022/07/Sirah-Tahap-Asas.pdf">History of Islam</a></p>
            </div>
        </div>
    </div>
</body>
</html>