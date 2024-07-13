<?php
include_once "universalHeader.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Maahad Tahfiz As Syifa</title>
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
        }

        .header {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 3rem;
            width: 100%;
            max-width: 800px;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
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
            max-width: 1200px;
            width: 100%;
        }

        .card {
            background-color: var(--secondary-color);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            width: calc(33.333% - 2rem);
            min-width: 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.8rem;
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
            .card {
                width: 90%;
            }
            .header h1 {
                font-size: 2.5rem;
            }
        }
        
    </style>
</head>
<body>
    <main>
        <div class="header">
            <h1>PENGENALAN</h1>
            <p><i class="fas fa-quran icon"></i>Pusat Pengajian dan Tahfiz Al-Quran. Mendidik Generasi Al-Quran</p>
        </div>
        <div class="container">
            <div class="card">
                <i class="fas fa-eye icon"></i>
                <h2>Vision</h2>
                <p>Sebuah Institusi Pendidikan Duniawi dan Ukhrawi Dalam Melahirkan Generasi Al-Quran</p>
            </div>
            <div class="card">
                <i class="fas fa-bullseye icon"></i>
                <h2>Mission</h2>
                <p>Mendidik dan Memberi Tarbiyah Kepada Generasi Muda Daerah Tuaran.
                Kompeten Dalam Pelbagai Bidang. Berakhlak, Bertakwa, Ikhlas, Berilmu dan Beramal, Berkonsepkan
                Sistem Pendidikan Integrasi dan Holistik Untuk Dunia dan Akhirat</p>
            </div>
            <div class="card">
                <i class="fas fa-quote-right icon"></i>
                <h2>Motto</h2>
                <p>Generasi Rabbani Duniawi Dan Ukhrawi</p>
            </div>
        </div>
    </main>
</body>
</html>