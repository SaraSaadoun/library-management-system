
<?php
    
    session_start();
    if(!(isset($_SESSION['admin']) && $_SESSION['admin'] == 1)){
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

    $no = filter_input(INPUT_GET, 'no', FILTER_SANITIZE_NUMBER_INT);
    $q = "select * from books where no = $no limit 1";
    $res = mysqli_query($conn, $q); 
    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);

    $path = $row['photo'];

    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        $title = mysqli_escape_string($conn, $_POST['title']);
        $author = mysqli_escape_string($conn, $_POST['author']);
        $edition = mysqli_escape_string($conn, $_POST['edition']);
        $flag = 0 ;
        if(is_numeric($edition)){
            $end = substr($edition, -2);
            if(strlen($edition)>=2){
               if($end >= 11 && $end <= 13){
                    $edition .= 'th';
                    $flag = 1;
               }
            }
            if(!$flag){
                $end = substr($edition, -1);
                switch($end){
                    case 1 :
                        $edition .= 'st';
                        break;
                    case 2 :
                        $edition .= 'nd';
                        break;
                    case 3 :
                        $edition .= 'rd';
                        break;
                    default :
                        $edition .= 'th';
                        break;
                }
            }
        }

        $subdate =  $_POST['subdate'];
        
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/library/imgs/books';
        $cover = $title;
        if($_FILES["cover"]["error"] == UPLOAD_ERR_OK){ 
            $q = "select * from book where no = $no limit 1";
            $tmp_name = $_FILES["cover"]["tmp_name"];
            $cover .= basename($_FILES["cover"]['name']);
            $path = "imgs/books/$cover";
            move_uploaded_file($tmp_name, "$uploads_dir/$cover");
        }
        
        $q = "update books set title = '".$title."', author = '".$author."', edition = '".$edition."', submission_date = '".$subdate."', photo = '".$path."' where books.no = $no" ;
        $res = mysqli_query($conn, $q); 
        if($res){
            header("Location: moreinfo.php?no=$no");
            exit;
        }
        else{
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
    <title>Edit Book</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/edit.css">
    

</head>
    <body>
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
            <div class="card">
                <form method="post" enctype="multipart/form-data">                    
                    <div class="left">
                        <img class="cover" src="<?=$row['photo']?>">
                        <div class="field">
                            <input type="file" name="cover"  value="<?=isset($row['photo'])?$row['photo'] : ''?>">
                        </div>
                    </div>
                    <div class="right">
                        <div class="field">
                            <label for="title" >Book <br> Title</label>
                            <input type="text" name="title" required value="<?=isset($row['title'])? $row['title']:'';?>">
                        </div>
                    
                        <br>
                        <div class="field">
                            <label for="author">Book Author</label>
                            <input type="text" name="author" required value="<?=isset($row['author'])?$row['author'] : ''?>">
                        </div>
                        <br>
                        <div class="field">
                            <label for="edition">Book Edition</label>
                            <input type="text" name="edition" required value="<?=isset($row['edition'])?$row['edition'] : ''?>">
                        </div>
                        <br>
                        <div class="field">
                            <label for="subdate">Submission<br> Date</label>
                            <input type="date" name="subdate" required value="<?=isset($row['submission_date'])?substr($row['submission_date'],0, 10) : ''?>">
                        </div>
                        <br>
                        
                        <input type="submit" name="save"  class="submit" value="Save">
                    </div>
                </form>
            </div>

        </div>
        <footer>All copyrights are preserved CC <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script></footer>
        
    </body>
</html>