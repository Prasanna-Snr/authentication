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
            <div class="resend-otp">
                <a href="verify_otp.php?resend=true">Resend OTP</a>
            </div>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify'])) {
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
            $_SESSION['otp_error'] = "Invalid or expired OTP.";
            header("Location: verify_otp.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    }

    // Handle OTP resend request
    if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
        $email = $_SESSION['email'];
        $otp = generateOtp();
        $otp_expiration = date('Y-m-d H:i:s', strtotime('+2 minutes'));

        $conn = new mysqli('localhost', 'root', '', 'authentication');

        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE user SET otp = ?, otp_expiration = ? WHERE email = ?");
        $stmt->bind_param("sss", $otp, $otp_expiration, $email);
        $stmt->execute();
        $stmt->close();

        $to = $email;
        $subject = "Your OTP Code";
        $message = "Your new OTP code is $otp. It will expire in 2 minutes.";
        $headers = "From: no-reply@example.com";

        mail($to, $subject, $message, $headers);

        $_SESSION['otp_error'] = "A new OTP has been sent to your email.";
        header("Location: verify_otp.php");
        exit();

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
</body>
</html>
