
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();

        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "project";
        $conn = mysqli_connect($host, $user, $pass, $db);
        $total_pending="select * from posts where status='pending'";
        $total_pending=mysqli_query($conn,$total_pending);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <header class="top-bar">
         <div class="logo">Faked_It</div>

      </header>
    <div class="admin-container">
        <h1>Admin Panel</h1>
        <p>Review and manage user posts.</p>
  
        <?php
        
                    while($post= mysqli_fetch_assoc($total_pending)){
        echo'<div class="post-management">

        
            <div class="post-card">
                <div class="post-header">
                    <img src="'.$post['profile_image'] .' ." alt="User DP" class="user-dp">
                    <div class="post-details">
                        <span class="username">User: '.$post['user_name'].'</span>
                        <span class="user-id">User ID: '.$post['id'].'</span>
                        <span class="post-time">Posted: ' . (new DateTime($post['timestampt']))->format('Y-m-d h:i A') . '</span>
                    </div>
                </div>

                <div class="post-content">
                    <p>'.$post['content'].'</p>
                </div>
                
            </div>';

           
        }
            ?>
             <form   method="post" action="Admin_pannel.php">
                <div class="post-actions">
                
                    <button class="accept-btn">Accept</button>
                    

                    <button class="reject-btn">Reject</button>
                </div>
             </form>
            <div class="empty-state">
                <p>No new posts to review.</p>
            </div>
            
        </div>
    </div>
</body>
</html>
