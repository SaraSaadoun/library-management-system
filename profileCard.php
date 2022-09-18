<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        exit;
    }
    $conn = mysqli_connect('localhost', 'root', '', 'lib');
    if(!$conn){
        echo mysqli_connect_error();
        exit;
    }
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $q = "select * from users where id = ".$id." limit 1";
    $res = mysqli_query($conn, $q); 
    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/moreinfo.css">

    <link rel="stylesheet" href="css/profile.css">

</head>
<body>
    <header>
            <div class="logo-section">
                    <img class="logo"src="imgs/logo.png">
                    <span><a class="header-name" href="home.php">Online Library</a></span>
            </div>
            <div class="upper-right-btns">
                <a class="profile" href="profileCard.php?id=<?=$row['id']?>"><img class="profile-img"src="imgs/users/<?=$row['avatar']?>"></a>
                <a class="logout" href="logout.php">Logout</a>
            </div>
    </header>
    <div class="bg">
        <div class="card">
            <img class="card-img" src="imgs/users/<?=$row['avatar']?>">
            <div class="info-container">                
                <p class="info">
                    <span class="property">Name  </span>
                    <span class="value"><?=$row['name'] ?></span>
                </p>   
                <p class="info">
                    <span class="property">Email  </span>
                    <span class="value"><?=$row['email']?></span>
                </p>
                <p class="info">
                    <a href = "profileEdit.php?id=<?$row['id']?>">Edit</a>
                </p>
            </div>
        </div>
    </div>
    <footer>All copyrights are preserved CC <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script></footer>

</body>
</html>