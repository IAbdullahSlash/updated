
    <?php

    session_start();
    require 'db.php';

    $error = [];


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $uname = trim($_POST["uname"]);
        $pword = trim($_POST["pword"]);

        if(empty($uname)) {
         $error["uname"] = "Username Invalid";
        }
        if(empty($pword)) {
        $error["pword"] = "Password Invalid";
        }
    

    //Redirect back if errors occur

    if(!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = $_POST;
        header("Location: /Hackathon/updated/login.php");
        exit();
    }

    //User data in DB
    $query = "SELECT * FROM Userinfo WHERE username = ?";
    $stmt = $conn ->prepare($query);
    $stmt->bind_param("s",$uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($pword, $user["hash_password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["logged_in"] = true;
        header("Location: /Hackathon/updated/index.php");
        exit();
    
        } else {
        $_SESSION["error"]["uname"] = "Invalid username or password.";
       
        header("Location: /Hackathon/updated/login.php");
        exit();
     }
    
    }
     $conn->close();

    ?>