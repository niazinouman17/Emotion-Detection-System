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

// Ensure the 'user_data' table exists
$tableCheck = $conn->query("CREATE TABLE IF NOT EXISTS user_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    audio_path VARCHAR(255) NOT NULL,
    emotion VARCHAR(50) DEFAULT 'Not decided yet'
)");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $audio = $_FILES['audio'];
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $audioPath = $uploadDir . basename($audio['name']);
    if (move_uploaded_file($audio['tmp_name'], $audioPath)) {
        $stmt = $conn->prepare("INSERT INTO user_data (name, age, gender, audio_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $age, $gender, $audioPath);
        if ($stmt->execute()) {
            // Get the placeholder emotion
            $placeholderEmotion = "Not decided yet";

            // Display an alert with user info and redirect using JavaScript
            echo "<script>
                alert('Submission Successful!\\nName: $name\\nAge: $age\\nGender: $gender\\nEmotion: $placeholderEmotion');
                window.location.href = 'home.php';
            </script>";
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
