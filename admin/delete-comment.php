<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch post from the database
    $query = "SELECT * FROM comments WHERE comment_id=$id";
    $result = mysqli_query($connection, $query);
    //make sure only 1 record was fetched
    if (mysqli_num_rows($result) == 1){
        $comment = mysqli_fetch_assoc($result);
        //delete comment from database
        $delete_comment_query ="DELETE FROM comments WHERE comment_id=$id LIMIT 1";
        $delete_comment_result = mysqli_query($connection, $delete_comment_query);
    }
    if(!mysqli_errno($connection)){
        $_SESSION['delete-comment-success'] = "Comment deleted successfully";
    }else{
        $_SESSION['delete-comment'] = "Comment not deleted ";
    }
}
header('location: '.ROOT_URL.'admin/manage-comments.php');
die();
?>