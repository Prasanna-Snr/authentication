<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Screen</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #e0eafc; /* Light blue background */
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            padding: 2rem;
        }

        .header {
            background: #4a90e2;
            color: #fff;
            padding: 1rem 2rem;
            width: 100%;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .card {
            background: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33.333% - 2rem);
            min-width: 250px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 1rem;
            color: #333;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        .card a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: #4a90e2;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .card a:hover {
            background: #357ab7;
        }

        @media (max-width: 768px) {
            .card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Your Home Screen</h1>
    </div>
    <div class="container">
        <div class="card">
            <h3>Profile</h3>
            <p>Manage your personal information and settings.</p>
            <a href="#">View Profile</a>
        </div>
        <div class="card">
            <h3>Messages</h3>
            <p>Check your latest messages and notifications.</p>
            <a href="#">View Messages</a>
        </div>
        <div class="card">
            <h3>Settings</h3>
            <p>Update your preferences and configure your account.</p>
            <a href="#">View Settings</a>
        </div>
        <div class="card">
            <h3>Help</h3>
            <p>Find answers to your questions and get support.</p>
            <a href="#">View Help</a>
        </div>
    </div>
</body>
</html>

