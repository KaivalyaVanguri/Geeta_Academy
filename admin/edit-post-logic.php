<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require './config/database.php';

if (isset($_POST['update'])) {
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    //if (!isset($category)){
     //   $_SESSION['edit-post'] = "File size is large, 2mb max limit.";
    //}
    $body = filter_var($_POST['body']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Check if a new file is provided
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['size'] > 0) {
        // Handle Thumbnail Upload
        $thumbnail = $_FILES['thumbnail'];
        $thumbnail_name = $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {
            // Make sure the image is not too large (2mb+)
            if ($thumbnail['size'] < 2_000_000) {
                // Upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

                // Update the database with the new thumbnail path
                $update_query = "UPDATE posts SET post_title=?, post_category_id=?, post_body=?, post_featured=?, post_thumbnail=? WHERE post_id=?";
                $stmt = mysqli_prepare($connection, $update_query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sisisi", $title, $category, $body, $is_featured, $thumbnail_destination_path, $post_id);
                    mysqli_stmt_execute($stmt);

                    if (!mysqli_errno($connection)) {
                        $_SESSION['edit-post-success'] = "Post updated successfully";
                    } else {
                        if($category == 0){
                            $_SESSION['edit-post'] = "Select a Category";
                        }else{
                            $_SESSION['edit-post'] = "Failed to update post. MySQL Error: " . mysqli_error($connection);
                        }
                    }
                } else {
                    $_SESSION['edit-post'] = "Failed to prepare the statement. MySQL Error: " . mysqli_error($connection);
                }
            } else {
                $_SESSION['edit-post'] = "File size is large, 2mb max limit.";
            }
        } else {
            $_SESSION['edit-post'] = "File must be a png, jpg, jpeg.";
        }
    } else {
        // No new file provided, maintain the existing thumbnail path
        $update_query = "UPDATE posts SET post_title=?, post_category_id=?, post_body=?, post_featured=? WHERE post_id=?";
        $stmt = mysqli_prepare($connection, $update_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sisii", $title, $category, $body, $is_featured, $post_id);
            mysqli_stmt_execute($stmt);

            if (!mysqli_errno($connection)) {
                $_SESSION['edit-post-success'] = "Post updated successfully";
            } else {
                if($category == 0){
                    $_SESSION['edit-post'] = "Select a Category";
                }else{
                    $_SESSION['edit-post'] = "Failed to update post. MySQL Error: " . mysqli_error($connection);
                }
            }
        } else {
            $_SESSION['edit-post'] = "Failed to prepare the statement. MySQL Error: " . mysqli_error($connection);
        }
    }

    // Check if there is a success message in the session
    if (isset($_SESSION['edit-post-success'])) {
        header('location: ' . ROOT_URL . 'admin/index.php');
        die();
    }else{
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id='.$post_id);
        die();
    }
}
?>
