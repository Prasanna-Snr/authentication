<?php
session_start();
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

    // Check if email and password are correct
    $stmt = $conn->prepare("SELECT id, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        // Password is correct, generate OTP
        $otp = generateOtp(); // Call the OTP generation function
        $otp_expiration = date('Y-m-d H:i:s', strtotime('+2 minutes')); // Set expiration time to 2 minutes

        // Store OTP and expiration in database
        $stmt = $conn->prepare("UPDATE user SET otp = ?, otp_expiration = ? WHERE id = ?");
        $stmt->bind_param("ssi", $otp, $otp_expiration, $user_id);
        $stmt->execute();
        $stmt->close();

        // Send OTP via email
        $to = $email;
        $subject = "Your OTP Code";
        $message = "Your OTP code is $otp. It will expire in 2 minutes.";
        $headers = "From: no-reply@example.com";

        mail($to, $subject, $message, $headers);

        // Store email in session for verification
        $_SESSION['email'] = $email;

        // Redirect to OTP verification page
        header("Location: verify_otp.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }

    $conn->close();
}

// Function to generate a random OTP with uppercase, lowercase, and numbers
function generateOtp($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $otp = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[mt_rand(0, $max)];
    }

    return $otp;
}
?>
