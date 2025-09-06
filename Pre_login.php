<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faked_It - Sign Up</title>
    <link rel="stylesheet" href="sign_up.css" />
</head>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_SESSION['email'];
    $hash = $_SESSION['hash'];
    $username = $_SESSION['username'];

    $file = "images/";
    $bio = $_POST['bio'];
    $dpname = basename($_FILES["dp"]["name"]);
    $dpPath = $file . $dpname;
    move_uploaded_file($_FILES["dp"]["tmp_name"], $dpPath);


    $cname = basename($_FILES["cover"]["name"]);
    $cPath = $file . $cname;
    move_uploaded_file($_FILES["cover"]["tmp_name"], $cPath);

    $conn = mysqli_connect("localhost", "root", "", "project");
    $sql = "INSERT INTO basic_user_info (name, email, password, profile_pic, cover_pic, bio)
            VALUES ('$username', '$email', '$hash', '$dpPath', '$cPath', '$bio')";
    if (mysqli_query($conn, $sql)) {
        echo "Registation complicated ";
        header("Location:Log_in.php");
        exit;
    } else {
        echo "Registation failed ";
        exit;
    }
}

?>

<body>
    <header class="top-bar">
        <div class="logo">Faked_It</div>
    </header>
    <div class="Submiting_Images">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Enter your profile picture</h3>
            <input type="file" name="dp" placeholder="" accept="image/*" required />
            <h3>Enter your profile picture</h3>
            <input type="file" name="cover" placeholder="" accept="image/*" required />
            <h3>Enter your somethings about you</h3>
            <textarea placeholder="...Write some words about yourself..." class="bio" name="bio"></textarea>

            <button class="Opt_Buttons_back" type="submit">Submit</button>
        </form>
    </div>
</body>
</html>