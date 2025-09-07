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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($user['username']); ?> Profile</title>
<link rel="stylesheet" href="Profile.css">
</head>
<body>

<div class="profile-header">
    <h1><?php echo htmlspecialchars($user['username']); ?>'s Profile</h1>
    <img src="<?php echo $user['profile_pic']; ?>" alt="Profile" class="profile-pic">
    <p><?php echo htmlspecialchars($user['bio']); ?></p>
</div>

<h2>Posts</h2>

<div class="posts-container">
<?php
if(mysqli_num_rows($posts_result) > 0){
    while($post = mysqli_fetch_assoc($posts_result)) {
        echo "<div class='Post_body'>";
        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
        echo "<time datetime='" . date('c', strtotime($post['timestampt'])) . "'>Posted on " . date("F j, Y \\a\\t g:i A", strtotime($post['timestampt'])) . "</time>";
        echo "</div>";
    }
} else {
    echo "<p>No approved posts yet.</p>";
}
?>
</div>

</body>
</html>
