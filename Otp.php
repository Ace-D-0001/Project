<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $otp= $_SESSION['otp'] ;        
    $email=$_SESSION['email'] ;
    $hash = $_SESSION['hash']  ;   
     $username= $_SESSION['username'];
     $otp_input=($_POST["otp_input"]);
     echo "<h1>$otp_input</h1>";
     if($otp == $otp_input){
        header("Location: Pre_login.php");
        exit;
     }
     else{
      echo "<p style='color:red;'>Incorrect OTP. Please try again.</p>";
     }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Faked_It - Sign Up</title>
    <link rel="stylesheet" href="sign_up.css" />
</head>

<body>
   

    <header class="top-bar">
        <div class="logo">Faked_It</div>
    </header>

  

<div class="Opt">
  <form action="" method="POST">
    <h3>Enter OTP</h3>
    <input class="Otp_Input" type="text" name="otp_input" placeholder="Go to your Email" required />
    <button class="Opt_Buttons" type="submit">Submit</button>
  </form>
</div>
<div class="back">
   <a href="sign_up.php"> <button class="Opt_Buttons_back" >Back</button>
    </a>
</div>

    

</body>
</html>
