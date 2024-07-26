<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="verify_otp.php" method="post">
            <h1>Verify OTP</h1>
            <div class="form-row">
                <label for="otp">OTP Code</label>
                <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $email = $_SESSION['email']; // Retrieve the email from the session

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'authentication');

    // Check connection
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Fetch the OTP and expiration time from the database
    $stmt = $conn->prepare("SELECT otp, otp_expiration FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($otp, $otp_expiration);
    $stmt->fetch();

    $current_time = date('Y-m-d H:i:s');

    if ($otp === $entered_otp && $current_time <= $otp_expiration) {
        // OTP is correct and not expired, log the user in
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid or expired OTP.";
    }

    $stmt->close();
    $conn->close();
}
?>
