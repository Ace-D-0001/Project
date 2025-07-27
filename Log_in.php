<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Faked_It - Log_in</title>
    <link rel="stylesheet" href="sign_up.css" />
    <link rel="stylesheet" href="Log_in.php">
</head>
<?php
 session_start();
   $host = "localhost";      
$user = "root";          
$pass = "";              
$db = "project";  
$conn = mysqli_connect($host, $user, $pass, $db);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username=($_POST["username"]);

$password=($_POST["password"]);
$hash=hash("sha256",$password);
$sql="SELECT * From basic_user_info where name='$username' and password ='$hash'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) == 1) {

    $_SESSION['username']=$username;
    header("Location:Feed.php");
    exit;

}
else {
    echo "Invalid username or password.";
}
}
?>
<body>

    <header class="top-bar">
        <div class="logo">Faked_It</div>
    </header>

    <main id="container">
        
        <p>Welcome! </p>
       <p>Please Enter your user name and password.</p>
        <form class="user" action="Log_in.php" autocomplete="off" method='POST'>
            <div class="user_name">
                <label for="username">Username:</label>
                <input id="username" name="username" type="text" required  />
            </div>


            <div class="user_pass">
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required />
            </div>

         

            <div class="Submit">
                <button type="submit" name="Submit">Sign Up</button>
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

        <a href="admin.html">
            <h6>Are you an administrator?</h6>
            <button type="button">Admin Login</button>
        </a>
    </section>

</body>
</html>
