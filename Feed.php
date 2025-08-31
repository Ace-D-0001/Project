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

$dp = "";  
$cover = "https://pbs.twimg.com/media/FA9Yil9UUAc_HAV.jpg:large";
$bio = "---";
$username = "Guest";

 
  if (isset($_SESSION["username"]) && isset($_SESSION["hash"])) {
      $username = $_SESSION['username'];
      $password = $_SESSION['hash'];
      
      $sql = "SELECT *FROM basic_user_info Where name='$username' and password='$password' ";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      
      if ($row) {
         $dp = $row["profile_pic"];
         $cover = $row["cover_pic"];
         $bio = $row["bio"];
         $user_id = $row["id"];
     }
     $error="";
}
        if(isset($_POST['load_more'])){
       
        }
  
?>
<body>
      
       
      <div>
            <header class="top-bar">
             <div class="logo">Faked_It</div>

            </header>
            <div class="Top">
            <div class="Inner_top">
           <a href="Profile.php"> <div class="Sub_top">
               <div class="logo">🏠</div>
               <div class="Logo_text"><p>Home</p></div> 
            </div>
            </a>
            <a href="Feed.php">
            <div class="Sub_top">
                 <div class="logo">🙍🏻‍♂️</div>
               <div class="Logo_text"><p>-  User</p></div> 
            </div></a>
            <a href="">
            <div class="Log_Out">
                 <div class="logo">⏻</div>
               <div class="Logo_text"><p>Log_Out</p></div> 
            </div></a>
            </div>
         </div>

            
            <div class="Posts_page">
                <h1>_Posts_:</h1>
            </div>
          
               
            <div class="Post_body">
              <?php
      
             $post_sql="SELECT * FROM posts where status = 'approved' ORDER BY timestampt DESC LIMIT 10";
             $post_result=mysqli_query($conn,$post_sql);
            
             
             while($post_data=mysqli_fetch_array($post_result)){
                $post_id=$post_data['id'];
                $post_user_id=$post_data['user_id'];
                $post_user_name=$post_data['user_name'];
                $post_profile_image=$post_data['profile_image'];
                $post_content=$post_data['content'];
                $post_time=$post_data['timestampt'];
                $post_status=$post_data['status'];
                $post_upvotes=$post_data['upvotes'];
                $post_downvotes=$post_data['downvotes'];
               }
               ?>
            
                 
                      <img src=<?php "$post_profile_image"?> alt="">
                        div class="post_text">
                 <p><?php $post_user_name?></p>
                <time datetime="2025-07-21T01:40">Posted on <?php $post_time?></time>
                    <div class="post_Content">
                     <p><?php $post_content?></p>
            </div>
                
              ?>
              
           
            </div>   
            <div class="vote-box">
            <button class="vote-btn">&#9650;</button>
            <span class="vote-count">1.2K</span>
             <button class="vote-btn">&#9660;</button>
            
             </div>
            
        <div class="load-more">
         <form action="Feed.php">
            <button  name="load_more" class="load-more-btn">Load More</button>
            <button type="button" class="Post_Button1" onclick="window.location.reload();">Close</button>
         </form>
        </div>    
      
            
</body>
</html>