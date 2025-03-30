    <?php
    use SendGrid\Mail\Mail;
    require 'vendor/autoload.php';
    require 'PHP/db.php';

    // Load Environment Variables
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Fetch SendGrid API key
    $sendgrid_api_key = $_ENV["SENDGRID_API_KEY"] ?? $_SERVER["SENDGRID_API_KEY"];
    if (!$sendgrid_api_key) {
        die("Error: Missing SendGrid API Key. Check .env file!");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = $_POST["email"];

    // Check if email exists in DB
    $stmt = $conn->prepare("SELECT id FROM Userinfo WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {

        // Generate Secure Binary Token
        $token = bin2hex(random_bytes(16)); // 16-byte binary token converted into hexadecimal for readibility and compatibility purposes.
        
        $expiry_time = date('Y-m-d H:i:s', time() + 3600);  // 1-hour expiry
        $token_hash =  hash("sha256", $token); // 64 length.
      

        // Store Binary Token in DB
        $stmt = $conn->prepare("UPDATE Userinfo
                             SET reset_token_hash = ?, 
                             reset_token_expires_at = ? 
                             WHERE email = ?");
         
        $stmt->bind_param("sss", $token_hash, $expiry_time, $email);
        if (!$stmt->execute()) {
            die("❌ Failed to store token: " . $stmt->error);
        }

        // Retrieve Token from DB
        // $verify_stmt = $conn->prepare("SELECT reset_token_hash, reset_token_expires_at FROM Userinfo WHERE email = ?");
        // $verify_stmt->bind_param("s", $email);
        // $verify_stmt->execute();
        // $verify_result = $verify_stmt->get_result();
        // $stored_token = $verify_result->fetch_assoc();

        // if ($stored_token) {
        //    
        //     echo "Token stored (hex): " . $token . "<br>"; // Debugging (remove in production)
        //     echo "Expiry time: " . $stored_token['token_expires_at'] . "<br>";
        // }

        // Send Email via SendGrid
        $emailObj = new Mail();
        $emailObj->setFrom("faizaneraza930404@gmail.com", "SafeBrowse Support");
        $emailObj->setSubject("Password Reset Request");
        $emailObj->addTo($email);

        $resetLink = "http://localhost/Hackathon/updated/reset_password.php?token=$token";
        $emailObj->addContent("text/plain", "Use this link to reset your password: $resetLink");
        $emailObj->addContent(
            "text/html",
            "Click <a href='" . htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8') . "'>here</a> to reset your password."
        );

        $sendgrid = new \SendGrid($sendgrid_api_key);
        try {
            $response = $sendgrid->send($emailObj);
            if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
                echo "✅ Password reset link sent!";
            } else {
                echo "❌ Error sending email: " . $response->body();
            }
        } catch (Exception $e) {
            echo "⚠️ Caught exception: " . $e->getMessage();
        }
    } else {
         echo "❌ Email not found!";
    }
}
?>

        
