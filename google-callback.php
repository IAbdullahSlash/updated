    <?php
    // require 'vendor/autoload.php'; // Load Google API Client Library
    // use Google\Service\Oauth2;

    // session_start();

    // $client = new Google_Client();
    // $client->setClientId('737634463250-b2hi994rtnvlsskgq1op9eujmg2au06u.apps.googleusercontent.com');
    // $client->setClientSecret('GOCSPX-buo9tFakefCTMChpRIJTXpW_AaML');
    // $client->setRedirectUri('http://localhost/google-callback.php');
    // $client->addScope('email');
    // $client->addScope('profile');

    // if (isset($_GET['code'])) {
    //     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    //     $client->setAccessToken($token);

    //     $google_oauth = new Oauth2($client);
    //     $user_info = $google_oauth->userinfo->get();

    //     // Store user data in session (you can save it in the database too)
    //     $_SESSION['user_id'] = $user_info->id;
    //     $_SESSION['user_name'] = $user_info->name;
    //     $_SESSION['user_email'] = $user_info->email;
    //     $_SESSION['user_picture'] = $user_info->picture;

    //     // Redirect to home or dashboard
    //     header("Location: /FirstCollab/updated/index.html");
    //     exit();
    // } else {
    //     echo "Google login failed!";
    // }

    require 'vendor/autoload.php'; // Load Google API Client Library
    use Google\Service\Oauth2;
    
    session_start();
    
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
    
    // Store user data in session (you can save it in the database too)
    $_SESSION['user_id'] = $user_info->id;
    $_SESSION['user_name'] = $user_info->name;
    $_SESSION['user_email'] = $user_info->email;
    $_SESSION['user_picture'] = $user_info->picture;
    
    // Debugging: Print user info (Remove this after testing)
    echo "<pre>";
    print_r($user_info);
    echo "</pre>";
    
    // Redirect to home or dashboard
    header("Location: /Hackathon/updated/index.html");
    exit();
    
    
    ?>
