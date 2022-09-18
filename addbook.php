
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
    $id  = filter_var($_SESSION['id']);

    $q = "select * from users where id = ".$id." limit 1";
    $res = mysqli_query($conn, $q); 
    $rowUser = mysqli_fetch_assoc($res);
    mysqli_free_result($res);

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $title = mysqli_escape_string($conn, $_POST['title']);
        $author = mysqli_escape_string($conn, $_POST['author']);
        $edition = mysqli_escape_string($conn, $_POST['edition']);
        $subdate = mysqli_escape_string($conn, $_POST['subdate']);

        if(is_numeric($edition)){
            switch($edition){
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

        $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/library/imgs/books';
        $cover = $title;
        if($_FILES["cover"]["error"] == UPLOAD_ERR_OK){ 
            $tmp_name = $_FILES["cover"]["tmp_name"];
            $cover .= basename($_FILES["cover"]['name']);
            $path = "imgs/books/$cover";
            move_uploaded_file($tmp_name, "$uploads_dir/$cover");
        }
        else{
            echo "file can't be uploaded";
            exit;
        }
        
        $q = "insert into books (title, author, edition, submission_date, photo) values
        ('".$title."', '".$author."', '".$edition."', '".$subdate."', '".$path."')";
        $res = mysqli_query($conn, $q); 

        if($res){
            header("Location: home.php");
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
    <title>Add Book</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/form.css">

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

                    <h2>Add New Book</h2>
                    <div class="field">
                        <label for="title" >Book <br> Title</label>
                        <input type="text" name="title" required>
                    </div>
                    <br>
                    <div class="field">
                        <label for="author">Book Author</label>
                        <input type="text" name="author" required>
                    </div>
                    <br>

                    <div class="field">
                        <label for="edition">Book Edition</label>
                        <input type="text" name="edition" required>
                    </div>
                    <br>

                    <div class="field">
                        <label for="subdate">Submission<br> Date</label>
                        <input type="date" name="subdate" required>
                    </div>
                    <br>

                    <div class="field">
                        <label for="cover">Book <br> Cover</label>
                        <input type="file" name="cover" required>
                    </div>

                    <input type="submit" name="add"  class="submit" value="Add">
                </form>
            </div>

        </div>
        <footer>All copyrights are preserved CC <script type="text/javascript">let year = new Date().getFullYear(); document.write(year);</script></footer>
    </body>
</html>