<?php
session_start();
session_unset();
session_destroy();
header("Location: /Hackathon/updated/index.php"); // Redirect to login page
exit();
?>