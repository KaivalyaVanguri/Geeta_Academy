<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $user_id = $_SESSION['user-id'];
    $body = filter_var($_POST['comment']);
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = filter_var($_POST['user_avatar']);
    $query = "SELECT post_title FROM posts WHERE post_id = $post_id";
    $result = mysqli_query($connection, $query);
    $post_title = mysqli_fetch_assoc($result);


    //validate form data
    if(!$body){
        $_SESSION['comment-section'] = 'Enter comment';
    }else{
        $time = time();
        $thumbnail_destination_path = $thumbnail;
    }
    //redirect back (with form data) to add-post page if there is any problem
    if(isset($_SESSION['comment-section'])){
        $_SESSION['comment-section-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        die();
    }else{
        $query = "INSERT INTO comments (comment_user_id, comment_user_avatar, comment_published_at, comment_updated_at, comment_likes, comment_text, comment_featured, comment_hide, comment_post_id) VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 0, ?, 0, 0, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "issi", $user_id, $thumbnail_destination_path, $body, $post_id);
        mysqli_stmt_execute($stmt);

        if(mysqli_errno($connection)){
            $_SESSION['add-comment'] = "Failed to add comment.";
        }else{
            $_SESSION['add-comment-success'] = "Comment added at $post_title successfully";
            header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
            die();
        }
    }
}
header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
die();
?>