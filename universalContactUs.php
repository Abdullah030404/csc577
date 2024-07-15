<?php
include_once "universalHeader.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Maahad Tahfiz As Syifa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary-color: #1a3a63;
            --secondary-color: #ffffff;
            --accent-color: #ffd700;
            --text-color: #333;
            --background-color: #f0f4f8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
            color: var(--text-color);
        }

        main {
            padding-top: 60px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
        }

        .header {
            text-align: center;
            color: black;
            margin-bottom: 3rem;
            width: 300px;
        }

        .header.card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 600px;
        }

        .header.card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            padding: 2rem;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            text-align: center;
            width: 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .card h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .card p {
            color: var(--text-color);
            font-size: 1.1rem;
        }

        .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .card, .header {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <main>
        <div class="header card">
            <h1>Contact Us</h1>
            <p>We're here to help and answer any question you might have. We look forward to hearing from you!</p>
        </div>

        <div class="container">
            <div class="card">
                <i class="fas fa-map-marker-alt icon"></i>
                <h2>Address</h2>
                <p>Kampung Kolam, Kuala Ibai, 20400</p>
            </div>
            <div class="card">
                <i class="fas fa-phone-alt icon"></i>
                <h2>Phone Number</h2>
                <p>012-269 8189</p>
            </div>
            <div class="card">
                <i class="fas fa-envelope icon"></i>
                <h2>Email</h2>
                <p>maahadassyifa@gmail.com</p>
            </div>
        </div>
    </main>
</body>
</html>
