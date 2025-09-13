    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="pro.css">
        <title>User_Profile</title>
    </head>
    <style>
        
    </style>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $host = "localhost";
    $user = "ace";   
    $pass = "your_password";
    $db = "project";
    $conn = mysqli_connect($host, $user, $pass, $db);

    $dp = "";  
    $cover = "https://pbs.twimg.com/media/FA9Yil9UUAc_HAV.jpg:large";
    $bio = "---";
    $username = "Guest";
    $user_id=21;
    if (isset($_SESSION["username"]) && isset($_SESSION["hash"])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['hash'];
        
        $sql = "SELECT *FROM basic_user_info Where username='$username' and password='$password' ";
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
        
    if(isset($_POST['post_submit'])){
        $post_content=trim($_POST['post_content']);
        if(empty($post_content)){
            $error = "Error: Cannot post an empty message!";
        }
      
        else {
            $user_sql="SELECT profile_pic FROM basic_user_info WHERE username='$username' AND password= '$password'";
            $user_result=mysqli_query($conn,$user_sql);
            $user_data=mysqli_fetch_array($user_result);

            $user_profile_pic=$user_data['profile_pic'];
            
            $insert_sql = "INSERT INTO posts (user_id, user_name, profile_image, content, timestampt, status, upvotes, downvotes) 
                            VALUES ('$user_id', '$username', '$user_profile_pic', '$post_content', NOW(), 'approved', 0, 0)";
            mysqli_query($conn, $insert_sql);
            $post_content ="";
        }
    }
    
        if (isset($_GET['del'])){
            $post_id = intval($_GET['del']);

            $del_sql="delete from posts  where id=$post_id  ";  
          
            
        if (mysqli_query($conn, $del_sql)) {
        header("Location: Profile.php?user_id=" . $user_id);
        exit();
          } else {
        echo "❌ Error deleting record: " . mysqli_error($conn);
        }
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

            <div class="cover_photo"> </div>
            <div class="DP">
                <div>
                    <img class="dp_img" src="<?php echo $dp; ?>" alt="">
                </div>
                <div class="User_name">
                    
                    <p><?php echo htmlspecialchars($username); ?></p>
                    
                </div>
                <div class="User_Discpritatio ">
                    <p><?php echo htmlspecialchars($bio); ?></p>
                </div>
            </div>
            
            <div class="Posts">
                <h1>Wanna_Post_Something:</h1>
            </div>
            <div class="id_pop">
                <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form method="POST" action="Profile.php">
                    <textarea name="post_content" placeholder="...Write here..."
                        class="Post_Box"><?php if(isset($post_content)) echo htmlspecialchars($post_content); ?></textarea>
                    <div class="Post_Button_main">
                        <button type="submit" name="post_submit" class="Post_Button1">Post</button>
                        <button type="button" class="Post_Button1" onclick="window.location.reload();">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- <div class="Posts">
            <h1>_Posts_:</h1>
        </div>
    -->

        <?php
        $post_count_sql = "SELECT COUNT(*) as total FROM posts WHERE user_id='$user_id'";
        $post_count_result = mysqli_query($conn, $post_count_sql);
        $post_count_row = mysqli_fetch_assoc($post_count_result);
        $total_posts = $post_count_row['total'];

        
        $posts_sql = "SELECT * FROM posts WHERE user_id='$user_id' ORDER BY timestampt DESC";
        $posts_result = mysqli_query($conn, $posts_sql);
        ?>
        <div class="Posts">
            <h1>_Posts_:</h1>
            <h3>Total posts: <?php echo $total_posts; ?></h3>
        </div>


        <?php
        if (mysqli_num_rows($posts_result) > 0) {
        while ($post = mysqli_fetch_assoc($posts_result)) {
            ?>
        <div class="Post_body">
    <div class="post_main">
        <img src="<?php echo htmlspecialchars($post['profile_image']); ?>" alt="">
        <div class="post_text">
            <p><?php echo htmlspecialchars($post['user_name']); ?></p>
            <time datetime="<?php echo date('c', strtotime($post['timestampt'])); ?>">
                Posted on <?php echo date("F j, Y \\a\\t g:i A", strtotime($post['timestampt'])); ?>
            </time>
            <div class="post_Content">
                <p><?php echo htmlspecialchars($post['content']); ?></p>
            </div>
        </div>
    </div>
            <style>
                .Post_body {
  display: flex;
  justify-content: space-between; /* push delete button to far right */
  align-items: flex-start; /* align everything to top */
  background-color: #161515;
  border-radius: 20px;
  padding: 15px 20px;
  margin: 20px auto;
  color: #eee;
  box-shadow: 0 4px 8px rgba(0,0,0,0.4);
  width: 90%;
}

.post_main {
  display: flex;
  gap: 15px; /* space between image & text */
}

.post_text {
  display: flex;
  flex-direction: column;
}

.Post_body img {
  width: 75px;
  height: 75px;
  border-radius: 50%;
}

.delete-btn {
  font-size: 24px;
  color: #aaa;
  background: none;
  border: none;
  cursor: pointer;
  transition: color 0.2s ease;
}

.delete-btn:hover {
  color: red; /* highlight on hover */
}

</style>
    <form action="Profile.php" method="get">
        <input type="hidden" name="del" value="<?php echo $post['id']; ?>">
        <button type="submit" class="delete-btn">🗑️</button>
    </form>
</div>

        <?php
        }
    } else {
        echo "<p>No posts yet.</p>";
    }
    ?>



        </div>


    </body>

    </html>