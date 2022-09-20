<?php
    if($_SERVER['REQUEST_METHOD']=='GET'){
        if(isset($_GET['login'])){
            header("Location: login.php");
            exit;
        }
        else if(isset($_GET['register'])){
            header("Location: register.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/welcome.css">
</head>
    <body>
        <header>
        <div class="logo-section">
                <img class="logo"src="imgs/logo.png">
                <span><a class="header-name" href="home.php">Online <br>Library</a></span>
            </div>
        </header>
        <div class="bg">
            <div class="card">
                <h1 class="txt">Welcome to our Library!</h1>
                <form method="GET">
                <input type="submit" name="login" class="login"value="Login">
                <input type="submit" name="register" class="register" value="Register">
                </form>
            </div>

        </div>
        <footer>Copyright © <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script> All Rights Reserved</footer>
    </body>
</html>