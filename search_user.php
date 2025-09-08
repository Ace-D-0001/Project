<?php
session_start();
$conn = mysqli_connect("localhost", "ace", "your_password", "project");

if(isset($_GET['username'])) {
    $search = mysqli_real_escape_string($conn, $_GET['username']);
    
    // Search for users with similar username
    $sql = "SELECT * FROM basic_user_info WHERE username LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
} else {
    echo "No search term provided.";
    exit();
}
?>

<style>
.search_wrap {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 10px;
}

.search-box {
    flex: 1;
    background-color: #222;
    border-radius: 15px;
    padding: 15px;
    color: white;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
}

.search-box h3 {
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
.user_results {
    display: flex;
    flex-direction: column;   
    align-items: center;     
    gap: 20px;                
    padding: 20px;
}

.user_box {
    border: 1px solid #000;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 500px;             /* wider box */
    background-color: #222;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
   
}


.user_box img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin-bottom: 10px;
}

/* Text spacing */
.user_box p {
    margin: 5px 0;
    font-size: 16px;
    color: #eee;
    
}
.user_box a {
     text-decoration: none;  /* removes the underline */
    color: inherit;  
    cursor: pointer;

}

    


</style>  
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="Profile.css">
<title>Search Results</title>
<link rel="stylesheet" href="Profile.css">
</head>
<body>
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
            <!--<form action="Feed.php" method="get">
        <input class="search_user" name="search_user" type="search" placeholder="Look for a user">
        <button class ="Goo">Gooooooooooo</button>
-->
        <form action="search_user.php" method="get">
    <input type="text" name="username" placeholder="Search username" required>
    <button type="submit">Search</button>
</form>

      <!--  </form>-->
       </div>
        </div>
       </div>

<h1>Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>
<div class="user_results">
<?php
if(mysqli_num_rows($result) > 0) {
    while($user = mysqli_fetch_assoc($result)) {
        echo "<div class='user_box'>";
        echo "<a href='user_profile.php?user_id=" . $user['id'] . "'>";
        echo "<img src='" . $user['profile_pic'] . "' alt='Profile'>";
        echo "<p>" . htmlspecialchars($user['username']) . "</p>";
        echo "<p>" . htmlspecialchars($user['bio']) . "</p>";
        echo "</a></div>";
    }
} else {
    echo "<p>No users found.</p>";
}
?>
</body>
</html>
