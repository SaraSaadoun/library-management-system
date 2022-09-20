<?php
$error_fields = array();
if ($_SERVER['REQUEST_METHOD']=='POST'){
    if(!(isset($_POST['name']) && !empty($_POST['name']))){
        $error_fields[] = 'name';
    }
    if(!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))){
        $error_fields[] = 'email';
    }
    if(!(isset($_POST['password']) && strlen($_POST['password']) > 5)){
        $error_fields[] = 'password';
    }
    if(!$error_fields){
        $conn = mysqli_connect("localhost", "root", "", "lib");
        if(!$conn){
            echo mysqli_connect_error();
            exit;
        }

        $name = mysqli_escape_string($conn,$_POST['name']);
        $email = mysqli_escape_string($conn,$_POST['email']);
        $password = sha1($_POST['password']);
        $q = "select * from users where name = '".$name."' or email ='".$email."' limit 1";
        $res = mysqli_query($conn, $q);
        if($row = mysqli_fetch_assoc($res)){
            $error_fields[] = "duplicated email";
        }
        else{
            $q = "insert into users (name, email, password, admin ) values
            ('".$name."', '".$email."', '".$password."', 0 )";

            $res = mysqli_query($conn, $q);
            if($res){
                header("Location: home.php");
                exit;
            }
            else{
                echo mysqli_error($conn);
            }
        }
        
        mysqli_close($conn);
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/form.css">

</head>
<body>
    <header>
        <div class="logo-section">
                <img class="logo"src="imgs/logo.png">
                <span><a class="header-name" href="home.php">Online<br> Library</a></span>
            </div>
    </header>
    <div class="bg">

        <form method="POST"  >
            <h2>User Register Form</h2>
            <?php 
                if(in_array('duplicated email', $error_fields))
                    echo "<p>* This Email is aready taken</p>";
            ?>
            <div class="field">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Name" >
            </div>
            <?php 
                if(in_array('name', $error_fields))
                    echo "<p>* please enter a valid name</p>"
            ?>
            <br>
            <div class="field">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" >
            </div>
            <?php 
                if(in_array('email', $error_fields))
                    echo "<p>* please enter a valid email</p>";
            ?>
            <br>
            <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" >
            </div>
            <?php 
                if(in_array('password', $error_fields))
                    echo "<p>* The password should be at least 6 chars</p>"
            ?>
            
            <br>
            <input type="submit" name="register" value="Register" class="submit">
            
        </form>
    </div>
    <footer>Copyright © <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script> All Rights Reserved</footer>

</body>
</html>