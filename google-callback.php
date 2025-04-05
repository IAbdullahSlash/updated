    <?php
    session_start();
    require 'PHP/db.php';
    require 'vendor/autoload.php'; // Load Google API Client Library
    use Google\Service\Oauth2;
    
    
    
    $client = new Google_Client();
    $client->setClientId('737634463250-b2hi994rtnvlsskgq1op9eujmg2au06u.apps.googleusercontent.com');
    $client->setClientSecret('GOCSPX-buo9tFakefCTMChpRIJTXpW_AaML');
    $client->setRedirectUri('http://localhost/Hackathon/updated/google-callback.php');
    $client->addScope('email');
    $client->addScope('profile');
    
    if (!isset($_GET['code'])) {
        die("Google login failed! No authorization code received.");
    }
    
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['error'])) {
        die("Google login failed! Error: " . $token['error']);
    }
    
    // Set access token
    $client->setAccessToken($token);
    
    // Fetch user info
    $google_oauth = new Oauth2($client);
    $user_info = $google_oauth->userinfo->get();
    
    // Check if user info was received
    if (!isset($user_info->id)) {
        die("Google login failed! Unable to retrieve user info.");
    }
    
    $google_id = $user_info->id;
    $name =  $user_info->name;
    $email = $user_info->email;
    $picture = $user_info->picture;

    //Checking user exists in DB
    $query =  "SELECT * FROM Userinfo WHERE email = ? OR google_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $google_id);
    $stmt->execute();
    $result = $stmt->get_result();
    

    
    if($result->num_rows > 0){
        //if user exists in DB, let's update google_id if missing
        $update = $conn->prepare("UPDATE Userinfo SET google_id = ?, user_picture = ? 
        WHERE email = ?");

        $update->bind_param("sss",$google_id,$picture,$email);
        // $update->execute();

        if($update->execute()){
            
            $_SESSION['logged_in'] = true;
            
            }

         $update->close();   
    
    } else {

         //Insert new user if no record found
       $insert = $conn->prepare("INSERT INTO Userinfo (username, email,google_id, user_picture) VALUES ( ?, ?, ?, ?)");
       
        $insert->bind_param("ssss",$name,$email,$google_id,$picture);
        // $insert->execute();

        if($insert->execute()){
            
            $_SESSION['logged_in'] = true;
            
            }
        $insert->close();    
    }
    
    // Debugging: Print user info (Remove this after testing)
    // echo "<pre>";
    // print_r($user_info);
    // echo "</pre>";
    $stmt->close();
   
    // Store user info in session
    $_SESSION['user_google_id'] = $google_id;
    $_SESSION['username'] = $name;
    $_SESSION['user_email']= $email;
    $_SESSION['user_picture']= $picture;
    
    // Redirect to home or dashboard

  header("Location: /Hackathon/updated/home_page.php");
    exit();
    
    
    ?>
