<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require './config/database.php';

if (isset($_POST['update'])) {
    $comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
    $comment_text = filter_var($_POST['comment']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_hidden = isset($_POST['is_hidden']) ? 1 : 0;

    $update_query = "UPDATE comments SET comment_text=?, comment_featured=?, comment_hide=? WHERE comment_id=?";
    $stmt = mysqli_prepare($connection, $update_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "siii", $comment_text, $is_featured, $is_hidden, $comment_id);
            mysqli_stmt_execute($stmt);

            if (!mysqli_errno($connection)) {
                $_SESSION['edit-comment-success'] = "Comment updated successfully";
            } else {
                $_SESSION['edit-comment'] = "Failed to update post. MySQL Error: " . mysqli_error($connection);
            }
        } else {
            $_SESSION['edit-comment'] = "Failed to prepare the statement. MySQL Error: " . mysqli_error($connection);
        }
    }

    // Check if there is a success message in the session
    if (isset($_SESSION['edit-comment-success'])) {
        header('location: ' . ROOT_URL . 'admin/manage-comments.php');
        die();
    }else{
        header('location: ' . ROOT_URL . 'admin/edit-comment.php?id='.$comment_id);
        die();
    }

?>
