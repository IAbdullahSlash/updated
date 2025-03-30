<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            background-color: #333;
            padding: 10px;
            color: white;
        }
        .nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }
        .nav a:hover {
            background-color: #555;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="nav">
        <div>👋 Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>!</div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Dashboard</h1>
        <p>This is your protected dashboard.</p>
    </div>

</body>
</html>
