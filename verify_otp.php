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

    // Handle OTP resend request
    if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $otp = generateOtp();
            $otp_expiration = date('Y-m-d H:i:s', strtotime('+2 minutes'));

            // Send OTP via email using PHPMailer
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Update this
                $mail->SMTPAuth = true;
                $mail->Username = 'prasannsunuwar03@gmail.com'; // Update this
                $mail->Password = 'qnsz peby oylh vvlq'; // Update this
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('prasannasunuwar03@gmail.com', 'PandaTech');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = "Your new OTP code is <b>$otp</b>. It will expire in 2 minutes.";

                $mail->send();

                $_SESSION['otp'] = $otp;
                $_SESSION['otp_expiration'] = $otp_expiration;
                $_SESSION['otp_error'] = "A new OTP has been sent to your email.";
                header("Location: verify_otp.php");
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['otp_error'] = "No email found. Please request a new OTP.";
            header("Location: verify_otp.php");
            exit();
        }
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
