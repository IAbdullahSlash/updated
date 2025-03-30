

  <?php
    session_start();
    // require 'google-login.php';
    
    
    
    $unameError = $emailError = $pwordError = $cwordError = "";
    $loginError = "";
    $old_input = $_SESSION["old_input"] ?? [];

    $error = $_SESSION["error"] ?? [];
    
    $unameError = $_SESSION["error"]["uname"] ?? "";
    $pwordError = $_SESSION["error"]["pword"] ?? "";
    $old_input = $_SESSION["old_input"] ?? [];

    // unset($_SESSION["error"]);
    // unset($_SESSION["old_input"]);
  
  if(isset($_SESSION["error"])) {
    
    //Registeration error
    $unameError = $_SESSION["error"]["uname"] ?? "";
    $emailError = $_SESSION["error"]["email"] ?? "";
    $pwordError = $_SESSION["error"]["pword"] ?? "";
    $cwordError = $_SESSION["error"]["cword"] ?? "";

    //Login errors

  }


 

  unset($_SESSION["error"]);
  unset($_SESSION['old_input']);

  


  ?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="styles/login.css"/>
    <title>Sign in & Sign up Form</title>
    <style> .error {color:red; font-size: 10px; width:200px; height:25px} </style>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">

          <!-- Login validation  --> 

          <form action="PHP/login_process.php" class="sign-in-form" method="POST">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="uname" 
              value="<?php echo htmlspecialchars($old_input['uname'] ?? ''); ?>" />
              <div class="error" ><?php echo htmlspecialchars($unameError); ?> </div>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="pword" />
              <span class="error"><?php echo $pwordError; ?> </span>
            </div>
            <a href="forgot_password.php" style="color:grey; left:0;">Forget Password?</a>
            <!-- LOgin BTn -->
            <input type="submit" value="Login" class="btn solid" />
            
            <p class="social-text">Or</p>
            <hr style="width:130px;">
            <div class="social-media">
              <a href="google-login.php" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
            </div>
          </form>
            <!-- To Register form -->
          <form action="PHP/register.php" class="sign-up-form" method="POST">
            <h2 class="title">Register now!</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="uname"
                  value="<?php echo $old_input['uname'] ?? ''; ?>" />
              <br>
              <span class="error"><?php echo $unameError; ?></span>
              <br>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email"  name="email" 
                 value="<?php echo $old_input['email'] ?? ''; ?>"/>
              <br>
              <span class="error"><?php echo $emailError;?></span>
              <br>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="pword" 
                 value="<?php echo $old_input['pword'] ?? ''; ?>"
              />
              <br>
              <span class="error"><?php echo $pwordError;?></span>
              <br>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="ConfirmPassword"name="cword" 
                 value="<?php echo $old_input['cword'] ?? ''; ?>"/>
              <br>
              <span class="error"><?php echo $cwordError;?></span>
              <br>
            </div>
            <input type="submit" class="btn" value="Sign up" name="register"/>
            
            <p class="social-text">Or</p>
            <hr style="width:130px;">
            <div class="social-media">
              </a>
              <a href="google-login.php"  class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              </a>
            </div>
          </form>

        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Safe Browse</h3>
            <p>

             If you do not have an account please register first. 

            </p>
            <button class="btn transparent" id="sign-up-btn" 
            onclick="switchMode('signup')">
              Register
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Safe Browse</h3>
            <p>
             If you already have an account ,please sign-in.
            </p>
            <button class="btn transparent" id="sign-in-btn"
            onclick="switchMode('signin')">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="scripts/login.js"></script>
  </body>
</html>
