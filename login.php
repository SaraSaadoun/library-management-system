<?php
    session_start();
    $error_fields = array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
       $conn = mysqli_connect('localhost', 'root', '', 'lib');
       if(!$conn){
        echo mysqli_connect_error();
        exit;
       }

       $email = mysqli_escape_string($conn, $_POST['email']);
       $password = sha1($_POST['password']);

       $q = "select * from users where users.email = '".$email."' and users.password = '".$password."' limit 1 "; 
       $res = mysqli_query($conn, $q);
       if($row = mysqli_fetch_assoc($res)){
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['admin'] = $row['admin'];

            header("Location: home.php");
            exit;
        }
        else{
            $error_fields[] = 'invalid';
        }

       mysqli_free_result($res);
       mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/form.css">

</head>
<body>
    <header>
        <div class="logo-section">
                <img class="logo"src="imgs/logo.png">
                <span><a class="header-name" href="home.php">Online <br>Library</a></span>
            </div>
    </header>
    <div class="bg">
        <form method="POST">
            <h2>User Login Form</h2>
            <?php 
                if($error_fields){
                    echo '<p>Invalid email or password</p> <br>';
                }
            ?>
            <div class="field">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email">
            </div>
            <br>
            <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password">
            </div>
            <br>
            <div class="field">
            <input type="submit" name="login" value="login" class="submit">
            </div>
        </form>
    </div>
    <footer>Copyright © <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script> All Rights Reserved</footer>

</body>
</html>