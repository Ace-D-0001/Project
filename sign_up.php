<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Faked_It - Sign Up</title>
    <link rel="stylesheet" href="sign_up.css" />
</head>
 <?php
 session_start();
  $host = "localhost";      
$user = "root";          
$pass = "";              
$db = "project";         
$conn = mysqli_connect($host, $user, $pass, $db);
$show_otp_box=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username=($_POST["username"]);
        $email=($_POST["email"]);
        $password=($_POST["password"]);
        $Confirm_password=($_POST["Confirm_password"]);
  
    if(empty($username)||empty($email)||empty($password)||empty($Confirm_password)){
        echo"Input cant' be Empty";
    exit;
    }
    if($password!==$Confirm_password)
    {
         echo"password not matched";
         exit;
    }
    $c = "SELECT * FROM basic_user_info WHERE email='$email'";
    $result=mysqli_query($conn,$c);
 if (mysqli_num_rows($result) > 0) {
    echo "This email is already registered <br> Try a new one.";
    exit;
}

    $hash=hash("sha256",$password);
    $insert = "INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$hash')";
    $Otp = rand(1000, 9999);
    require 'send_mail.php'; // ✅ include the mail function

    if (send_otp_mail($email, $Otp)) {
        $_SESSION['otp'] = $Otp;         // store OTP for checking later
        $_SESSION['email'] = $email;     // optional, for later verification
        $show_otp_box = true;
    } else {
        echo "❌ OTP Email sending failed.";
    }
}
    ?>
<body>
   

    <header class="top-bar">
        <div class="logo">Faked_It</div>
    </header>

    <main id="container">
        <p>Welcome Strenger ! </p>
       <p>Please sign up to create your Faked_It account.</p>
        <form class="user" action="" autocomplete="off" method='POST'>
   
            <div class="user_name">
                <label for="username">Username:</label>
                <input id="username" name="username" type="text"  required/>
            </div>

            <div class="user_mail">
                <label for="email">Email:</label>
                <input id="email" name="email" type="email"  required />
            </div>

            <div class="user_pass">
                <label for="password">Password:</label>
                <input id="password" name="password"  type="password" required />
            </div>
               <div class="user_pass">
                <label for="Confirm_password">Confirm_password:</label>
                <input id="Confirm_password" name="Confirm_password" type="password" required />
            </div>


            <div class="Submit">
                <a href="Profile.php"><button type="submit">Sign Up</button></a>
            </div>
        </form>
    </main>
 <?php if ($show_otp_box): ?>
<div class="opt">
  <form action="check_otp.php" method="POST">
    <h3>Enter OTP</h3>
    <input type="text" name="otp_input" placeholder="Go to your Email" required />
    <button type="submit">Submit</button>
  </form>
</div>
<?php endif; ?>
    <section class="Other">
        <a href="Log_in.html">
            <h6>Already have an account?</h6>
            <button type="button">Log_in</button>
        </a>

        <a href="Forgot_password.html">
            <h6>If you have Forgot your password?</h6>
            <button type="button">Reset Password</button>
        </a>

        <a href="admin.html">
            <h6>Are you an administrator?</h6>
            <button type="button">Admin Login</button>
        </a>
    </section>

</body>
</html>
