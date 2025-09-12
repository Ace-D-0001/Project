<?php
session_start();

// Database connection
$host = "localhost";
$user = "ace";
$pass = "your_password";
$db   = "project";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

// Must be logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['hash'])) {
    die("You must be logged in to access the chat. <a href='Log_in.php'>Login</a>");
}

// Get user info from DB
$username = $_SESSION['username'];
$password = $_SESSION['hash'];

$sql_user = "SELECT id, profile_pic FROM basic_user_info WHERE username='$username' AND password='$password'";
$res_user = mysqli_query($conn, $sql_user);
if (!$res_user || mysqli_num_rows($res_user) == 0) {
    die("Invalid session. Please <a href='Log_in.php'>login again</a>.");
}
$user_row   = mysqli_fetch_assoc($res_user);
$user_id    = $user_row['id'];
$profile_pic = $user_row['profile_pic'];

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['message']))) {
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));
    
    if (strlen($message) > 1000) {
        die("Message too long!");
    }
    
    $insert_sql = "INSERT INTO group_chat (user_id, message, timestampt) VALUES ('$user_id', '$message', NOW())";
    if (mysqli_query($conn, $insert_sql)) {
        header("Location: gc.php");
        exit();
    } else {
        die("Failed to send message: " . mysqli_error($conn));
    }
}

// Pagination setup
$messages_per_page = 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// Get total number of messages
$total_query = "SELECT COUNT(*) as total FROM group_chat";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_messages = $total_row['total'];

// If no offset is provided (initial load), set it to show the last page of messages
if (!isset($_GET['offset'])) {
    $offset = max(0, $total_messages - $messages_per_page);
}

// Calculate which messages to show
$messages_to_show = min($messages_per_page, $total_messages - $offset);
$start_from = $offset;

// Fetch messages for current page
$query = "
    SELECT gc.id, gc.message, gc.timestampt, gc.user_id, u.username, u.profile_pic 
    FROM group_chat gc
    JOIN basic_user_info u ON gc.user_id = u.id
    ORDER BY gc.timestampt ASC
    LIMIT $start_from, $messages_to_show
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if there are more older messages
$has_more_messages = ($offset + $messages_per_page) < $total_messages;
$can_go_previous = $offset > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <link rel="stylesheet" href="Profile.css">    
   <!-- <link rel="stylesheet" href="gc.css">
-->
  </head>

<body>
    <style>
      .top-bar {
    width: 96%; 
    
    background-color: #1f1f1f;  
    padding: 15px 40px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);

    display: flex;
    align-items: center;
    justify-content: flex-start; 
   
    margin-bottom: -10px;

}
        body {
            background-color: #111;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 80vh;
            max-width: 1200px;
            margin: 0 auto;
            background: #222;
            border-radius: 10px;
            overflow: hidden;
        }
        .chat-header {
            background: #1f1f1f;
            padding: 15px 20px;
            border-bottom: 1px solid #333;
            text-align: center;
        }
        .chat-header h2 {
            color: #00bfff;
            margin: 0;
        }
        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        .load-more, .load-previous {
            border: none;
            padding: 12px 25px;
            border-radius: 15px;
            cursor: pointer;
            margin: 10px auto;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        .load-more {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            margin-bottom: 20px;
            border: 2px solid #ff6b6b;
        }
        .load-more:hover {
            background: linear-gradient(135deg, #ee5a52, #dc4545);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 107, 107, 0.4);
            color: white;
        }
        .load-previous {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
            margin-bottom: 10px;
            border: 2px solid #4ecdc4;
        }
        .load-previous:hover {
            background: linear-gradient(135deg, #44a08d, #3a8f7a);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(78, 205, 196, 0.4);
            color: white;
        }
        .message {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
            max-width: 100%;
        }
        .message img {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            margin-right: 10px;
            border: 2px solid #1f1f1f;
            object-fit: cover;
            flex-shrink: 0;
        }
        .message-content {
            background: #1f1f1f;
            padding: 10px 15px;
            border-radius: 12px;
            color: #eee;
            max-width: 70%;
            word-wrap: break-word;
        }
        .username {
            font-size: 14px;
            font-weight: bold;
            color: #00bfff;
            margin: 0 0 5px 0;
        }
        .message-text {
            margin: 5px 0;
            line-height: 1.4;
        }
        .time {
            font-size: 11px;
            color: #aaa;
            margin-top: 5px;
            display: block;
        }
        .chat-input {
            border-top: 1px solid #333;
            background: #1f1f1f;
            padding: 15px;
        }
        .chat-input form {
            display: flex;
            width: 100%;
        }
        .chat-input input {
            flex: 1;
            padding: 12px 15px;
            border-radius: 25px;
            border: none;
            background: #272626;
            color: #eee;
            font-size: 14px;
            margin-right: 10px;
        }
        .chat-input input:focus {
            outline: none;
            background: #333;
        }
        .chat-input button {
            background: #00bfff;
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            cursor: pointer;
            font-weight: bold;
        }
        .chat-input button:hover {
            background: #0099cc;
        }
        .no-messages {
            text-align: center;
            color: #888;
            font-style: italic;
            margin: 50px 0;
        }
    </style>

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
                    <div class="Logo_text"><p>Chat Room</p></div>
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

    <div class="chat-container">
        <div class="chat-header">
            <h2>💬 Group Chat</h2>
            <p style="color: #aaa; margin: 5px 0 0 0; font-size: 14px;">
                Logged in as: <?= htmlspecialchars($username) ?>
            </p>
        </div>

        <div class="chat-messages">
            <?php if($can_go_previous): ?>
                <?php $new_offset = max(0, $offset - $messages_per_page); ?>
                <a href="gc.php?offset=<?= $new_offset ?>" class="load-previous">⬆️ NEWER MESSAGES ⬆️</a>
            <?php endif; ?>

            <?php if($total_messages > $messages_per_page && $offset < ($total_messages - $messages_per_page)): ?>
                <?php $new_offset = $offset + $messages_per_page; ?>
                <a href="gc.php?offset=<?= $new_offset ?>" class="load-more">⬇️ OLDER MESSAGES ⬇️</a>
            <?php endif; ?>

            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="message">
                        <img src="<?= htmlspecialchars($row['profile_pic']) ?>" 
                             alt="<?= htmlspecialchars($row['username']) ?>" 
                             onerror="this.src='https://via.placeholder.com/45?text=<?= substr($row['username'], 0, 1) ?>'">
                        <div class="message-content">
                            <p class="username"><?= htmlspecialchars($row['username']) ?></p>
                            <p class="message-text"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                            <span class="time"><?= date('M j, h:i A', strtotime($row['timestampt'])) ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-messages">
                    <p>No messages yet. Be the first to say something! 👋</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="chat-input">
            <form method="POST" action="gc.php">
                <input type="text" name="message" placeholder="Type a message..." required maxlength="1000" autocomplete="off">
                <button type="submit">Send 📤</button>
            </form>
        </div>
    </div>

</body>
</html>

<?php mysqli_close($conn); ?>
