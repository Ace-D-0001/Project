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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Results</title>
<link rel="stylesheet" href="Profile.css">
</head>
<body>
<h1>Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>

<?php
if(mysqli_num_rows($result) > 0) {
    while($user = mysqli_fetch_assoc($result)) {
        echo "<div class='user_box'>";
        echo "<a href='user_profile.php?user_id=" . $user['id'] . "'>";
        echo "<img src='" . $user['profile_pic'] . "' alt='Profile'>";
        echo "<p>" . htmlspecialchars($user['username']) . "</p>";
        echo "</a></div>";
    }
} else {
    echo "<p>No users found.</p>";
}
?>
</body>
</html>
