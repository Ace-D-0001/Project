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
    $error= null ;
$conn = mysqli_connect($host, $user, $pass, $db);

if( $_SERVER["REQUEST_METHOD"] == "POST"){
    $username= ($_POST["username"]);
$password= ($_POST["password"]);


if ($username == "admin" AND $password == "admin") {
    header("Location: Admin_pannel.php");
    exit;
    }
    else {  
    $error= 1;
   
}
}
?>
<body>

    <header class="top-bar">
        <div class="logo">Faked_It</div>
    </header>
    
    <main id="container">
        <p>Ola_Admin! </p>
       <p> Enter your user name and .</p>
       <?php  if($error== 1) : ?>
            <div style="color:red; font-weight:bold; margin-bottom:10px;">
            Invalid username of password 
            </div>  
            <?php endif;  ?>
        <form class="user" action="" method="post" autocomplete="off">
            <div class="user_name">
                <label for="username">Username:</label>
                <input id="username" name="username" type="text" required />
            </div>


            <div class="user_pass">
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required  />
            </div>

             

            
            
            <div class="Submit">
                <button type="submit">Sign Up</button>
            </div>
        </form>
    </main>

    <section class="Other">
        <a href="sign_up.html">
            <h6>Want to create an account?</h6>
            <button type="button">sign_up </button>
        </a>

        <a href="Forgot_password.html">
            <h6>If you have Forgot your password?</h6>
            <button type="button">Reset Password</button>
        </a>

        <a href="Log_in.html">
            <h6>Already have an account?</h6>
            <button type="button">Log_in</button>
        </a>
    </section>

</body>
</html>
