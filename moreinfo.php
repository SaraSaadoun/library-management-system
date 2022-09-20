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
    
    $id  = filter_var($_SESSION['id']);;

    $q = "select * from users where id = ".$id." limit 1";
    $res = mysqli_query($conn, $q); 
    $rowUser = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    
    $no =filter_input(INPUT_GET, 'no', FILTER_SANITIZE_NUMBER_INT);
    $q = "select * from books where no = $no limit 1";
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
    <title>Book Info</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/moreinfo.css">

</head>
<body>
    <header>
            <div class="logo-section">
                    <img class="logo"src="imgs/logo.png">
                    <span><a class="header-name" href="home.php">Online<br> Library</a></span>
            </div>
            <div class="upper-right-btns">
                <a class="profile" href="profileCard.php?id=<?=$rowUser['id']?>"><img class="profile-img"src="imgs/users/<?=$rowUser['avatar']?>"></a>
                <a class="logout" href="logout.php"><img alt="Logout" src="imgs/logout.png"></a>
            </div>
    </header>
    <div class="bg">
        <div class="card">
            <img src="<?=$row['photo']?>">
            <div class="info-container">                
                <p class="info">
                    <span class="property">Title  </span>
                    <span class="value"><?=$row['title'] ?></span>
                </p>   
                <p class="info">
                    <span class="property">Author  </span>
                    <span class="value"><?=$row['author']?></span>
                </p>
                <p class="info">
                    <span class="property">Edition  </span>
                    <span class="value"><?=$row['edition']?></span>
                </p>
                <p class="info">
                    <span class="property">Submission <br>Date  </span>
                    <span class="value"><?= date("M j, Y",strtotime(substr($row['submission_date'], 0, 10)));?></span>
                </p>
                <?php if($_SESSION['admin'] == 1){ ?>
                <p class="info edit">
                    <a  href="edit.php?no=<?=$row['no']?>">Edit</a>
                </p>
                <?php } ?>
            </div>
        </div>
    </div>
    <footer>Copyright © <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script> All Rights Reserved</footer>

</body>
</html>