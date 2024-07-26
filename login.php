<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form class="signin-form" action="confirm.php" method="post">
            <h1>Sign In</h1>
            
            <div class="form-row">
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>
            
            <div class="form-row">
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            
            <button type="submit">Login</button>
            <p class="signup-link">Don't have an account? <a href="signUp.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>
