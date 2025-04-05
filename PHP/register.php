    
    <?php
    
    session_start();
    require'db.php';

    $error = [] ;
    
    
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register']))
    {
        $uname = trim($_POST['uname']);
        $email = trim($_POST['email']);
        $pword = trim($_POST['pword']);
        $cword = trim($_POST['cword']);

        //Username
        if(empty($uname)) {
            $error ["uname"] ="Username is required."; 

        } elseif(!preg_match("/^[a-zA-Z0-9]*$/", $uname)) {
            $error["uname"] = "Invalid! Only letters & numbers allowed.";
        } elseif(strlen($uname)<3) {
           $error["username"] = "Username must be at least 3 characters long.";
        }

        // Email
        if(empty($email)) {
           $error["email"] = "Email is required.";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
           $error["email"] = "Invalid email!";
        }

        // Password
        if(empty($pword)) {
           $error["pword"] = "Password is required."; 

        } elseif(strlen($pword)<6) {
            $error["pword"]  = "Password must be at least 6 characters long.";
        }

        if(empty($cword)) {
           $error["cword"] = "Confirm Password is required."; 
        }
        elseif ($pword !== $cword) {
            $error["cword"] = "Passwords do not match!";
        }
    

        if(!empty($error)) {
            
    

            $_SESSION["error"] = $error;
            $_SESSION["old_input"] = $_POST;
            header("Location: /Hackathon/updated/login.php?mode=signup");
            exit();

        }
    
        // echo "Your account has been successfully created!";
    
    }

    
  
    
    // Prepare user data
    $uname = trim($_POST["uname"]);
    $email = trim($_POST["email"]);
    $pword = password_hash($_POST["pword"], PASSWORD_BCRYPT); // Hash password
    
    // Check if username or email already exists
    $query = "SELECT * FROM Userinfo WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION["error"]["email"] = "Email or Username already exists.";
        $_SESSION["old_input"] = $_POST;
        header("Location: /Hackathon/updated/login.php?mode=signup");
        exit();
    }
    
    // Insert new user into Userinfo table
    $insertQuery = "INSERT INTO Userinfo (username, email, hash_password) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("sss", $uname, $email, $pword);
    
    if ($insertStmt->execute()) {
        // Redirect to index.html after successful registration
        $_SESSION['username']= $uname;
        $_SESSION['logged_in'] = true;
        header("Location: /Hackathon/updated/home_page.php");
        exit();
    } else {
        die("Error: " . $conn->error);
    }
    
    // Close connection
    $conn->close();
    
    

?>

    