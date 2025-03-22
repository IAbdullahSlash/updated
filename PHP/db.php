


<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


        
            // $host = "localhost";
            // $user = "root";
            // $pass = "";
            // $dbname = "User";
        
        $conn = mysqli_connect("localhost", "root", "", "UserM");
        if (!$conn) {
          die("Connection failed: ". mysqli_connect_error());
        }
        else {
            echo "connected";
        }
     
            
?>


   