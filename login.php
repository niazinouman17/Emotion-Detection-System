<?php
// Start the session to store user data
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists
    $checkUser = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // If password is correct, redirect to homepage
            $_SESSION['user'] = $user['fullname']; // Store user data in session
            header("Location: home.php"); // Redirect to homepage
            exit();
        } else {
            // If password is incorrect
            $error = "Wrong email or password.";
        }
    } else {
        // If user doesn't exist
        $error = "Wrong email or password.";
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
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css?v=1.0" />

</head>
<body>
    <section class="wrapper">
        <div class="form login">
            <header>Login</header>
            <!-- Login form -->
            <form action="" method="POST">
                <input type="text" name="email" placeholder="Email address" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" value="Login" />
            </form>
            <p>Don't have an account? <a href="signup.php">Signup here</a></p>

            <!-- Display error if any -->
            <?php
            if (isset($error)) {
                echo "<p style='color:red;'>$error</p>";
            }
            ?>
        </div>
    </section>
</body>
</html>
