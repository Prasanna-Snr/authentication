<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="verifyOtp.css">
</head>
<body>
    <div class="container">
        <form action="verify_otp.php" method="post">
            <h1>Verify OTP</h1>
            <?php
            session_start();

            // Display error message if OTP verification fails
            if (isset($_SESSION['otp_error'])) {
                echo '<div class="error">' . $_SESSION['otp_error'] . '</div>';
                unset($_SESSION['otp_error']);
            }
            ?>
            <div class="form-row">
                <label for="otp">OTP Code</label>
                <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" name="verify">Verify</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify'])) {
        $entered_otp = $_POST['otp'];
        $current_time = date('Y-m-d H:i:s');

        if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiration'])) {
            $otp = $_SESSION['otp'];
            $otp_expiration = $_SESSION['otp_expiration'];

            if ($otp === $entered_otp && $current_time <= $otp_expiration) {
                // OTP is correct and not expired, log the user in
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['otp_error'] = "Invalid or expired OTP.";
                header("Location: verify_otp.php");
                exit();
            }
        } else {
            $_SESSION['otp_error'] = "No OTP found. Please request a new one.";
            header("Location: verify_otp.php");
            exit();
        }
    }
    ?>
</body>
</html>
