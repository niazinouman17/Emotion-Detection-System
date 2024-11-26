<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = ''; // Your MySQL password
$dbname = 'signup'; // Replace with your database name

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if the table exists, and create it if it doesn't
$tableCheckQuery = "SHOW TABLES LIKE 'User_DATA'";
$result = $conn->query($tableCheckQuery);

if ($result->num_rows == 0) {
    $createTableQuery = "
        CREATE TABLE User_DATA (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            age INT NOT NULL,
            gender ENUM('Male', 'Female', 'Other') NOT NULL,
            audio_path VARCHAR(255) NOT NULL,
            emotion VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
    if ($conn->query($createTableQuery) === TRUE) {
        echo "Table `users` created successfully.<br>";
    } else {
        die("Error creating table: " . $conn->error);
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $audio = $_FILES['audio'];
    $uploadDir = 'uploads/'; // Directory to store uploaded files
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $audioPath = $uploadDir . basename($audio['name']);
    if (move_uploaded_file($audio['tmp_name'], $audioPath)) {
        // Simulate emotion detection
        // (Replace this with your actual emotion detection logic)
        $emotions = ['Happy', 'Sad', 'Angry', 'Neutral'];
        $detectedEmotion = $emotions[array_rand($emotions)];

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO User_DATA (name, age, gender, audio_path, emotion) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $name, $age, $gender, $audioPath, $detectedEmotion);

        if ($stmt->execute()) {
            echo "Data saved successfully! Detected emotion: $detectedEmotion";
        } else {
            echo "Error saving data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Failed to upload the audio file.";
    }
}

$conn->close();
?>
