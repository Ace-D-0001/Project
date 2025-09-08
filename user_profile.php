<?php
session_start();
$conn = mysqli_connect("localhost", "ace", "your_password", "project");


if(isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    
    // Fetch user info
    $sql = "SELECT * FROM basic_user_info WHERE id = $user_id";
    $user_result = mysqli_query($conn, $sql);
    if(!$user_result || mysqli_num_rows($user_result) == 0) {
        echo "User not found";
        exit();
    }
    $user = mysqli_fetch_assoc($user_result);
    
    
    $posts_sql = "SELECT * FROM posts WHERE user_id = $user_id AND status='approved' ORDER BY timestampt DESC";
    $posts_result = mysqli_query($conn, $posts_sql);
} else {
    echo "User not found";
    exit();
}
$dp = !empty($user['profile_pic']) ? $user['profile_pic'] : "https://pbs.twimg.com/media/FA9Yil9UUAc_HAV.jpg:large";
$cover = !empty($user['cover_pic']) ? $user['cover_pic'] : "https://pbs.twimg.com/media/FA9Yil9UUAc_HAV.jpg:large";
$username = $user['username'];
$bio = $user['bio'];
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($user['username']); ?> Profile</title>
<link rel="stylesheet" href="pro.css">
</head>
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

            <div class="cover_photo"></div>
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
            <h1>_Posts_:</h1>
            <h3>Total posts: <?php echo $total_posts; ?></h3>
        </div>
   <?php
        if (mysqli_num_rows($posts_result) > 0) {
        while ($post = mysqli_fetch_assoc($posts_result)) {
            ?>
        <div class="Post_body">

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
        <?php
        }
    } else {
        echo "<p>No posts yet.</p>";
    }
    ?>
</div>

</body>
</html>
