<?php
session_start(); // Start the session to use session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'authentication');

    // Check connection
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Prepare and execute query to check if email exists
    $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, fetch hashed password
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start session and redirect to dashboard.php
            $_SESSION['email'] = $email; // Store email in session
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $error = "Incorrect email or password.";
        }
    } else {
        // Email does not exist
        $error = "Incorrect email or password.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}

// Display error if any
if (isset($error)) {
    echo "<script>alert('$error'); window.location.href='login.php';</script>";
}
?>
