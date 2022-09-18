<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        exit;
    }

    $conn = mysqli_connect("localhost","root", "", "lib");
    if(!$conn){
        echo mysqli_connect_error();
        exit;
    }
    $id = filter_var($_SESSION['id']);
    $q = "select * from users where id = $id";
    
    $result = mysqli_query($conn, $q);
    $rowUser = mysqli_fetch_assoc( $result);

    $q = 'select * from books';
    mysqli_free_result($result);
    if(isset($_GET['title'])){
        $search = mysqli_escape_string($conn,$_GET['title']);
        $q .= " where books.title like '%".$search."%'"; 
    }
    $res = mysqli_query($conn, $q);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/home.css">


</head>
    <body >
        <header>
            <div class="logo-section">
                <img class="logo"src="imgs/logo.png">
                <span><a class="header-name" href="home.php">Online Library</a></span>
            </div>
            <div class="upper-right-btns">
                <a class="profile" href="profileCard.php?id=<?=$rowUser['id']?>"><img class="profile-img"src="imgs/users/<?=$rowUser['avatar']?>"></a>
                <a class="logout" href="logout.php">Logout</a>
            </div>
        </header>

        <div class="bg">
            <form method="GET" > 
                <div class="search-form">
                    <input class ="search-box"type="text" name="title" placeholder="Enter a book title">
                    <input class="search" type="submit" name="submit" value="Search">
                </div>
            </form>
            <br>
            <div class="books-container">
                <?php
                    while($row = mysqli_fetch_assoc($res)){
                ?>
                    <div class="book-card">
                        
                        <img class="bk-img card-element" src="<?=($row['photo'])?>">
                        <p class="title card-element"><?=$row['title']?></p>
                        
                        <a class="moreinfo card-element" href="moreinfo.php?no=<?=$row['no']?>">More Info &#8594</a>

                        <?php
                            if($_SESSION['admin'] == 1){
                        ?>
                        <div class="btns">
                            <a class="edit card-element " href="edit.php?no=<?=$row['no']?>"><img src="imgs/edit-white.png" alt="edit"></a>
                            <a class="delete card-element" href="delete.php?no=<?=$row['no']?>"><img src="imgs/delete-white.png" alt="delete"></a>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php
                   if($_SESSION['admin'] == 1){
                ?>
                    <div class="book-card">
                        <a  href = "addbook.php?id=<?=$rowUser['id']?>"><img class="bk-img add" src="imgs/books/add.png?>" alt="Add"></a>
                        
                    </div>
                 <?php } ?>
            </div>
        </div>
        <footer>All copyrights are preserved CC <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script></footer>

    </body>
</html>