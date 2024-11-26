<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EmoDLive - Emotion Recognition</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="logo">EmoDLive</div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Team</a></li>
                <li><a href="logout.php">Logout</a></li>
               
            </ul>
        </nav>
        <a href="Main.php" class="btn get-started">Get Started</a>
    </header>

    <!-- Main Content Section -->
    <section class="hero">
        <div class="content">
            <h1>EmoDLive - Emotion Recognition Entertainer using Deep Learning</h1>
            <p>At EmoDLive, our mission is to revolutionize the entertainment industry by creating a personalized, emotion-based experience for our users.</p>
            <a href="Main.html" class="btn primary">Get Started →</a>
        </div>
        <div class="illustration">
            <!-- Placeholder Image (Replace with your actual image) -->
            <img src="images/emotion.jpg" alt="Emotion icons around a person" class="main-image">
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h4>Emotions</h4>
                <ul>
                    <li><a href="Happy.html">Happy</a></li>
                    <li><a href="sadness.html">Sad</a></li>
                    <li><a href="Angry.html">Angry</a></li>
                    <li><a href="#">Neutral</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Application</h4>
                <ul>
                    <li><a href="#">Medical Uses</a></li>
                    <li><a href="#">Law Enforcement </a></li>
                    <li><a href="#">Mental Health</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Contact</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-column newsletter">
                <h4>Newsletter</h4>
                <form action="#">
                    <input type="email" placeholder="Email Address" required>
                    <button type="submit">Subscribe</button>
                </form>
              
                <p>Mobile: +923356710730</p>
                <p>Email: niazinouman17@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 emodlive.com | All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript for Slider (if you have any sliding sections) -->
    <script>
        // Add your slider JavaScript here if necessary
    </script>
</body>
</html>
