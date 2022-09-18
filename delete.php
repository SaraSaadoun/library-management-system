<?php 
     $conn = mysqli_connect("localhost", "root", "", "lib");
     if(!$conn){
         echo mysqli_connect_error();
         exit;
     }
     $id = filter_input(INPUT_GET, 'no', FILTER_SANITIZE_NUMBER_INT);
     $q = "delete from books where no =" .$id. " limit 1";
 
     if(mysqli_query($conn, $q)){
        header("Location: home.php");
        exit;
    }
    else {
        echo mysqli_error($conn);
    }
    mysqli_close($conn);