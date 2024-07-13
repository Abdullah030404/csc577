<?php
require_once "db_connection.php"; // Uncomment if you need to include database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #2b4560;
            --secondary-color: #ffffff;
            --hover-color: #3a5f81;
            --background-color: #f0f4f8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: static;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
            transition: color 0.3s ease;
        }

        .logo-container a:hover {
            color: #f0f0f0;
        }

        .navbar-links {
            display: flex;
            gap: 1.5rem;
        }

        .navbar-links a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-links a:hover {
            background-color: var(--hover-color);
            color: var(--secondary-color);
        }

        main {
            padding-top: 20px;
        }

        .header {
            text-align: center;
            position: relative;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            gap: 20px;
        }

        .card {
            background-color: white;
            border: 1px solid var(--container-border);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        .card h2 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .card p {
            color: var(--text-color);
        }

        .icon {
            color: green;
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo-container">
                <a href="universalHomepage.php">MAAHAD TAHFIZ AS SYIFA</a>
            </div>
        <div class="navbar-links">
            <a href="universalContactUs.php">CONTACT US</a>
            <a href="universalAboutUs.php">ABOUT US</a>
            <a href="login.php">LOGIN</a>
            <a href="register.php">REGISTER</a>
        </div>
        </div>
    </nav>
    
    <main>
        <div class="header">
            <div class="header-content">
                <h1>PENGENALAN</h1>
                <p><span class="icon">✔️</span>Pusat Pengajian dan Tahfiz Al-Quran. Mendidik Generasi Al-Quran
                </p>
            </div>
        </div>
        
        <div class="container">
            <div class="card">
                <h2>Vision</h2>
                <p>Sebuah Institusi Pendidikan Duniawi dan Ukhrawi Dalam Melahirkan Generasi Al-Quran</p>
            </div>
            <div class="card">
                <h2>Mission</h2>
                <p>Mendidik dan Memberi Tarbiyah Kepada Generasi Muda Daerah Tuaran.
            Kompeten Dalam Pelbagai Bidang. Berakhlak, Bertakwa, Ikhlas, Berilmu dan Beramal, Berkonsepkan
        Sistem Pendidikan Integrasi dan Holistik Untuk Dunia dan Akhirat</p>
            </div>
            <div class="card">
                <h2>Motto</h2>
                <p>Generasi Rabbani Duniawi Dan Ukhrawi</p>
            </div>
        </div>
    </main>
</body>
</html>




