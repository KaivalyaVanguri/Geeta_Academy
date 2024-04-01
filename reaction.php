<?php
require 'config/database.php';

if(isset($_POST['like'])){
    $comment_id = $_POST['comment_id']; 
    $post_id = $_POST['post_id'];
    $query = "SELECT * FROM comments WHERE comment_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $comment_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cui = mysqli_fetch_assoc($result);
    $cuid = $cui['comment_user_id'];
    if ($cuid != $_SESSION['user-id']){
        $query = "UPDATE comments SET comment_likes = comment_likes + 1 WHERE comment_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $comment_id);
        mysqli_stmt_execute($stmt);
    }elseif($cuid['comment_user_id'] == $_SESSION['user-id']){
        $_SESSION['like-comment'] = "You can't react to your own content";
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        die();
    }
}elseif(isset($_POST['dislike'])){
    $comment_id = $_POST['comment_id']; 
    $post_id = $_POST['post_id'];
    $query = "SELECT * FROM comments WHERE comment_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $comment_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cui = mysqli_fetch_assoc($result);
    $cuid = $cui['comment_user_id'];
    if ($cuid != $_SESSION['user-id']){
        $query = "UPDATE comments SET comment_likes = comment_likes - 1 WHERE comment_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $comment_id);
        mysqli_stmt_execute($stmt);
    }elseif($cuid == $_SESSION['user-id']){
        $_SESSION['like-comment'] = "You can't react to your own content";
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        die();
    }
    
}else{
    if(mysqli_errno($connection)){
        $_SESSION['like-comment'] = "Failed to react.";
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        die();
    }else{
        $_SESSION['like-comment-success'] = "reacted successfully";
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        die();
    }
}
header('location: '. ROOT_URL . 'post.php?id=' . $post_id);
die();
?>