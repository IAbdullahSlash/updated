<?php
// session_start();
require 'PHP/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure token is received from the form
    
    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);

    
    // Validate token in the database
    $stmt = $conn->prepare("SELECT email, reset_token_expires_at FROM Userinfo WHERE reset_token_hash = ?");
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    

    // Token expiration check

    if(!$user){
        die("���️ Token has expired! Buddy.");
    }
    if (!$stmt) {
        die("⚠️ Database error: " . $conn->error);
    }

    // echo "Token expires at: " . htmlspecialchars($user['reset_token_expires_at']) . "<br>";

    // Password validation
    $new_password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if ($new_password !== $confirm_password) {
        die("⚠️ Passwords do not match!");
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        die("⚠️ Password must be at least 8 characters long, contain an uppercase letter, a number, and a special character.");
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $email = $user['email'];
    // Update password and clear reset token
    $stmt = $conn->prepare("UPDATE Userinfo SET hash_password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE email = ?");

    $stmt->bind_param("ss", $hashed_password, $email);

    
    if ($stmt->execute()) {
        // Clear session variables related to reset
       
        header("Location: /Hackathon/updated/login.php", true, 303);
        exit;
    } else {
        die("⚠️ Failed to update password. Please try again.");
    }
}

?>

