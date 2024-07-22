<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form class="signup-form" action="database.php" method="post">
            <h1>Sign Up</h1>

            <!-- First Row: First Name and Middle Name -->
            <div class="form-row">
                <div>
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
                </div>
                <div>
                    <label for="middlename">Middle Name</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Enter your middle name">
                </div>
            </div>

            <!-- Second Row: Last Name and Date of Birth -->
            <div class="form-row">
                <div>
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>
                </div>
                <div>
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
            </div>

            <!-- Gender Row: Gender -->
            <div class="gender-row">
                <fieldset>
                    <legend>Gender</legend>
                    <label><input type="radio" name="gender" value="male" required> Male</label>
                    <label><input type="radio" name="gender" value="female" required> Female</label>
                    <label><input type="radio" name="gender" value="other" required> Other</label>
                </fieldset>
            </div>

            <!-- Third Row: Email and Password -->
            <div class="form-row">
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>

            <button type="submit">Submit</button>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
