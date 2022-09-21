<?php
    //session id?
    //id
    //q for id
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
    
    $id = filter_var($_SESSION['id']);
    $q = "select * from users where id = ".$id." limit 1";

    $res = mysqli_query($conn, $q); //execute the q
    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);


    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = mysqli_escape_string($conn, $_POST['name']);
        $email = mysqli_escape_string($conn, $_POST['email']);

        $avatar = $row['avatar'];
        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/library/imgs/users';
        if($_FILES['avatar']['error'] == UPLOAD_ERR_OK){
            $tmp = $_FILES['avatar']['tmp_name'];
            $avatar = basename($_FILES['avatar']['name']);
            $path = "imgs/users/$avatar";
            move_uploaded_file($tmp, "$upload_dir/$avatar");
        }

        $q = "update users set name = '".$name."', email = '".$email."', avatar = '".$avatar."' where users.id = $id";
        if(mysqli_query($conn, $q)){
            header("Location: profileCard.php?id=$id");
            exit;
        }
        else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit My Profile</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="css/profile.css">
    

</head>
    <body>
        <header>
            <div class="logo-section">
                    <img class="logo"src="imgs/logo.png">
                    <span><a class="header-name" href="home.php">Online<br> Library</a></span>
            </div>
            <div class="upper-right-btns">
                <a class="profile" href="profileCard.php?id=<?=$row['id']?>"><img class="profile-img"src="imgs/users/<?=$row['avatar']?>"></a>
                <a class="logout" href="logout.php"><img alt="Logout" src="imgs/logout.png"></a>
            </div>
        </header>
        <div class="bg">
            <div class="card">
                <form method="post" enctype="multipart/form-data" class="edit-profile">                    
                        <img class="avatar" src="imgs/users/<?=$row['avatar']?>">
                        <div class="field">
                            <input type="file" name="avatar"  value="imgs/<?=$row['avatar']?>">
                        </div>
                        <br>
                        <div class="field">
                            <label for="name" >Name </label>
                            <input type="text" name="name" value="<?=isset($row['name'])? $row['name']:'';?>">
                        </div>
                    
                        <br>
                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?=isset($row['email'])?$row['email'] : ''?>">
                        </div>
                        <br>
                        <br>
                        <div class="field">
                            <input type="submit" name="save"  class="submit" value="Save">
                        </div>
                </form>
            </div>

        </div>
        <footer>Copyright © <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script> All Rights Reserved</footer>
        
    </body>
</html>