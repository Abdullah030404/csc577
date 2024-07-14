<?php
include_once "universalHeader.php";
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

        

        main {
            padding-top: 10px; /* Adjust based on navbar height */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .carousel {
            position: relative;
            width: 90%; /* Change width to 100% */
            height: 100vh; /* Full viewport height */
            overflow: hidden;
        }

        .carousel img {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0; /* Initial opacity to create fade-in effect */
            transition: opacity 1s ease; /* Smooth opacity transition */
        }

        .carousel img.active {
            opacity: 1; /* Show active image */
        }

    </style>
</head>
<body>
    <main>
        <div class="carousel">
            <img src="image/homePage1.jpg" alt="Image 1" class="active">
            <img src="image/homePage2.jpg" alt="Image 2">
            <img src="image/homePage3.jpg" alt="Image 3">
            <img src="image/homePage4.jpg" alt="Image 4">
            <img src="image/homePage5.jpg" alt="Image 5">
            <img src="image/homePage6.jpg" alt="Image 6">
            <!-- Add more images as needed -->
        </div>
    </main>

    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.carousel img');
        const totalImages = images.length;

        function showNextImage() {
            const currentImage = images[currentIndex];
            const nextIndex = (currentIndex + 1) % totalImages;
            const nextImage = images[nextIndex];

            // Fade out current image
            currentImage.style.opacity = 0;

            // Set timeout to change image after fade out
            setTimeout(() => {
                // Change active class
                currentImage.classList.remove('active');
                nextImage.classList.add('active');

                // Fade in next image
                nextImage.style.opacity = 1;

                // Update currentIndex
                currentIndex = nextIndex;
            }, 1000); // Adjust timing to match CSS transition duration (1s)
        }

        // Show the first image immediately
        images[currentIndex].classList.add('active');

        // Start the interval to change images
        setInterval(showNextImage, 5000); // Change image every 5 seconds

    </script>
</body>
</html>
