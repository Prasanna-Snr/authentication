<?php
session_start();
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'authentication');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        $otp = generateOtp();
        $otp_expiration = date('Y-m-d H:i:s', strtotime('+2 minutes'));

        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiration'] = $otp_expiration;

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'prasannasunuwar03@gmail.com'; 
            $mail->Password = 'qnsz peby oylh vvlq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set sender's email and name
            $mail->setFrom('no-reply@example.com', 'PandaTech');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Your OTP code is <b>$otp</b>. It will expire in 2 minutes.";

            $mail->send();

            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
     echo "<script>alert('Invalid email or password.'); window.location.href='login.php';</script>";
    }

    $conn->close();
}

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
