<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['firstname'];
    $middle_name = $_POST['middlename'];
    $last_name = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'authentication');

    // Check connection
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Check if email already exists
    $check_email_query = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $check_email_query->bind_param("s", $email);
    $check_email_query->execute();
    $check_email_query->store_result();

    if ($check_email_query->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email.'); window.location.href='signUp.php';</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO user (first_name, middle_name, last_name, gender, dob, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $first_name, $middle_name, $last_name, $gender, $dob, $email, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit(); // Make sure to call exit after header redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_email_query->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
