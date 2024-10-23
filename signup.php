<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password for XAMPP
$dbname = "signup"; // Name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the table if it doesn't exist
$table = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($table) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing password for security

    // Check if user already exists
    $checkUser = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo "<script>alert('User already exists! Please login.'); window.location.href='login.php';</script>";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signup</title>
    <link rel="stylesheet" href="css/signup.css" />
</head>
<body>
    <section class="wrapper">
        <div class="form signup">
            <header>Signup</header>
            <form action="" method="POST">
                <input type="text" name="fullname" placeholder="Full name" required />
                <input type="text" name="email" placeholder="Email address" required />
                <input type="password" name="password" placeholder="Password" required />
                <div class="checkbox">
                    <input type="checkbox" id="signupCheck" required />
                    <label for="signupCheck">I accept all terms & conditions</label>
                </div>
                <input type="submit" value="Signup" />
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </section>
</body>
</html>
