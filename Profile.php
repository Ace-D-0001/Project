<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="Profile.css">
   <title>User_Profile</title>
</head>
<?php
session_start();
$host = "localhost";
$user = "root";   
$pass = "";
$db = "project";
$conn = mysqli_connect($host, $user, $pass, $db);

$dp = "data:image/jpeg;base64,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";  
$cover = "https://pbs.twimg.com/media/FA9Yil9UUAc_HAV.jpg:large";
$bio = "---";
$username = "Guest";

  // if (isset($_SESSION["username"]) && isset($_SESSION["hash"])) {
      $username = $_SESSION['username'];
      $password = $_SESSION['hash'];
      $sql = "SELECT *FROM basic_user_info Where name='$username' and password='$password' ";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      if ($row) {
         $dp = $row["profile_pic"];
         $cover = $row["cover_pic"];
         $bio = $row["bio"];
   //      $username = $row["username"];
      

 //  }
}
?>
<style>
   .cover_photo {
      background-image: url('<?php echo $cover; ?>');
      background-size: cover;
      background-position: center;
      height: 550px;
      width: 100%;
      
   }
</style>

<body>
   <input type="checkbox" id="popup-toggle" hidden>

   <div>
      <header class="top-bar">
         <div class="logo">Faked_It</div>

      </header>
      <div class="Top">
         <div class="Inner_top">
            <a href="Feed.php">
               <div class="Sub_top">
                  <div class="logo">🏠</div>
                  <div class="Logo_text">
                     <p>Home</p>
                  </div>
               </div>
            </a>
            <a href="Profile.php">
               <div class="Sub_top">
                  <div class="logo">🙍🏻‍♂️</div>
                  <div class="Logo_text">
                     <p>- User</p>
                  </div>
               </div>
            </a>
            <div class="Log_Out">
               <div class="logo">⏻</div>
               <div class="Logo_text">
                  <p>Log_Out</p>
               </div>
            </div>
         </div>
      </div>

      <div class="cover_photo"></div>
      <div class="DP">
         <div>
            <img class="dp_img" src="<?php echo $dp; ?>" alt="">
         </div>
         <div class="User_name">
            <p>
            <p><?php echo htmlspecialchars($username); ?></p>
            </p>
         </div>
         <div class="User_Discpritatio ">
            <p><?php echo htmlspecialchars($bio); ?></p>
         </div>
      </div>

      <div class="Posts">
         <h1>_Posts_:</h1>
      </div>

     

      <div class="Post_body">

         <img src="<?php echo $dp; ?>" alt="">
         <div class="post_text">
            <p><?php echo htmlspecialchars($username); ?></p>
            <time datetime="2025-07-21T01:40">Posted on July 21, 2025 at 1:40 AM</time>
            <div class="post_Content">
               <p>Random Paragraph
                  For those who are interested in finding random paragraphs, that's exactly what this webpage provides.
                  If both a random word and a random sentence aren't quite long enough for your needs, then a random
                  paragraph might be the perfect solution. Once you arrive at this page, you'll see a random paragraph.
                  If you need another one, all you need to do is click on the "next paragraph" button. If you happen to
                  need several random paragraphs all at once, you can use this other paragraph generator. Below you can
                  find a number of ways that this generator can be used.
            </div>
            <div class="delete-btn">🗑️</div>
         </div>
         <div class="more_posts">
            <label for="popup-toggle" class="xo">
               <p><strong>+</strong> _post_something_</p>
            </label>
         </div>
      </div>



   </div>
   <div class="popup_overlay">
      <div class="id_pop">
         <textarea placeholder="...Write here..." class="Post_Box"></textarea>
         <div class="Post_Button_main">
            <button class="Post_Button1">Post</button>
            <label for="popup-toggle" class="Post_Button2">Close</label>
         </div>
      </div>
   </div>

</body>

</html>
