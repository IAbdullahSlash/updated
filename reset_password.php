    
    <?php
        
        
        require 'PHP/db.php';
       

        // Ensure token exists in the URL
        // if (!isset($_GET["token"]) || empty(trim($_GET["token"]))) {
        //     die("❌ Invalid or missing token!");
        // }

        if(!isset($_GET["token"]) || empty(trim($_GET["token"]))){
            die("�� Invalid or missing token!");
        }

        $token = $_GET["token"];

        $token_hash = hash("sha256", $token);


        // echo "Received Token (Plain): " . htmlspecialchars($token) . "<br>";
        // echo "Hashed Token: " . $token_hash . "<br>";
        
        // Validate token in the database
        $stmt = $conn->prepare("SELECT email FROM Userinfo 
                                WHERE reset_token_hash = ?" 
                                );
        
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($user === null){
            die("Token not found");
        }
        


    ?>
    
    
    
    
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    


        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');


            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                /* font-family: Arial, sans-serif; */
                font-family: 'Inter', sans-serif;
            }
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f8f9fa;
                font-family: 'Inter', sans-serif;
                
            }
            .container {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 90%;
                max-width: 400px;
            }
            .logo {
                margin-bottom: 20px;
                border-radius: 50%;
            }
            .title {
                font-size: 20px;
                margin-bottom: 10px;
                font-family: 'Roboto';
                
        

            }
            .input-group {
                position: relative;
                top:30px;
                margin-bottom: 15px;
            }
            input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .input-group i {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
            }
            .btn {
                width: 100%;
                padding: 10px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 30px;
            }
            .user-message {
                font-family: 'Inter';
                font-size: 12px;
                opacity: 0.5;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="safeBrowse.jpeg" alt="Logo" class="logo" width="80">
            <div class="title">Change your password</div>
            <p class="user-message">Enter a new password below to change your <br>password.</p>
            <form action="reset_password_process.php" method="POST">
                <div class="input-group">
                
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token) ?>">

                <input type="password" id="password" name="password" placeholder="New password" required>
                    <i class="fas fa-eye" onclick="togglePassword('password')"></i>
                </div>
                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Re-enter new password" required>
                    <i class="fas fa-eye" onclick="togglePassword('confirm-password')"></i>
                </div>
                <button type="submit" class="btn">Reset password</button>
            </form>
        </div>

        <script>
            function togglePassword(id) {
                let input = document.getElementById(id);
                if (input.type === "password") {
                    input.type = "text";
                } else {
                    input.type = "password";
                }
            }
        </script>
    </body>
    </html>
