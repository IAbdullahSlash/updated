    <?php require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Fetch env variables correctly
    $client_id = $_ENV["GOOGLE_CLIENT_ID"] ?? $_SERVER["GOOGLE_CLIENT_ID"] ?? getenv("GOOGLE_CLIENT_ID");
    $client_secret = $_ENV["GOOGLE_CLIENT_SECRET"] ?? $_SERVER["GOOGLE_CLIENT_SECRET"] ?? getenv("GOOGLE_CLIENT_SECRET");
    $redirect_uri = $_ENV["GOOGLE_REDIRECT_URI"] ?? $_SERVER["GOOGLE_REDIRECT_URI"] ?? getenv("GOOGLE_REDIRECT_URI");

    // Check if variables are set
    if (!$client_id || !$client_secret || !$redirect_uri) {
        die("Error: Missing Google OAuth credentials. Check .env file!");    }

    // Initialize Google Client
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);

    session_start();
    $client->addScope('email');
    $client->addScope('profile');

    $login_url = $client->createAuthUrl();
    header("Location: " . $login_url);
    exit;


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
