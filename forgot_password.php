    <!-- < /*?php
    session_start();
    $emailError = $_SESSION["error"]["email"] ?? "";
    unset($_SESSION["error"]);
    ? */> -->

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>
    </head>
    <body>
        <h2>Forgot Password</h2>
        <form action="forgot_process_password.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <span class="error"><?php echo $emailError; ?></span>
            <button type="submit">Send Reset Link</button>
        </form>
    </body>
    </html>


    