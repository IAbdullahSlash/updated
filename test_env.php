<?php
require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "GOOGLE_CLIENT_ID: " . ($_ENV["GOOGLE_CLIENT_ID"] ?? $_SERVER["GOOGLE_CLIENT_ID"] ?? getenv("GOOGLE_CLIENT_ID")) . "<br>";
echo "GOOGLE_CLIENT_SECRET: " . ($_ENV["GOOGLE_CLIENT_SECRET"] ?? $_SERVER["GOOGLE_CLIENT_SECRET"] ?? getenv("GOOGLE_CLIENT_SECRET")) . "<br>";
echo "GOOGLE_REDIRECT_URI: " . ($_ENV["GOOGLE_REDIRECT_URI"] ?? $_SERVER["GOOGLE_REDIRECT_URI"] ?? getenv("GOOGLE_REDIRECT_URI")) . "<br>";
?>
