
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

        
            $sort='ORDER BY timestampt DESC';
    
        if (isset($_GET['Lesest'])){
        $sort='ORDER BY timestampt DESC';
        }
        else if (isset($_GET['Oldest'])){
            $sort='ORDER BY timestampt ASC';
        }
        else if (isset($_GET['Top'])){
        $sort='ORDER BY upvotes ASC';   
            }
            /* else if (isset($_GET['Goo'])){
            $sort= "search_user";
            }*/
    /* else if (isset($_POST['Most'])){
            }
            */

            if (isset($_GET['search_posts']) && !empty($_GET['search_posts'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search_posts']);
        $post_sql = "SELECT * FROM posts WHERE status='approved' AND content LIKE '%$search%' ORDER BY timestampt DESC LIMIT $start,$per";
        //$post_result = mysqli_query($conn, $post_sql);
        } 


        else {
    $post_sql = "SELECT * FROM posts 
                    WHERE status='approved' 
                    $sort LIMIT $start,$per";
        }
        

    //  $post_sql = "SELECT * FROM posts WHERE status='approved' ORDER BY timestampt DESC limit $start,$per";
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
                    <a href="gc.php">
                        <div class="Sub_top">
                            <div class="logo">💬</div>
                            <div class="Logo_text"><p>Char Room</p></div>
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
                <div class="search_wrap">
                <div class="search-box">
                    <h3>Look for Posts</h3>
                    
            <div class="search" name="search">
            <form action="Feed.php" method="get">
            <input class="search_posts" name="search_posts" type="text" placeholder="Look for posts"required>
            <button class ="Goo" type="submit">Gooooooooooo</button>
            </form>
            </div>
        </div>
        <div class="search-box">
            <h3>Look for users</h3>
            <div class="search" name="search">
                <form action="search_user.php" method="get">

        <input type="text" name="username" placeholder="Search username" required>
        <button type="submit">Search</button>
    </form>
                <!--<form action="Feed.php" method="get">
            <input class="search_user" name="search_user" type="search" placeholder="Look for a user">
            <button class ="Goo">Gooooooooooo</button>
    -->
        
        <!--  </form>-->
        </div>
            </div>
        </div>

        
    <style>
    .search_wrap {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 10px;
    }

    .search-box ,search-box{
        flex: 1;
        background-color: #222;
        border-radius: 15px;
        padding: 15px;
        color: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }

    .search-box h3,search-box h3 {
        margin-bottom: 10px;
        font-size: 18px;
        color: wheat;
    }


    .search {
        display: flex;
        gap: 10px;
    }

    .search_posts,
    .search_user {
        width: 150px; 
        flex: 1;
        background-color: black;
        border-radius: 20px;
        color: white;
        padding: 10px;
        border: none;
        outline: none;
    }

    .search_posts::placeholder,
    .search_user::placeholder {
        color: wheat;
    }

    .Goo {
        color: white;
        background-color: black;
        border-radius: 20px;
        cursor: pointer;
        padding: 10px 15px;
        border: none;
        transition: 0.3s;
    }

    .Goo:hover {
        background-color: #111;
    }
    .Sort_by{
        display: flex   ;
        justify-content: center;
    }
    .s_but{
    
        color: white;
        background-color: #111  ;
        width: 300px;
        
        
    }
    .s_but:hover{
        background-color: aliceblue;
        color: black;
    }
    .Sort_By{
    text-align: center;
        background-color: #161515;
        border-radius: 30px; 
        padding: 0px 0px;   
        margin-left: 80px;
        margin-right: 80px;
    color: #eee;  
    box-shadow: 0 4px 8px rgba(0,0,0,0.4);
    margin-top: 40px ;
    margin-bottom: 50px;
    top: 74px;
    font-size: 10px;
    } 

    </style>    
            <div class="Posts_page">
                <h1>_Posts_:</h1>
            </div>
            <div class="Sort_By">
                <h1>Sort By :</h1>
                </div>
            <div class="Sort_by">
                <form action="Feed.php" method="Get">
                <Button class="s_but"  name="Lesest">Lesest</Button>
                <Button class="s_but"  name="Oldest">Oldest</Button>
                <Button class="s_but"  name="Top">Top reated</Button>
                <Button class="s_but"  name="Most">Most liked</Button>
                </form>
                
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
    <!--
    -- 1. Create the database
    CREATE DATABASE IF NOT EXISTS project;
    USE project;

    -- 2. Create table for users
    DROP TABLE IF EXISTS basic_user_info;
    CREATE TABLE basic_user_info (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        profile_pic VARCHAR(255),
        cover_pic VARCHAR(255),
        bio VARCHAR(255)
    );

    -- 3. Create table for posts
    DROP TABLE IF EXISTS posts;
    CREATE TABLE posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        user_name VARCHAR(50) NOT NULL,
        profile_image VARCHAR(255),
        content TEXT NOT NULL,
        timestampt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        upvotes INT DEFAULT 0,
        downvotes INT DEFAULT 0,
        FOREIGN KEY (user_id) REFERENCES basic_user_info(id) ON DELETE CASCADE
    );

    -- 4. Insert sample users
    INSERT INTO basic_user_info (id, username, password, email, profile_pic, cover_pic, bio) VALUES
    (1, 'arif',   SHA2('12345',256), 'arif@example.com',   'https://i.pravatar.cc/150?img=1',  'https://picsum.photos/600/200?random=1',  'Love coding and coffee'),
    (2, 'nabila', SHA2('12345',256), 'nabila@example.com', 'https://i.pravatar.cc/150?img=2',  'https://picsum.photos/600/200?random=2',  'Traveler and foodie'),
    (3, 'kamal',  SHA2('12345',256), 'kamal@example.com',  'https://i.pravatar.cc/150?img=3',  'https://picsum.photos/600/200?random=3',  'Dreaming big'),
    (4, 'tania',  SHA2('12345',256), 'tania@example.com',  'https://i.pravatar.cc/150?img=4',  'https://picsum.photos/600/200?random=4',  'Bookworm'),
    (5, 'rakib',  SHA2('12345',256), 'rakib@example.com',  'https://i.pravatar.cc/150?img=5',  'https://picsum.photos/600/200?random=5',  'Football lover'),
    (6, 'mehedi', SHA2('12345',256), 'mehedi@example.com', 'https://i.pravatar.cc/150?img=6',  'https://picsum.photos/600/200?random=6',  'Tech enthusiast'),
    (7, 'sumaiya',SHA2('12345',256), 'sumaiya@example.com','https://i.pravatar.cc/150?img=7',  'https://picsum.photos/600/200?random=7',  'Nature lover'),
    (8, 'sajid',  SHA2('12345',256), 'sajid@example.com',  'https://i.pravatar.cc/150?img=8',  'https://picsum.photos/600/200?random=8',  'Music is life'),
    (9, 'anika',  SHA2('12345',256), 'anika@example.com',  'https://i.pravatar.cc/150?img=9',  'https://picsum.photos/600/200?random=9',  'Writer'),
    (10,'fahim',  SHA2('12345',256), 'fahim@example.com',  'https://i.pravatar.cc/150?img=10', 'https://picsum.photos/600/200?random=10', 'Gamer'),
    (11,'mim',    SHA2('12345',256), 'mim@example.com',    'https://i.pravatar.cc/150?img=11', 'https://picsum.photos/600/200?random=11', 'Artist'),
    (12,'rony',   SHA2('12345',256), 'rony@example.com',   'https://i.pravatar.cc/150?img=12', 'https://picsum.photos/600/200?random=12', 'Always learning'),
    (13,'sadia',  SHA2('12345',256), 'sadia@example.com',  'https://i.pravatar.cc/150?img=13', 'https://picsum.photos/600/200?random=13', 'Cooking lover'),
    (14,'jahid',  SHA2('12345',256), 'jahid@example.com',  'https://i.pravatar.cc/150?img=14', 'https://picsum.photos/600/200?random=14', 'Cyclist'),
    (15,'lima',   SHA2('12345',256), 'lima@example.com',   'https://i.pravatar.cc/150?img=15', 'https://picsum.photos/600/200?random=15', 'Cat mom'),
    (16,'shanto', SHA2('12345',256), 'shanto@example.com', 'https://i.pravatar.cc/150?img=16', 'https://picsum.photos/600/200?random=16', 'Photography'),
    (17,'priya',  SHA2('12345',256), 'priya@example.com',  'https://i.pravatar.cc/150?img=17', 'https://picsum.photos/600/200?random=17', 'Dream chaser'),
    (18,'saif',   SHA2('12345',256), 'saif@example.com',   'https://i.pravatar.cc/150?img=18', 'https://picsum.photos/600/200?random=18', 'Fitness addict'),
    (19,'maria',  SHA2('12345',256), 'maria@example.com',  'https://i.pravatar.cc/150?img=19', 'https://picsum.photos/600/200?random=19', 'Coffee lover'),
    (20,'tamim',  SHA2('12345',256), 'tamim@example.com',  'https://i.pravatar.cc/150?img=20', 'https://picsum.photos/600/200?random=20', 'Cricket fan'),
    (21,'test',   SHA2('123456',256),'test@example.com',   'https://i.pravatar.cc/150?img=21', 'https://picsum.photos/600/200?random=21', 'This is a test account');

    -- 5. Insert sample posts
    INSERT INTO posts (id, user_id, user_name, profile_image, content, timestampt, status, upvotes, downvotes) VALUES
    (1, 1, 'arif',    'https://i.pravatar.cc/150?img=1',  'Just finished my first PHP project!',        '2025-09-04 03:35:01', 'approved', 5, 0),
    (2, 2, 'nabila',  'https://i.pravatar.cc/150?img=2',  'Travelled to Coxs Bazar – amazing views!',   '2025-09-04 03:35:01', 'approved', 12, 1),
    (3, 3, 'kamal',   'https://i.pravatar.cc/150?img=3',  'Started learning Laravel today',             '2025-09-04 03:35:01', 'approved', 8, 0),
    (4, 4, 'tania',   'https://i.pravatar.cc/150?img=4',  'Reading a new mystery novel',                '2025-09-04 03:35:01', 'approved', 6, 0),
    (5, 5, 'rakib',   'https://i.pravatar.cc/150?img=5',  'Played football with friends',               '2025-09-04 03:35:01', 'approved', 15, 2),
    (6, 6, 'mehedi',  'https://i.pravatar.cc/150?img=6',  'Building a portfolio website',               '2025-09-04 03:35:01', 'approved', 7, 0),
    (7, 7, 'sumaiya', 'https://i.pravatar.cc/150?img=7',  'Nature walk in the morning',                 '2025-09-04 03:35:01', 'approved', 9, 1),
    (8, 8, 'sajid',   'https://i.pravatar.cc/150?img=8',  'Listening to my favorite playlist',          '2025-09-04 03:35:01', 'approved', 3, 0),
    (9, 9, 'anika',   'https://i.pravatar.cc/150?img=9',  'Wrote a new poem today',                     '2025-09-04 03:35:01', 'approved', 11, 0),
    (10,10,'fahim',   'https://i.pravatar.cc/150?img=10', 'Ranked up in Valorant',                      '2025-09-04 03:35:01', 'approved', 14, 2),
    (11,11,'mim',     'https://i.pravatar.cc/150?img=11', 'Painted a sunset',                           '2025-09-04 03:35:01', 'approved', 10, 0),
    (12,12,'rony',    'https://i.pravatar.cc/150?img=12', 'Learning SQL joins',                         '2025-09-04 03:35:01', 'approved', 4, 0),
    (13,13,'sadia',   'https://i.pravatar.cc/150?img=13', 'Cooked biryani today',                       '2025-09-04 03:35:01', 'approved', 18, 3),
    (14,14,'jahid',   'https://i.pravatar.cc/150?img=14', 'Cycling 15 km',                              '2025-09-04 03:35:01', 'approved', 6, 0),
    (15,15,'lima',    'https://i.pravatar.cc/150?img=15', 'My cat is sleeping so cutely',               '2025-09-04 03:35:01', 'approved', 21, 1),
    (16,16,'shanto',  'https://i.pravatar.cc/150?img=16', 'Captured the sunrise',                       '2025-09-04 03:35:01', 'approved', 13, 0),
    (17,17,'priya',   'https://i.pravatar.cc/150?img=17', 'Dreaming of traveling to Paris',             '2025-09-04 03:35:01', 'approved', 5, 0),
    (18,18,'saif',    'https://i.pravatar.cc/150?img=18', 'Leg day at the gym',                         '2025-09-04 03:35:01', 'approved', 8, 2),
    (19,19,'maria',   'https://i.pravatar.cc/150?img=19', 'Coffee and coding',                          '2025-09-04 03:35:01', 'approved', 16, 0),
    (20,20,'tamim',   'https://i.pravatar.cc/150?img=20', 'Bangladesh cricket for the win',             '2025-09-04 03:35:01', 'approved', 20, 4),
    (21,21,'test',    'https://i.pravatar.cc/150?img=21', 'Hello! I am the test account posting here',  '2025-09-04 03:35:01', 'approved', 0, 0),
    (22,21,'test',    'https://i.pravatar.cc/150?img=21', 'yo',                                         '2025-09-05 15:58:35', 'pending',  0, 0),
    (23,21,'test',    'https://i.pravatar.cc/150?img=21', 'Yo',                                         '2025-09-07 22:51:05', 'approved', 0, 0);

    -->