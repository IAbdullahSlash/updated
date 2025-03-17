    
    <?php
    require 'vendor/autoload.php'; // Load Google API Client Library
    session_start();

    $client = new Google_Client();
    $client->setClientId('737634463250-b2hi994rtnvlsskgq1op9eujmg2au06u.apps.googleusercontent.com');
    $client->setClientSecret('GOCSPX-buo9tFakefCTMChpRIJTXpW_AaML');
    $client->setRedirectUri('http://localhost/Hackathon/updated/google-callback.php');
    $client->addScope('email');
    $client->addScope('profile');

    $login_url = $client->createAuthUrl();

    header("Location: ". $login_url);
    ?>

    <!-- <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Google Login</title>
    </head>
    <body>
        <h2>Login with Google</h2>
        <a href="#">Click here to Sign in with Google</a>
    </body>
    </html> -->
