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

    $cover = "https://pbs.twimg.com/media/FA9Yil9UUAc_HAV.jpg:large";
    $bio = "---";
    $username = "Guest";
    $user_id = 0; 

    if (isset($_SESSION['username']) && isset($_SESSION['hash'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['hash'];

        $sql = "SELECT * FROM basic_user_info WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $dp = $row["profile_pic"];
            $cover = $row["cover_pic"];
            $bio = $row["bio"];
            $user_id = $row["id"];
        }
    }

    // Pagination settings
    $per = 10; // posts per page
    $page = 0;

    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);  // current page number
        if ($page < 0) {
            $page = 0;
        }
    }

    $start = $page * $per; // calculate starting post

    // Count total approved posts
    $post_count_sql = "SELECT COUNT(*) AS total FROM posts WHERE status='approved'";
    $post_count_result = mysqli_query($conn, $post_count_sql);
    $post_count_row = mysqli_fetch_assoc($post_count_result);
    $total_posts = $post_count_row['total'];

    // Fetch posts for current page
    $post_sql = "SELECT * FROM posts WHERE status='approved' ORDER BY timestampt DESC limit $start,$per";
    $post_result = mysqli_query($conn, $post_sql);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Profile.css">
    <title>Feed</title>
    </head>
    <body>
        <header class="top-bar">
            <div class="logo">Faked_It</div>
        </header>

        <div class="Top">
            <div class="Inner_top">
                <a href="Profile.php">
                    <div class="Sub_top">
                        <div class="logo">🏠</div>
                        <div class="Logo_text"><p>Home</p></div>
                    </div>
                </a>
                <a href="Feed.php">
                    <div class="Sub_top">
                        <div class="logo">🙍🏻‍♂️</div>
                        <div class="Logo_text"><p>- User</p></div>
                    </div>
                </a>
                <a href="logout.php">
                    <div class="Log_Out">
                        <div class="logo">⏻</div>
                        <div class="Logo_text"><p>Log_Out</p></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="Posts_page">
            <h1>_Posts_:</h1>
        </div>
        <div class="search" name="search">
        <input type="search" placeholder="Look for posts">
        </div>
<?php
        // Output posts
        while ($post = mysqli_fetch_assoc($post_result)) {
            echo "<div class='Post_body'>";
            echo "<img src='" . htmlspecialchars($post['profile_image']) . "' alt='Profile'>";
            echo "<div class='post_text'>";
            echo "<p><strong>" . htmlspecialchars($post['user_name']) . "</strong></p>";
            echo "<time datetime='" . date('c', strtotime($post['timestampt'])) . "'>Posted on " . date("F j, Y \\a\\t g:i A", strtotime($post['timestampt'])) . "</time>";
            echo "<div class='post_Content'><p>" . nl2br(htmlspecialchars($post['content'])) . "</p></div>";
            echo "</div></div>";
        }
        ?>
        <!-- Pagination -->
        <div class="page">
            <?php
            if ($page > 0) {
                echo '<a href="?page=' . ($page - 1) . '">⬅ Previous</a> ';
            }

            if ($start + $per < $total_posts) {
                echo '<a href="?page=' . ($page + 1) . '">Next ➡</a>';
            }
            ?>
        </div>
    </body>
    </html>
